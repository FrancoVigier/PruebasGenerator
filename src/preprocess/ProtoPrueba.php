<?php

namespace PruebasGenerator\Preprocess;

class ProtoPrueba {
	public $PREGUNTAS = [];

	public function __construct(array $preguntas) {
		$this->PREGUNTAS = $preguntas;
	}
}