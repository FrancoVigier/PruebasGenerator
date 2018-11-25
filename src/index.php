<?php

namespace PruebasGenerator;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * This file is not added to the composer autoloader, it is for calling the function
 * from a browser.
 */
if(!isset($_GET["materia"]) && !isset($_GET["fecha"]) && !isset($_GET["howMany"])) {
	readfile($_SERVER['DOCUMENT_ROOT'].'/templates/form_initial.html');
} else {
	$prueba = Main::generatePrueba($_GET["howMany"]);
	echo Main::generatePage($_GET["materia"], $_GET["fecha"], $prueba, 1, true);
}