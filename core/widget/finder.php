<?php

namespace Stencil\Core\Widget;

if ( !defined( 'ABSPATH' ) ) exit;

use Stencil\Core\Widget\Manager;
class Finder  {

	protected $manager;

	public function __construct() {
		$this->manager = Manager::instance();
	}

	public function find($id) {
		if(null !== $widget = $this->manager->get($id)) {
			return $widget;
		}
	}



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