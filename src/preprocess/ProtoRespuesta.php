<?php

namespace PruebasGenerator\Preprocess;

class ProtoRespuesta {
	public $TEXT = "";
	public $IS_CORRECT = false;

	public function __construct(string $text, bool $isCorrect) {
		$this->TEXT = $text;
		$this->IS_CORRECT = $isCorrect;
	}
}
