<?php

namespace PruebasGenerator\Process;

class FinalPregunta {
	public $NUMBER = 0;
	public $CORRECT_LETTERS = "";
	public $TEXT = "";
	public $RESPUESTAS = [];

	/*
	 * @var $respuestas FinalRespuesta[]
	 */
	public function __construct(int $number, string $correctLetters,
		string $text, array $respuestas) {
		$this->NUMBER = $number;
		$this->CORRECT_LETTERS = $correctLetters;
		$this->TEXT = $text;
		$this->RESPUESTAS = $respuestas;
	}
}