<?php

namespace PruebasGenerator;

use function foo\func;
use PruebasGenerator\Preprocess\ProtoPrueba;
use Symfony\Component\Yaml\Exception\ParseException;
use League\Pipeline\Pipeline;
use Symfony\Component\Yaml\Yaml;

function main() {
	$ymlFile = "../raw/preguntas.yml";

	try {
		$protoPrueba = processRawText($ymlFile);
	} catch (ParseException $exception) {
		die("Error en parseo de yml: ".$exception->getTraceAsString());
	}
}

function processRawText(string $textFilePath): ProtoPrueba /*throws ParseException*/ {
	return (new Pipeline)
		->pipe(function (string $textFilePath) {
			return Yaml::parseFile($textFilePath);
		})
		->pipe(function ($ymlParsed) {
			return $ymlParsed["preguntas"] ;
		})
		->pipe(function ($preguntas) {

		})
		->process($textFilePath);
}