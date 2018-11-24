<?php

namespace PruebasGenerator\Preprocess;

class ProtoPregunta {
	public $PREGUNTA = "";
	public $RESPUESTAS = [];
	public $HAS_ALL_CORRECT = false;
	public $HAS_NO_CORRECT = false;
	public $HAS_SPECIAL_ALL = NULL;
	public $HAS_SPECIAL_NO_CORRECT = NULL;

	public function __construct(
			string $pregunta, array $respuestas, bool $hasAllCorrect,
			bool $hasNoCorrect, string $hasSpecialAll, string $hasSpecialNoCorrect) {
		$this->PREGUNTA = $pregunta;
		$this->RESPUESTAS = $respuestas;
		$this->HAS_ALL_CORRECT = $hasAllCorrect;
		$this->HAS_NO_CORRECT = $hasNoCorrect;
		$this->HAS_SPECIAL_ALL = $hasSpecialAll;
		$this->HAS_SPECIAL_NO_CORRECT = $hasSpecialNoCorrect;
	}

	function __clone() {
		$this->RESPUESTAS = array_map(function ($elem) {
			return clone $elem;
		}, $this->RESPUESTAS);
	}
	
	public function pregunta() {
		return $this->PREGUNTA;
	
	}
	public function respuesta() {
		return $this->RESPUESTAS;
	
	}
	
	
}
