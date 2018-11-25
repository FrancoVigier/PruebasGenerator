<?php

namespace PruebasGenerator;

use PruebasGenerator\Preprocess\ProtoPregunta;
use PruebasGenerator\Preprocess\ProtoPrueba;
use PruebasGenerator\Preprocess\ProtoRespuesta;
use PruebasGenerator\Process\FinalPrueba;
use Symfony\Component\Yaml\Exception\ParseException;
use League\Pipeline\Pipeline;
use Symfony\Component\Yaml\Yaml;

class Main {
	/* @var $temas FinalPrueba[] */
	public static function generatePage(string $materia, string $date,
		array $temas, int $temaIndex, bool $isKey, bool $showHeader): string {
		$twigTemplate = new TwigTemplateLoader();

		return $twigTemplate->render("prueba.html.twig",
			array(
				"documentRoot" => $_SERVER['DOCUMENT_ROOT'],
				"showHeader" => $showHeader,
				"showBackButton" => $temaIndex != 0,
				"showFowardButton" => $temaIndex != count($temas)-1,
				"materia" => $materia,
				"date" => $date,
				"key" => $isKey,
				"temaLetter" => chr($temaIndex + ord('A')),
				"prueba" => $temas[$temaIndex]
			)
		);
	}

	/* @return FinalPrueba[] */
	public static function generatePrueba(int $numberTemas): array {
		$ymlFile = $_SERVER['DOCUMENT_ROOT'] . "/../raw/preguntas.yml";

		try {
			$protoPrueba = Main::processRawText($ymlFile);
		} catch (ParseException $exception) {
			die("Error en parseo de yml: " . $exception->getTraceAsString());
		}

		return ParseFinal::generatePruebaFinal($numberTemas, $protoPrueba);
	}

	public static function processRawText(string $textFilePath): ProtoPrueba /*throws ParseException*/ {
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

	public static function processPregunta(array $pregunta): ProtoPregunta {
		return (new Pipeline())
			->pipe(function ($pregunta) {
				$hasAllCorrect = ArrayUtils::checkOrDefault
				("ocultar_opcion_todas_las_anteriores", $pregunta, false);
				$hasNoCorrect = ArrayUtils::checkOrDefault
				("ocultas_opcion_ninguna_de_las_anteriores", $pregunta, false);
				$hasSpecialAll = ArrayUtils::checkOrDefault
				("texto_todas_las_anteriores", $pregunta, NULL);
				$hasSpecialNoCorrect = ArrayUtils::checkOrDefault
				("texto_ninguna_de_las_anteriores", $pregunta, NULL);
				$isAllCorrect = $pregunta["respuestas_incorrectas"] == [];
				$isNoCorrect = $pregunta["respuestas_correctas"] == [];

				return new ProtoPregunta(
					$pregunta["descripcion"],
					Main::processRespuestas($pregunta["respuestas_correctas"], $pregunta["respuestas_incorrectas"]),
					$hasAllCorrect,
					$hasNoCorrect,
					$hasSpecialAll,
					$hasSpecialNoCorrect,
					$isAllCorrect,
					$isNoCorrect
				);
			})
			->process($pregunta);
	}

	public static function processRespuestas(array $correctRespuestasRaw,
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

}
