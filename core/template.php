<?php

namespace Stencil\Core;

if ( !defined( 'ABSPATH' ) ) exit;

use \Stencil_Mustache;

use Stencil\Core\Template\Design;
use Stencil\Core\Template\Render;
use Stencil\Core\Template\Finder;
use Stencil\Core\Template_Engine;

class Template  {

	protected $collections = [
		'header' => [],
		'footer' => [],
		'container' => [],
		'article' => [],
		'static' => [],
		'collection' => [],
		'item' => [],
		'widget' => []
	];

	protected $finder;
	protected $templates = [
	];
	protected $helpers = [];
	protected $engine;
	
	protected $registry;
	protected $manager;

	public function __construct() {
		$this->finder = Finder::instance();
		$this->engine = Template_Engine::instance();
	}

	public function collections() {
		return $this->collections;
	}
	
	public function template($template, $design) {
		if(null !== $designs = $this->find($template)) {
			if(isset($designs[$design])) {
				return $this->finder->design($designs[$design]);
			}
		}
	}

	public function find($template) {
		if(isset($this->collections[$template])) {
			return $this->collections[$template];
		}
	}

	public function design($template, $design) {
		if(null !== $designs = $this->find($template)) {
			if(isset($designs[$design])) {
				return $designs[$design];
			}
		}
	}

	public function list($template) {
		if(null !== $designs = $this->find($template)) {
			$options = [];
			$options[] = 'select';
			foreach ($designs as $name => $class) {
				$options[$name] = $name;
			}
			return $options;
		}
		return [];
	}

	public function add($template,  $args) {
		if($template) {
			$class = new Design();
			$class->setStorage('file');
			$class->compose($args);
			if(isset($args['name'])) {
				$this->collections[$template][$args['name']] = $class; 
			}
		}
		
	}

	
	public function add_helper($name, $callable) {
		add_filter('stencil/template_helper', function ($collections) use ($name, $callable) {
			$collections[$name] = $callable;
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