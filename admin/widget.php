<?php

namespace Stencil\Admin;

if ( !defined( 'ABSPATH' ) ) exit;

use Stencil\Core\Template;
use Stencil\Core\Widget as Widget_Core;

class Widget {

	protected $template;
	protected $widget;

	public function __construct() {
		$this->template = Template::instance();
		$this->widget = Widget_Core::instance();
		$this->redirect();
		$this->admin();
	}


	public function admin() {
		add_action( 'admin_menu', array($this, 'menu'), 16);
	}

	public function menu() {
		add_menu_page( 'Widgets', 'Widgets', 'manage_options', 'widget-main', array($this, 'view'), 'dashicons-admin-generic' );
		
		
	}

	public function view() {


	}
	
	public function redirect() {
		global $pagenow;
		add_action( 'admin_init', function() use($pagenow) {
			if($pagenow === 'post-new.php' && isset($_GET['post_type']) && $_GET['post_type'] == 'stencil_widget') {
				wp_safe_redirect(admin_url( 'admin.php?page=widget-create' ) );
			}
		});
		
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

