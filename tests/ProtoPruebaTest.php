<?php

namespace PruebasGenerator\Preprocess;

use PHPUnit\Framework\TestCase;

class ProtoPruebaTest extends TestCase {

	public function testPregunta() {
		$preguntas = ["1", "2", "3"];
		$protoprueba = new ProtoPrueba ($preguntas);
		$this->assertEquals($preguntas, $protoprueba->PREGUNTAS);
	}

}
