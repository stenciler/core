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
			'_collection_title' => null,
			'_collection_description' => null,
			'_collection_template' => 'standard',
			'_item_template' => 'standard',
			'_pagination' => true,
			'_navigation' => true,
			'_filter' => true,
			'_column' => 1,
			'_query_id' => null,
			'_post_type' => 'post',
			'_taxonomies' => [],
			'_posts_per_page' => 10,
			'_order_by' => 'ID',
			'_order' => 'ID',
			'_order_meta_key' => null,
			'_order_meta_value' => null,
			'_order' => 'ASC'
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
		
		$args = $this->config();
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
		echo $this->cover();
		echo $container->render([
			'content' => $main->render($args)
		]);
		echo $footer->render();
	}

	public function cover() {
		global $post;
		$cover_type = get_post_meta($post->ID, '_cover_type', true);
		$cover_url = get_post_meta($post->ID, '_cover_url', true);
		$cover_content = get_post_meta($post->ID, '_cover_content', true);
		$cover_opacity = get_post_meta($post->ID, '_cover_opacity', true);
		$cover_overlay = get_post_meta($post->ID, '_cover_overlay', true);
		?>
		<?php if($cover_type) { ?>
		<section class="ux-cover <?php echo $cover_overlay; ?> <?php echo $cover_opacity; ?>" >
			<?php do_action('stencil/_cover_start'); ?>
			<?php 
			if($cover_type === 'image') 
			{
				if(false == $cover_url) {
					$cover_url = get_stylesheet_directory_uri().'/assets/img/header.jpg';
				} 
				?> 
				<div class="embed parallax">
					<img src="<?php echo $cover_url; ?>" />
				</div>
				<?php 
			}  
			?>
			<?php 
			if($cover_type === 'video') 
			{ 
				?> 
				<div class="embed parallax">
					<iframe  src="<?php echo $cover_url; ?>?autoplay=1&mute=1&enablejsapi=1" frameborder="0"></iframe>
				</div>
				<?php 
			}  
			?>
			<?php 
			if($cover_type === 'map') 
			{ 
				?> 
				<div class="embed parallax">
					<iframe src="<?php echo $cover_url; ?>" frameborder="0" style="border:0" allowfullscreen></iframe>
				</div>
				<?php 
			}  
			?>
			<?php 
			if($cover_type === 'slideshow') 
			{ 
				?> 


				<?php 
			}  
			?>
			<div class="container">
				<?php do_action('stencil/_cover_content_start'); ?>
				<?php echo $cover_content; ?>
				<?php do_action( 'stencil/_cover_content_end' ); ?>
			</div>
			<?php do_action('stencil/_cover_end'); ?>
		</section>
		<?php }
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