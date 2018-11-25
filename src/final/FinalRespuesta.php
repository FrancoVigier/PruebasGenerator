<?php

namespace PruebasGenerator\Process;

use PruebasGenerator\Preprocess\ProtoRespuesta;

class FinalRespuesta {
	public $LETTER = "";
	public $TEXT = "";

	public function __construct(string $letter, string $text) {
		$this->LETTER = $letter;
		$this->TEXT = $text;
	}
}