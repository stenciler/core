<?php

namespace Stencil\Render\Helpers;

use Stencil\Core\Template;
use Stencil\Core\Template_Engine;
class Posts {

	protected $engine;
	protected $template;

	public function __construct() {
		$this->template = Template::instance();
		$this->engine = Template_Engine::instance();
	}

	public function posts($template, $args = []) {
		global $paged, $wp_query;

		$column = 1;
		if(isset($args['_column'])) {
			$column = $args['_column'];
		}

		$x = 12%$column;
		$args['_row_class'] = 'row';
		$args['_column_class'] = 'col-md-12';
		if(0 == 12%$column) {
			$args['_column_class'] = 'col-md-'.(12/$column);
		}



		$query_args = [
			'post_type' => 'post',
			'posts_per_page' => 6
		];
		if(isset($args['post_type'])) {
			$query_args['post_type'] = $args['post_type'];
		}
		if(isset($args['posts_per_page'])) {
			//$query_args['posts_per_page'] = $args['posts_per_page'];
		}

		$wp_query = new \WP_Query($query_args);
		$output = '';
		ob_start();
		$data = [];
		if ($wp_query->have_posts() ) :
			echo $this->engine->render($template, $args);
		else :
		endif;
		$output .= ob_get_clean();
		wp_reset_postdata();
		return $output;
	}

	public function loop($template, $args = []) {
		global $wp_query;
		$output = '';
		ob_start();
		while ( $wp_query->have_posts() ) : $wp_query->the_post();
			echo $this->engine->render($template, $args);
		endwhile;
		$output .= ob_get_clean();
		return $output;
	}

	public function item($template, $args) {
		if(isset($args['_item_template'])) {
			$design = $args['_item_template'];
		} else {
			$design = 'standard';
		}
		$view = $this->template->template('item', $design);
		$output = '';
		ob_start();
		echo $view->render();
		$output .= ob_get_clean();
		return $output;
	}

	
	public function pagination($template, $args) {
		global $paged, $wp_query;

		$total_posts = $wp_query->found_posts;
		
		if($paged === 0) {
			$paged = 1;
		}

		$posts_per_page = 1;
		if(isset($args['posts_per_page'])) {
			//$posts_per_page = $args['posts_per_page'];
		}

		$pages = round($wp_query->found_posts/$posts_per_page);


		$range = 1;
		$output = '';
		ob_start();
		$showitems = ($range * 2) + 1;  


		if(1 != $pages)
		{
			echo '<nav aria-label="Page navigation" role="navigation">';
			echo '<span class="sr-only">Page navigation</span>';
			echo '<ul class="pagination justify-content-center ft-wpbs">';

			echo '<li class="page-item disabled hidden-md-down d-none d-lg-block"><span class="page-link">Page '.$paged.' of '.$pages.'</span></li>';

			if($paged > 2 && $paged > $range+1 && $showitems < $pages) 
				echo '<li class="page-item"><a class="page-link" href="'.get_pagenum_link(1).'" aria-label="First Page">&laquo;<span class="hidden-sm-down "> First</span></a></li>';

			if($paged > 1 && $showitems < $pages) 
				echo '<li class="page-item"><a class="page-link" href="'.get_pagenum_link($paged - 1).'" aria-label="Previous Page">&lsaquo;<span class="hidden-sm-down"> Previous</span></a></li>';

			for ($i=1; $i <= $pages; $i++)
			{
				if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
					echo ($paged == $i)? '<li class="page-item active"><span class="page-link"><span class="sr-only">Current Page </span>'.$i.'</span></li>' : '<li class="page-item"><a class="page-link" href="'.get_pagenum_link($i).'"><span class="sr-only">Page </span>'.$i.'</a></li>';
			}

			if ($paged < $pages && $showitems < $pages) 
				echo '<li class="page-item"><a class="page-link" href="'.get_pagenum_link($paged + 1).'" aria-label="Next Page"><span class="hidden-sm-down">Next </span>&rsaquo;</a></li>';  

			if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) 
				echo '<li class="page-item"><a class="page-link" href="'.get_pagenum_link($pages).'" aria-label="Last Page"><span class="hidden-sm-down">Last </span>&raquo;</a></li>';

			echo '</ul>';
			echo '</nav>';
		}
		$output .= ob_get_clean();
		return $output;
	}

	public function filter() {

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