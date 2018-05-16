<?php

namespace Stencil\Render\Helpers;

use Stencil\Core\Template\Finder;
use Stencil\Core\Template_Engine;
use Stencil\Core\Widget\Finder as WidgetFinder;

class Common  {


	protected $widget;
	protected $engine;
	protected $finder;

	public function __construct() {
		$this->widget = WidgetFinder::instance();
		$this->finder = Finder::instance();
		$this->engine = Template_Engine::instance();
	}

	public function logo($name, $args) {
		if(null === $logo_img = get_option('site_logo')) {
			$logo_img = $default;
		}
		if(!$logo_img) {
			$logo_img = get_stylesheet_directory_uri().'/assets/img/logo.png';
		}
		$output = '';
		ob_start();
		?>
		<a class="logo navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			<img src="<?php echo $logo_img; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
		</a>
		<?php 
		$output .= ob_get_clean();
		return $output;
	}



	public function widget($post_id, $args = []) {
		$output = '';
		ob_start();
		if(null !== $widget = $this->widget->find($post_id)) {
			echo $widget->render();
		}
		$output .= ob_get_clean();
		return $output;
	}


	public function sidebar($name, $args) {
		$output = '';
		ob_start();
		?>
		<?php if ( is_active_sidebar( $name ) ) : ?>
			<div class="widget-area sidebar">
				<?php echo dynamic_sidebar( $name ); ?>
			</div>
		<?php endif;
		$output .= ob_get_clean();
		return $output;
	}

	public function shortcode($name, $args) {
		$output = '';
		ob_start();
		echo do_shortcode(''.$name.'');
		$output .= ob_get_clean();
		return $output;
	}

	public function contact_form($name, $args) {
		$output = '';
		ob_start();
		echo do_shortcode('[contact-form-7 id="'.$name.'" ]');
		$output .= ob_get_clean();
		return $output;
	}

	public function menu($name, $args){
		$configs = [];
		if(isset($args[$name]) && is_array($args[$name])) {
			$configs = $args[$name];
		}
		$output = '';
		ob_start();
		wp_nav_menu(array_merge([
			'theme_location'  => $name, 
			'container'       => false,
			'container_class' => 'navbar-collapse',
			'menu_id'         => false,
			'menu_class'      => 'nav navbar-nav',
			'depth'           => 4,
			'fallback_cb'     => 'WP_Bootstrap_Navwalker::fallback',
			'walker'          => new \WP_Bootstrap_Navwalker()
		], $configs));
		$output .= ob_get_clean();
		return $output;
	}

	public function option($name, $args){
		$configs = [];
		if(isset($args[$name]) && is_array($args[$name])) {
			$configs = $args[$name];
		}
		$output = '';
		ob_start();
		echo get_option('site_logo');
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