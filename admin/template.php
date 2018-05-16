<?php

namespace Stencil\Admin;

if ( !defined( 'ABSPATH' ) ) exit;

class Template {

	protected $template;
	
	public function __construct() {
		$this->admin();
	}


	public function admin() {
		//add_action( 'admin_menu', array($this, 'menu'), 16);
	}

	public function menu() {
		add_menu_page( 'Templates', 'Templates', 'manage_options', 'template-main', array($this, 'view'), 'dashicons-admin-generic' );
		

	}

	public function view() {


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

