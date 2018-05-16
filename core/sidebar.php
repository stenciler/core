<?php
namespace Stencil\Core;

if ( !defined( 'ABSPATH' ) ) exit;



use Stencil\Core\Sidebar\Manager;
use Stencil\Core\Sidebar\Registry;


class Sidebar {

	
	protected $registry;
	protected $manager;

	public function __construct() {
		$this->registry = Registry::instance();
		$this->manager = Manager::instance();
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

