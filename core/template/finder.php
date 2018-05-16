<?php

namespace Stencil\Core\Template;

if ( !defined( 'ABSPATH' ) ) exit;


use Stencil\Core\Template_Engine;

class Finder  {


	protected $templates = [];
	protected $helpers = [];
	protected $engine;
	
	protected $registry;
	protected $manager;

	public function __construct() {
		$this->engine = Template_Engine::instance();
	}


	public function templates() {
		return $this->templates;
	}

	public function design($design) {
		$render = new Render($design);
		$render->markup($this->parseMarkup($design));
		return $render;
		
	}

	public function template($template, $design) {
		if(null !== $template = $this->find($template)) {
			if(isset($template->designs()[$design])) {
				$render = new Render($template->designs()[$design]);
				$render->markup($this->parseMarkup($template->designs()[$design]));
				return $render;
			}
		}
		$render = new Render();
		return $render;
	}

	public function parseMarkup($design) {
		$storage = $design->getStorage();
		$storage_id = $design->getStorageId();
		$template = $design->getTemplate();
		$markup = '';
		if($storage === 'post') {
			$markup = $this->parsePostMarkup($storage_id);
		}
		if($storage === 'file') {
			$markup = $this->parseFileMarkup($template);
		}
		return $markup;
	}

	public function parseFileMarkup($template) {
		if(null == $template) {
			return;
		}
		$path = 'templates/'.$template;
		$filepath = locate_template(
			array(
				$path
			)
		);
		if(null == $filepath || false == $filepath) {
			if(file_exists(STL_PATH.'/'.$path)) {
				$filepath = STL_PATH.'/'.$path;
			}
		}
		if($filepath && file_exists($filepath)) {
			$output = '';
			ob_start();
			include $filepath;
			$output .= ob_get_clean();
			return htmlentities($output);
		}
		return null;
	}

	public function parsePostMarkup() {

	}

	public function find($template) {
		if(isset($this->templates[$template])) {
			return $this->templates[$template];
		}
	}

	public function findDesign($template, $design) {
		if(null !== $template = $this->find($template)) {
			
			if(isset($template->designs()[$design])) {
				return $template->designs()[$design];
			}
		}
	}

	public function list($template) {
		if(null !== $template = $this->find($template)) {
			$options = [];
			$options[] = 'select';
			foreach ($template->designs() as $name => $class) {
				$options[$name] = $name;
			}
			return $options;
		}
		return [];
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