<?php

namespace PruebasGenerator;

class ArrayUtils {
	public static function checkOrDefault($key, array $array, $dflt) {
		if(array_key_exists($key, $array)) {
			return $array[$key];
		}
		return $dflt;
	}
}