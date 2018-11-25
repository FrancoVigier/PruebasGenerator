<?php

namespace PruebasGenerator\Preprocess;

use PHPUnit\Framework\TestCase;

class ProtoRespuestaTest extends TestCase {

	public function testTexto() {
		$texto = "pregunta";
		$escorrecta = False;

		$protorespuesta = new ProtoRespuesta ($texto, $escorrecta);
		$this->assertEquals($texto, $protorespuesta->TEXT);
	}

	public function testEscorrecta() {
		$texto = "pregunta";
		$escorrecta = False;

		$protorespuesta = new ProtoRespuesta ($texto, $escorrecta);
		$this->assertEquals($escorrecta, $protorespuesta->IS_CORRECT);
	}
}
