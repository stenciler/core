<?php

namespace Stencil\Editor;

if ( !defined( 'ABSPATH' ) ) exit;

class Editor {


	public function __construct() {
		$template = Template::instance();
		$metadata = Metadata::instance();
	}


	/******************************
	*
	*******************************/
	private static $instance;
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	public function __clone() {
		_doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', 'stencil'), '1.6');
	}
	public function __wakeup() {
		_doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', 'stencil'), '1.6');
	}
}
Editor::instance();