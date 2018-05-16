<?php

namespace Stencil;



if (!defined('ABSPATH'))
	exit;

final class Stencil_Kernel {

	private static $instance;

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
			self::$instance->core();
			self::$instance->admin();
		}
		return self::$instance;
	}
	public function __clone() {
		_doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', 'stencil'), '1.6');
	}

	public function __wakeup() {
		_doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?', 'stencil'), '1.6');
	}

	private function core() {
		\Stencil\Core\Form::instance();
		\Stencil\Core\Field::instance();
		\Stencil\Core\Config::instance();
		\Stencil\Core\Option::instance();
		\Stencil\Core\Repository::instance();
		\Stencil\Core\Template::instance();
		\Stencil\Core\Sidebar::instance();
		\Stencil\Core\Menu::instance();
		\Stencil\Core\Error::instance();
	}

	private function admin() {
		\Stencil\Admin\Option::instance();
		\Stencil\Admin\Template::instance();
		\Stencil\Admin\Widget::instance();
		\Stencil\Admin\Manager::instance();
	}
}



function Stencil_Kernel() {
	return Stencil_Kernel::instance();
}

Stencil_Kernel();
