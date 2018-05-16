<?php

namespace Stencil\Core;

if ( !defined( 'ABSPATH' ) ) exit;


class View {

	protected $config;
	protected $template;

	public function __construct() {
		$this->config = Config::instance();
		$this->template = Template::instance();
	}

	public function find($template, $design) {
		return $this->template->tpl($template, $design);
	}

	public function content($args) {

	}

	public function render() {

		$header = $this->find('header', $this->config->template('header'));
		$footer = $this->find('footer', $this->config->template('footer'));
		$container = $this->find('container',  $this->config->template('container'));
		if(is_singular() || is_page() || is_front_page()) {
			$content = $this->find('content', $this->config->template('content'));

		} else {
			$content = $this->find('collection', $this->config->template('collection'));
		}
		echo $header->render();
		echo $container->render([
			'content' => $content->render()
		]);
		echo $footer->render();
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
