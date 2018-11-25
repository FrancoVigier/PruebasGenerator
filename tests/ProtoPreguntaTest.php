<?php

namespace PruebasGenerator\Preprocess;

use PHPUnit\Framework\TestCase;

class ProtoPreguntaTest extends TestCase {

	public function testPregunta() {

		$pregunta = "Edad de la tierra?";
		$respuestas = [1, 2, 3, 4, 5];
		$hasAllCorrect = False;
		$hasNoCorrect = False;
		$hasSpecialAll = " ";
		$hasSpecialNoCorrect = " ";


		$protopregunta = new ProtoPregunta($pregunta, $respuestas, $hasAllCorrect, $hasNoCorrect, $hasSpecialAll, $hasSpecialNoCorrect, false, false);

		$this->assertEquals($pregunta, $protopregunta->PREGUNTA);
		$this->assertEquals($respuestas, $protopregunta->RESPUESTAS);
	}
}
