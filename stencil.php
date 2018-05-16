<?php


if (!defined('ABSPATH'))
	exit;

use Stencil\Core\View;
use Stencil\Core\Repository;
use Stencil\Core\Template;
use Stencil\Core\Option;


use Stencil\Render\Render;


final class Stencil {

	public function load_view() {
		return Render::instance();
	}

	public function view() {
		return View::instance();
	}

	public function render() {
		return View::instance()->render();
	}

	

	public function menu() {

	}

	public function widget() {

	}

	public function option($args = []) {
		Option::instance()->register_option($args);
	}

	public function model($model, $configs = [], $taxonomies = [], $metaboxes = [], $options = []) {
		Repository::instance()->add($model, $configs, $taxonomies, $metaboxes, $options);

	}

	
	public function template($template,  $args) {
		Template::instance()->add($template,  $args);
	}

	/********************************
	* Singleton
	*********************************/ 
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



function stencil() {
	return Stencil::instance();
}

