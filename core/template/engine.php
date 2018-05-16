<?php

namespace Stencil\Core\Template;

if ( !defined( 'ABSPATH' ) ) exit;

use Stencil\Engine\Mustache;


class Engine {

	protected $engine;
	protected $error;

	public function __construct() {
		$this->engine = new Mustache();
		$this->logger = Error::instance();
		add_action( 'after_setup_theme', function() {
			$helpers = apply_filters('stencil/template_helper', []);
			foreach ($helpers as $name => $helper) {
				$this->engine->add_helper($name, $helper);
			}
		});
	}

	public function render($template, $data = []) {
		$output = '';
		ob_start();
		echo $this->engine->render($template, $data);
		$output .= ob_get_clean();
		return html_entity_decode($output);
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

