<?php

namespace PruebasGenerator;

use PHPUnit\Framework\TestCase;

class ArrayUtilsTest extends TestCase {
	public function testCheckordefault() {
		$array = [10, 20, 30, 40, 50, 60];

		$key = 2;
		$dflt = 0;

		$arraycheck = new ArrayUtils();

		$this->assertEquals(30, $arraycheck->checkOrDefault($key, $array, $dflt));

		$key = 10;

		$this->assertEquals($dflt, $arraycheck->checkOrDefault($key, $array, $dflt));
	}
}
