<?php

namespace Stencil\Core;

if ( !defined( 'ABSPATH' ) ) exit;


class Data {

	protected $finder;

	public function __construct() {
		$this->finder = Finder::instance();
	}

	public function designs($template) {
		return $this->finder->designs($template);
	}

	public function location() {
		$location = '';
		if(is_home()) {
			$location = 'home';
		}
		if(is_archive() || is_tag() || is_tax()) {
			$location = 'archive';
		}
		if(is_page()) {
			$location = 'page';
		}

		if(is_singular()) {
			$location = 'single';

		}

		if(is_search()) {
			$location = 'search';
		}
		return $location;
	}

	public function posttypes() {
		$excluded = [
			'revision',
			'nav_menu_item',
			'custom_css',
			'customized_changeset',
			'oembed_cache',
			'elementor_library',
			'product_variation',
			'shop_order',
			'shop_order_refund'
		];
		$post_types = get_post_types();
		$options = [];
		foreach ($post_types as $key => $term) {
			if(!in_array($term, $excluded)) {
				$options[$term] = $term;
			}
		}
		return $options;
	}

	public function terms($taxonomy, $args = []) {
		$args =  array_merge([
		], $args);
		$terms = get_terms($taxonomy, $args);
		$options = [];
		foreach ($terms as $key => $term) {
			$options[$term->term_id] = $term->name;
		}
		return $options;
	}

	public function listen_posts($args = []) {
		$paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
		$data = [];
		if (have_posts() ) :
			while ( have_posts() ) : the_post();
				$data['items'][] = $this->extract_post();
			endwhile;
		else :
		endif;
		global $wp_query;
		$data['pagination']['page'] =  $paged;
		$data['pagination']['pages'] =  $wp_query->max_num_pages;
		return $data;
	}

	public function posts($args = []) {
		$paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
		if(!empty($args)) {
			return $this->query_posts($args, $paged);
		} else {
			return $this->pure_posts($paged);
		}
	}

	public function pure_posts($paged) {
		$paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
		$data = [];
		if (have_posts() ) :
			while ( have_posts() ) : the_post();
				$data['items'][] = $this->extract_post();
			endwhile;
		else :
		endif;
		global $wp_query;
		$data['pagination']['page'] =  $paged;
		$data['pagination']['pages'] =  $wp_query->max_num_pages;
		return $data;
	}

	public function query_posts($args, $paged) {
		
		$args = array_merge([
			'post_type' => 'post',
			'posts_per_page' => 3
		], $args);
		$query = new \WP_Query( $args );
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$data['items'][] = $this->extract_post();
			}
		} 
		$data['pagination']['page'] =  $paged;
		$data['pagination']['pages'] =  $query->max_num_pages;
		wp_reset_postdata();
		return $data;
	}

	public function related_posts($post_id, $args = []) {
		global $post;
		$tags = wp_get_post_tags($post_id);
		$tag_ids = [];
		foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
		$data = [];
		$args = array_merge([
			'tag__in' => $tag_ids,
			'post__not_in' => array($post->ID), 
			'orderby' => 'rand',
			'post_per_page' => 10
		], $args);
		return $this->posts($args);
	}

	public function extract_post($full = false) {
		$item = [];
		$item['id'] = get_the_ID();
		$item['title'] = get_the_title();
		$item['text'] = get_the_excerpt();
		$item['link'] = get_the_permalink();
		$item['date'] =  get_the_date();
		$item['image'] = '';
		$item['thumbnail'] = '';
		if ( has_post_thumbnail() ) {
			$image  = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
			$item['image'] = $image[0];

			$thumbnail  = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' );
			$item['thumbnail'] = $thumbnail[0];
		}
		return $item;
	}

	public function attachments($post_id, $args = []) {
		$data = [];
		$args = array_merge([
			'post_type' => 'attachment',
			'posts_per_page' => -1,
			'post_parent' => $post_id
		], $args);
		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$data[get_the_ID()] = $this->extract_post();
			}
		}
		wp_reset_postdata();
		return $data;
	}

	public function meta($meta_id, $default) {

	}

	public function option($option_id, $default) {

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

