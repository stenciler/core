<?php

namespace Stencil\Render;

if ( !defined( 'ABSPATH' ) ) exit;

use Stencil\Core\Template as CoreTemplate;


class Render {
	protected $template;
	public function __construct() {
		$this->template = CoreTemplate::instance();

	}
	public function config() {
		global $post;
		$configs = [
			'_template_type' => 'article',
			'_header_template' => 'standard',
			'_footer_template' => 'standard',
			'_container_template' => 'standard',
			'_article_template' => 'standard',
			'_static_template' => null,
			'_collection_template' => 'standard',
			'_item_template' => 'standard',
			'_collection_pagination' => true,
			'_collection_navigation' => true,
			'_collection_filter' => true,
			'_collection_column' => 1,
			'_query_post_type' => 'post',
			'_query_taxonomies' => [],
			'_query_posts_per_page' => 10,
			'_query_sort' => 'ASC'
		];
		$options = [];
		foreach ($configs as $field_id => $value) {
			if($option_value = get_option($field_id)) {
				$value = $option_value;
			}
			if($post) {
				$meta_value = get_post_meta($post->ID, $field_id, true);
				if($meta_value) {
					$value = $meta_value;
				}
			}
			$options[$field_id] = $value;
		}
		return $options;
	}

	public function render() {
		
		$args = [
			'_item_template' => $this->config()['_item_template'],
			'with_pagination' => $this->config()['_collection_pagination'],
			'with_filter' => $this->config()['_collection_filter'],
			'with_navigation' => $this->config()['_collection_navigation'],
			'_column' => $this->config()['_collection_column'],
			'post_type' => $this->config()['_query_post_type'],
			'taxonomies' => $this->config()['_query_taxonomies'],
			'posts_per_page' => $this->config()['_query_posts_per_page'],
			'sort' => $this->config()['_query_sort']
		];
	


		$header_design = $this->config()['_header_template'];
		$header = $this->template->template('header', $header_design);

		$footer_design = $this->config()['_footer_template'];
		$footer = $this->template->template('footer', $footer_design);

		$container_design = $this->config()['_container_template'];
		$container = $this->template->template('container', $container_design);

		switch ($this->config()['_template_type']) {
			case 'static':
			$main_design = $this->config()['_static_template'];
			$main = $this->template->template('static', $main_design);
			break;
			case 'collection':
			$main_design = $this->config()['_collection_template'];
			$main = $this->template->template('collection', $main_design);
			break;
			default:
			$main_design = $this->config()['_article_template'];
			$main = $this->template->template('article', $main_design);
			break;
		}
		echo $header->render();
		echo $container->render([
			'content' => $main->render($args)
		]);
		echo $footer->render();
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
Render::instance();