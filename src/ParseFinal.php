<?php

namespace PruebasGenerator;

use League\Pipeline\Pipeline;
use PruebasGenerator\Preprocess\ProtoPregunta;
use PruebasGenerator\Preprocess\ProtoPrueba;
use PruebasGenerator\Preprocess\ProtoRespuesta;
use PruebasGenerator\Process\FinalPregunta;
use PruebasGenerator\Process\FinalPrueba;
use PruebasGenerator\Process\FinalRespuesta;

class ParseFinal {
	public static function generatePruebaFinal(int $numberTemas, ProtoPrueba $prueba) {
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
				->pipe(function (ProtoPrueba $protoPrueba) {
					return self::generateKey($protoPrueba);
				})
				->process(clone $prueba);
		}

		return $temas;
	}

	public static function generateKey(ProtoPrueba $prueba): FinalPrueba {
		$preguntas = [];

		for ($i = 0; $i < count($prueba->PREGUNTAS); $i++) {
			/* @var $pregunta ProtoPregunta */
			$pregunta = $prueba->PREGUNTAS[$i];

			$correctLetters = [];
			$respuestas = [];

			$j = 0;
			for (; $j < count($pregunta->RESPUESTAS); $j++) {
				/* @var $respuesta ProtoRespuesta */
				$respuesta =  $pregunta->RESPUESTAS[$j];

				$letter = chr(ord("A") + $j);
				$respuestas[] = new FinalRespuesta($letter, $respuesta->TEXT);

				if(!$pregunta->IS_ALL_CORRECT && !$pregunta->IS_NO_CORRECT
					&& $respuesta->IS_CORRECT) {
					$correctLetters[] = $letter;
				}
			}

			if($pregunta->HAS_ALL_CORRECT) {
				$letter = chr(ord("A") + ++$j);
				$respuestaText = "";

				if($pregunta->HAS_SPECIAL_ALL != null) {
					$respuestaText = $pregunta->HAS_SPECIAL_ALL;
				} else {
					$respuestaText = "Todas correctas";
				}

				$respuestas[] = new FinalRespuesta($letter, $respuestaText);

				if($pregunta->IS_ALL_CORRECT) {
					$correctLetters[] = $letter;
				}
			}

			if($pregunta->HAS_NO_CORRECT) {
				$letter = chr(ord("A") + ++$j);
				$respuestaText = "";

				if($pregunta->HAS_SPECIAL_NO_CORRECT != null) {
					$respuestaText = $pregunta->HAS_SPECIAL_NO_CORRECT;
				} else {
					$respuestaText = "Todas incorrectas";
				}

				$respuestas[] = new FinalRespuesta($letter, $respuestaText);

				if($pregunta->IS_NO_CORRECT) {
					$correctLetters[] = $letter;
				}
			}

			$preguntas[] = new FinalPregunta($i+1, implode(" & ", $correctLetters),
				$pregunta->PREGUNTA, $respuestas);
		}

		return new FinalPrueba($preguntas);
	}
}