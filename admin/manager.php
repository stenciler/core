<?php

namespace Stencil\Admin;

if ( !defined( 'ABSPATH' ) ) exit;

use Stencil\Core\Repository\Manager as Repository;
use Stencil\Core\Option\Manager as Option;
use Stencil\Core\Menu\Manager as Menu;
use Stencil\Core\Sidebar\Manager as Sidebar;

class Manager {

	protected $repository;
	protected $menu;
	protected $option;
	protected $sidebar;

	public function __construct() {
		$this->repository = Repository::instance();
		$this->menu = Menu::instance();
		$this->option = Option::instance();
		$this->sidebar = Sidebar::instance();
		//add_action( 'admin_menu', array($this, 'menu'), 16);
	}




	public function menu() {
		add_menu_page( 'Manager', 'Manager', 'manage_options', 'manager-main', array($this, 'view'), 'dashicons-admin-generic' );
		add_submenu_page(
			null, 
			'Create Content Manager', 
			'Create Content Manager', 
			'manage_options', 
			'create-content-manager', 
			array($this->repository, 'admin_create'),
			0
		);
		add_submenu_page(
			null, 
			'Create Option Manager', 
			'Create Option Manager', 
			'manage_options', 
			'create-option-manager', 
			array($this->option, 'admin_create'),
			0
		);
		add_submenu_page(
			null, 
			'Create Menu Manager', 
			'Create Menu Manager', 
			'manage_options', 
			'create-menu-manager', 
			array($this->menu, 'admin_create'),
			0
		);
		add_submenu_page(
			null, 
			'Create Sidebar Manager', 
			'Create Sidebar Manager', 
			'manage_options', 
			'create-sidebar-manager', 
			array($this->sidebar, 'admin_create'),
			0
		);
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

