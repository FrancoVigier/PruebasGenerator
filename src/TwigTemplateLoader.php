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
		$this->loader = new Twig_Loader_Filesystem($_SERVER['DOCUMENT_ROOT'].'/templates');
		$this->twig = new Twig_Environment($this->loader);
	}

	public function render(string $templateName, array $params) {
		return $this->twig->load($templateName)->render($params);
	}
}