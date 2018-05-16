<?php

namespace Stencil\Core;

if ( !defined( 'ABSPATH' ) ) exit;

use Stencil\Core\Template;
use Stencil\Core\Widget\Manager;
use Stencil\Core\Widget\Registry;

class Widget {

	protected $template;
	protected $widget;
	protected $registry;
	protected $manager;

	public function __construct() {
		$this->template = Template::instance();
		$this->registry = Registry::instance();
		$this->manager = Manager::instance();
	}

	public function  args($post_id,$options) {
		$args = [];
		foreach ($options as $key => $option) {
			$args[$option['id']] = get_post_meta($post_id, $option['id'], true);
		}
		return $args;
	}


	public function get($widget_id) {
		return $this->widget->widget($widget_id);
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

