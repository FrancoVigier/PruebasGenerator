<?php

namespace PruebasGenerator\Preprocess;

class ProtoPrueba {
	public $PREGUNTAS = [];

	public function __construct(array $preguntas) {
		$this->PREGUNTAS = $preguntas;
	}

	function __clone() {
		$this->PREGUNTAS = array_map(function ($elem) {
			return clone $elem;
		}, $this->PREGUNTAS);
	}
}
