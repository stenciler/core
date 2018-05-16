<?php
namespace Stencil\Core\Field;


class Wysiwyg  extends Field_Base {

	public function enqueue_scripts() {
		wp_enqueue_style( 'field-wysiwyg', STL_ASSET_URL . 'css/field/wysiwyg.css', array(), STL_VERSION );
		wp_enqueue_script( 'field-wysiwyg', STL_ASSET_URL . 'js/field/wysiwyg.js', array( 'jquery' ), STL_VERSION, true );
	}


	public function show($field_id, $args) {
		$value = '';
		if(isset($args['value'])) {
			$value = $args['value'];
		}
		$args = array_merge([
			'editor_class' => 'field-wysiwyg',
			'options' => [
				'editor_class' => 'field-wysiwyg',
			]
		], $args);
		ob_start();
		wp_editor( $value, $field_id, $args );
		return ob_get_clean();
	}
}
	