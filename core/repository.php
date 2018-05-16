<?php

namespace Stencil\Core;

if ( !defined( 'ABSPATH' ) ) exit;

use Stencil\Core\Template;
use Stencil\Core\Option;
use Stencil\Core\Repository\Model;
use Stencil\Core\Repository\Manager;
use Stencil\Core\Repository\Registry;

class Repository {

	protected $posttypes = [];
	protected $registry;
	protected $manager;
	protected $option;
	protected $template;

	public function __construct() {
		$this->registry = Registry::instance();
		$this->manager = Manager::instance();
		$this->template = Template::instance();
		$this->option = Option::instance();
	}

	public function posttypes() {
		return $this->posttypes;
	}


	public function add($model, $configs = [], $taxonomies = [], $metaboxes = [], $options = []) {
		$class = new Model($model, $configs);
		//if($class->getPostType() !== 'page' || $class->getPostType() !== 'post') {
			$this->posttypes[$class->getPostType()] =  $class->getPostType();
		//}
		
		add_filter('stencil/model', function ($collections) use ($class) {
			$collections[] = $class;
			return $collections;
		}, 10, 2);
	}

	public function all() {
		$collections  = apply_filters('stencil/model', []);
		return $collections;
	}

	public function register() {
		add_action( 'after_setup_theme', function() {
			$collections  = $this->all();
			foreach ($collections as $key => $post) {
				$post->register();
			}
		});
	}

	private static $instance;
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
			self::$instance->register();
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

