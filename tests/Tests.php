<?php

use PHPUnit\Framework\TestCase;

use function PruebasGenerator\main;

class Tests extends TestCase {
		public function testMain() {
			main(3);
		}
}
