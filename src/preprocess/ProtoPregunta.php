<?php

namespace PruebasGenerator\Preprocess;

class ProtoPregunta {
	public $PREGUNTA = "";
	public $RESPUESTAS = [];
	public $HAS_ALL_CORRECT = false;
	public $HAS_NO_CORRECT = false;
	public $HAS_SPECIAL_ALL = NULL;
	public $HAS_SPECIAL_NO_CORRECT = NULL;
	public $IS_ALL_CORRECT = false;
	public $IS_NO_CORRECT = false;

	public function __construct(
			string $pregunta, array $respuestas, bool $hasAllCorrect,
			bool $hasNoCorrect, $hasSpecialAll, $hasSpecialNoCorrect,
			bool $isAllCorrect, bool $isNoCorrect) {
		$this->PREGUNTA = $pregunta;
		$this->RESPUESTAS = $respuestas;
		$this->HAS_ALL_CORRECT = $hasAllCorrect;
		$this->HAS_NO_CORRECT = $hasNoCorrect;
		$this->HAS_SPECIAL_ALL = $hasSpecialAll;
		$this->HAS_SPECIAL_NO_CORRECT = $hasSpecialNoCorrect;
		$this->IS_ALL_CORRECT = $isAllCorrect;
		$this->IS_NO_CORRECT = $isNoCorrect;
	}

	function __clone() {
		$this->RESPUESTAS = array_map(function ($elem) {
			return clone $elem;
		}, $this->RESPUESTAS);
	}
}
