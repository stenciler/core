<?php

namespace Stencil\Core;

if ( !defined( 'ABSPATH' ) ) exit;

use Stencil\Core\Option\Option as OptionElement;
use Stencil\Core\Option\Manager;
use Stencil\Core\Option\Registry;

class Option {

	protected $options;
	protected $template;
	protected $widget;
	protected $registry;
	protected $manager;

	public function __construct() {
		$this->template = Template::instance();
		$this->registry = Registry::instance();
		$this->manager = Manager::instance();
		add_action('plugins_loaded', array($this, 'common'));
	}

	public function all() {
		$options = [];
		$collections  = apply_filters('stencil/option', []);
		foreach ($collections as $key => $option) {
			if($option->getName() == null) {
				continue;
			}
			if(null !== $parent = $option->getParent()) {
				$options[$option->getParent()]['sections'][$option->getName()]['title'] = $option->getTitle();
				$options[$option->getParent()]['sections'][$option->getName()]['class'] = $option;
			} else {
				$options[$option->getName()]['title'] = $option->getTitle();
				$options[$option->getName()]['sections']['main']['title'] = $option->getTitle();
				$options[$option->getName()]['sections']['main']['class'] = $option;
			}
		}
		return $options;
	}

	public function common() {
		
	
	}

	public function register() {
		foreach ( $this->includes as $include ) {
			$class = $this->className($include);
			$class = '\\Stencil\\Core\\Option\\'.$class;
			if(class_exists( $class )) {
				$this->add( new $class);
			};
		}
	}


	public function register_option($args = []) {
		$class = new OptionElement();
		$class->compose($args);
		$this->add($class);
	}


	public function add($class) {
		add_filter('stencil/option', function ($collections) use ($class) {
			$collections[] = $class;
			return $collections;
		}, 10, 2);
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

