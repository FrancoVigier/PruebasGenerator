<?php

namespace PruebasGenerator;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * This file is not added to the composer autoloader, it is for calling the function
 * from a browser.
 */
$prueba = Main::generatePrueba(4);
echo Main::generatePage($prueba, 1, false);