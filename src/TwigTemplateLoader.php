<?php

namespace PruebasGenerator;

use Twig_Environment;
use Twig_Error;
use Twig_Loader_Filesystem;
use Twig_TemplateWrapper;

class TwigTemplateLoader {
	private $loader;
	private $twig;

	public function __construct() {
		$this->loader = new Twig_Loader_Filesystem('src/templates');
		$this->twig = new Twig_Environment($this->loader);
	}

	private function load(string $templateName): Twig_TemplateWrapper {
		try {
			return $this->twig->load($templateName);
		} catch (Twig_Error $e) {
			die("Twig error: ".$e->getTraceAsString());
		}
	}

	public function render(string $templateName, array $params) {
		return $this->load($templateName)->render($params);
	}
}