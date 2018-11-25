<?php

namespace PruebasGenerator;


require_once __DIR__ . '/../vendor/autoload.php';

/**
 * This file is not added to the composer autoloader, it is for calling the function
 * from a browser.
 */

session_start();

if(!isset($_GET["materia"]) && !isset($_GET["fecha"]) && !isset($_GET["howMany"])) {
	readfile($_SERVER['DOCUMENT_ROOT'].'/templates/form_initial.html');
} else {
	$showHeader = !(isset($_GET["isDownload"]) && $_GET["isDownload"]);

	if(!isset($_SESSION["prueba"])) {
		$_SESSION["prueba"] = Main::generatePrueba($_GET["howMany"]);
	}

	$prueba = $_SESSION["prueba"];

	$temaIndex = 0;
	if(isset($_GET["temaIndex"])) {
		$temaIndex = $_GET["temaIndex"];
	}

	$key = true;
	if(isset($_GET["key"])) {
		$key = $_GET["key"];
	}


	echo Main::generatePage($_GET["materia"], $_GET["fecha"], $prueba,
		$temaIndex, $key, $showHeader);
}