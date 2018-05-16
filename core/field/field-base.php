<?php
namespace Stencil\Core\Field;


class Field_Base  {

	public  function enqueue_scripts() {
		
	}


	public function normalize($args) {
		return $args;
	}

	public function show($field_id, $args) {
		return '';
	}
	public function value($args) {
		if(isset($args['value'])) {
			return $args['value'];
		}
	}

	public function description($args) {

	}
}