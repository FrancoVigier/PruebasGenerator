<?php

namespace PruebasGenerator;

use PruebasGenerator\Preprocess\ProtoPregunta;
use PruebasGenerator\Preprocess\ProtoPrueba;
use PruebasGenerator\Preprocess\ProtoRespuesta;
use Symfony\Component\Yaml\Exception\ParseException;
use League\Pipeline\Pipeline;
use Symfony\Component\Yaml\Yaml;

class Main {
	public static function generatePage(int $numberTemas): string {
		$twigTemplate = new TwigTemplateLoader();

		$ymlFile = $_SERVER['DOCUMENT_ROOT'] . "/../raw/preguntas.yml";

		try {
			$protoPrueba = Main::processRawText($ymlFile);
		} catch (ParseException $exception) {
			die("Error en parseo de yml: " . $exception->getTraceAsString());
		}

		$temas = Main::generateTemas($numberTemas, $protoPrueba);

		return $twigTemplate->render("prueba.html.twig",
			array(
				"temp" => "sdfsd",
				"navigation" => [5, 6]
			)
		);
	}

	private static function processRawText(string $textFilePath): ProtoPrueba /*throws ParseException*/ {
		return (new Pipeline)
			->pipe(function (string $textFilePath) {
				return Yaml::parseFile($textFilePath);
			})
			->pipe(function ($ymlParsed) {
				return $ymlParsed["preguntas"];
			})
			->pipe(function ($preguntas) {
				return array_map(function ($pregunta) {
					return Main::processPregunta($pregunta);
				}, $preguntas);
			})
			->pipe(function ($preguntas) {
				return new ProtoPrueba($preguntas);
			})
			->process($textFilePath);
	}

	private static function processPregunta(array $pregunta): ProtoPregunta {
		return (new Pipeline())
			->pipe(function ($pregunta) {
				$hasAllCorrect = !ArrayUtils::checkOrDefault
				("ocultar_opcion_todas_las_anteriores", $pregunta, false);
				$hasNoCorrect = !ArrayUtils::checkOrDefault
				("ocultas_opcion_ninguna_de_las_anteriores", $pregunta, false);
				$hasSpecialAll = !ArrayUtils::checkOrDefault
				("texto_todas_las_anteriores", $pregunta, NULL);
				$hasSpecialNoCorrect = !ArrayUtils::checkOrDefault
				("texto_ninguna_de_las_anteriores", $pregunta, NULL);

				return new ProtoPregunta(
					$pregunta["descripcion"],
					Main::processRespuestas($pregunta["respuestas_correctas"], $pregunta["respuestas_incorrectas"]),
					$hasAllCorrect,
					$hasNoCorrect,
					$hasSpecialAll,
					$hasSpecialNoCorrect
				);
			})
			->process($pregunta);
	}

	private static function processRespuestas(array $correctRespuestasRaw,
		array $wrongRespuestasRaw): array {
		return (new Pipeline())
			->pipe(function ($respuestas) {
				$correctRespuestasRaw = $respuestas[0];
				$wrongRespuestasRaw = $respuestas[1];

				$respuestas = [];

				foreach ($correctRespuestasRaw as $correctRespuesta) {
					$respuestas[] = new ProtoRespuesta($correctRespuesta, true);
				}

				foreach ($wrongRespuestasRaw as $wrongRespuesta) {
					$respuestas[] = new ProtoRespuesta($wrongRespuesta, false);
				}

				return $respuestas;
			})
			->process(array($correctRespuestasRaw, $wrongRespuestasRaw));
	}

	private static function generateTemas(int $numberTemas, ProtoPrueba $protoPrueba): array {
		$temas = [];

		for ($i = 0; $i < $numberTemas; $i++) {
			$temas[] = (new Pipeline)
				->pipe(function (ProtoPrueba $protoPrueba) {
					shuffle($protoPrueba->PREGUNTAS);
					return $protoPrueba;
				})
				->pipe(function (ProtoPrueba $protoPrueba) {
					/* @var $pregunta ProtoPregunta */
					foreach ($protoPrueba->PREGUNTAS as $pregunta) {
						shuffle($pregunta->RESPUESTAS);
					}
					return $protoPrueba;
				})
				->process(clone $protoPrueba);
		}

		return $temas;
	}

}