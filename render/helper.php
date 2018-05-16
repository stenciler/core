<?php

namespace Stencil\Render;

if ( !defined( 'ABSPATH' ) ) exit;

use Stencil\Core\Template as CoreTemplate;


class Helper {

	protected $template;
	
	public function __construct() {
		$this->template = CoreTemplate::instance();
		$this->register();
	}


	private function register() {

		$common = \Stencil\Render\Helpers\Common::instance();
		$this->template->add_helper('widget', array($common, 'widget'));
		$this->template->add_helper('sidebar', array($common, 'sidebar'));
		$this->template->add_helper('menu', array($common, 'menu'));
		$this->template->add_helper('wp_option', array($common, 'option'));
		$this->template->add_helper('wp_shortcode', array($common, 'shortcode'));
		$this->template->add_helper('contact-form', array($common, 'contact_form'));
		$this->template->add_helper('logo', array($common, 'logo'));


		$posts = \Stencil\Render\Helpers\Posts::instance();
		$this->template->add_helper('posts', array($posts, 'posts'));
		$this->template->add_helper('posts_loop', array($posts, 'loop'));
		$this->template->add_helper('posts_item', array($posts, 'item'));
		$this->template->add_helper('posts_pagination', array($posts, 'pagination'));
		$this->template->add_helper('posts_filter', array($posts, 'filter'));


         //wordpress post
		$post =  \Stencil\Render\Helpers\Post::instance();
		$this->template->add_helper('post', array($post, 'post'));
		$this->template->add_helper('post_title', array($post, 'title'));
		$this->template->add_helper('post_excerpt', array($post, 'excerpt'));
		$this->template->add_helper('post_content', array($post, 'content'));
		$this->template->add_helper('post_link', array($post, 'link'));
		$this->template->add_helper('post_thumbnail', array($post, 'thumbnail'));
		$this->template->add_helper('post_meta', array($post, 'meta'));
		$this->template->add_helper('post_meta_date', array($post, 'meta_date'));
		$this->template->add_helper('post_meta_link', array($post, 'meta_link'));
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
Helper::instance();