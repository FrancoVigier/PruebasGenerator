<?php

namespace PruebasGenerator\Process;

class FinalPrueba {
	public $PREGUNTAS = [];

	/* @var $preguntas FinalPregunta[] */
	public function __construct(array $preguntas) {
		$this->PREGUNTAS = $preguntas;
	}
}