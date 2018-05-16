<?php
namespace Stencil\Core\Template;

use Stencil\Core\Template_Engine;

class Render  {


	public $design;
	public $markup;
	public $values = [];

	public function __construct($design = false) {
		$this->design = $design;
	}
	public function values($values) {
		$this->values = $values;
		return $this;
	}

	public function design($design) {
		$this->design = $design;
		return $this;
	}

	public function markup($markup) {
		$this->markup = $markup;
		return $this;
	}

	public function render($args = []) {
		if($this->design) {
			$args = array_merge($this->values, $args);
			return Template_Engine::instance()->render($this->markup, $args);
		}
	}
}