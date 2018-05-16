<?php

namespace Stencil\Render\Helpers;

use Stencil\Core\Template_Engine;

class Post  {

	protected $engine;

	public function __construct() {
		$this->engine = Template_Engine::instance();
	}
	
	public function post($template, $args = []) {
		global $wp_query;
		$output = '';
		ob_start();
		while ( $wp_query->have_posts() ) : $wp_query->the_post();
			echo $this->engine->render($template, $args);
		endwhile;
		$output .= ob_get_clean();
		return $output;
	}

	public function title($name, $args) {
		$output = '';
		ob_start();
		?>
		<a href="<?php echo esc_url( get_permalink() ); ?>">	<?php the_title(); ?></a>

		<?php 
		$output .= ob_get_clean();
		return $output;
	}

	public function excerpt($name, $args) {
		$output = '';
		ob_start();
		?>
		<?php the_excerpt(); ?>
		
		<?php 
		$output .= ob_get_clean();
		return $output;
	}

	public function content($name, $args) {
		$output = '';
		ob_start();
		?>
		<?php the_content(); ?>
		<?php 
		$output .= ob_get_clean();
		return $output;
	}

	public function link($name, $args) {
		$output = '';
		ob_start();
		?>
		<a href="<?php echo esc_url( get_permalink() ); ?>"><?php esc_html_e( $name, 'stencil' ); ?></a>

		<?php
		$output .= ob_get_clean();
		return $output;
	}

	public function meta($name, $args) {
		global $post;
		$meta  = get_post_meta( $post->ID, $name, true );
		$output = '';
		ob_start();
		echo $meta;
		$output .= ob_get_clean();
		return $output;
	}
	public function meta_date($name, $args) {
		global $post;
		$meta  = get_post_meta( $post->ID, $name, true );
		$date_format = get_option( 'date_format' );
		$output = '';
		ob_start();
		if($meta) {
			echo date($date_format, strtotime($meta));
		}
		$output .= ob_get_clean();
		return $output;
	}
	public function meta_link($name, $args) {
		global $post;
		$meta  = get_post_meta( $post->ID, $name, true );
		$date_format = get_option( 'date_format' );
		$output = '';
		ob_start();
		
		$output .= ob_get_clean();
		return $output;
	}

	public function thumbnail($name, $args) {
		$output = '';
		ob_start();
		?>
		<?php if ( has_post_thumbnail() ) : ?>
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail(); ?>
			</a>
		<?php endif; ?>
		<?php 
		$output .= ob_get_clean();
		return $output;
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