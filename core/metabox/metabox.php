<?php
namespace Stencil\Core\Metabox;


use Stencil\Core\Data;

class Metabox {

	protected $group;
	protected $name;
	protected $title;
	protected $description;
	protected $icon;
	protected $options = [];

	public function compose() {
		
	}

	protected function add_option($options) {
		$this->options[] = $options;
	}

	protected function add_template($option_id, $template, $args = []) {
		$this->options[] = array_merge([
			'id' => $option_id,
			'type' => 'select',
			'options' => Data::instance()->designs($template)
		], $args);
	}

	public function options() {
		return array_merge($this->controls(), $this->options);
	}

	public function group() {
		return $this->group;
	}
	public function name() {
		return $this->name;
	}
	
	public function title() {
		return $this->title;
	}

	public function description() {
		return $this->description;
	}

	public function icon() {
		return $this->icon;
	}

	public function controls() {
		return [];
	}
}