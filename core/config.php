<?php

namespace Stencil\Core;

if ( !defined( 'ABSPATH' ) ) exit;

class Config {

	protected $css;
	protected $data;
	protected $template;

	public function template($target, $default = 'standard') {
		global $post;
		$result = $default;
		if(null !== $check = get_option( $target.'_global', null )) {
			$result = $check;
		}
		if(is_home() && !is_front_page()) {
			if(true == $check = get_option($target.'_global', false)) {
				$result = $check;
			}
		}
		if(is_archive() || is_tag() || is_tax()) {
			if(true == $check = get_option($target.'_archive', false)) {
				$result = $check;
			}
		}
		if(is_singular() && !is_front_page()) {
			if(true == $check = get_option($target.'_post', false)) {
				$result = $check;
			}
		}
		if(is_page() && !is_front_page()) {
			if(true == $check = get_option($target.'_page', false)) {
				$result = $check;
			}
		}
		if(is_search() && !is_front_page()) {
			if(true == $check = get_option($target.'_search', false)) {
				$result = $check;
			}
		}

		if(is_singular() || is_page()) {
			if(true == $check = rwmb_meta($target.'_main')) {
				$result = $check;
			}
		}
		
		return $result;
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

