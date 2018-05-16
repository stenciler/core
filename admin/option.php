<?php

namespace Stencil\Admin;

if ( !defined( 'ABSPATH' ) ) exit;

use Stencil\Core\Option as Option_Core;
use Stencil\Core\Form;
class Option {

	protected $form;
	protected $option;

	public function __construct() {
		$this->form  = Form::instance();
		$this->option = Option_Core::instance();
		$this->admin();
	}

	public function admin() {
		add_action('admin_enqueue_scripts', array($this, 'enqueue'));
		add_action( 'admin_menu', array($this, 'menu'), 16);
	}

	public function menu() {
		add_menu_page( 'Controls', 'Controls', 'manage_options', 'option-general', array($this, 'view'), 'dashicons-admin-generic' );
		$options = $this->option->all();
		foreach ($options as $name => $option) {
			add_submenu_page(
				'option-general', 
				$option['title'], 
				$option['title'], 
				'manage_options', 
				'option-'.sanitize_key($name), 
				array($this, 'view'),
				0
			);
		}
	}

	public function enqueue() {
		wp_enqueue_style( 'rwmb', RWMB_CSS_URL . 'style.css', array(), RWMB_VER );
		wp_enqueue_script( 'rwmb', RWMB_JS_URL . 'script.js', array( 'jquery' ), RWMB_VER, true );
	}

	public function option($page, $section) {
		$options = $this->option->all();
		if(isset($options[$page])) {
			$navs = [];
			foreach ($options[$page]['sections'] as $key => $nav) {
				$navs[$key] = $nav['title'];
			}
			$current = $options[$page]['sections'][$section];
			return [
				'navs' => $navs,
				'current' => $current
			];
		}
	}

	public function view() {
		if (!current_user_can('manage_options')) {
			wp_die('Unauthorized user');
		}
		$current_page = $_GET['page'];
		$query_page = explode('-', $_GET['page']);
		if(count($query_page) == 0) {
			return;
		}
		$option_page = $query_page[1];
		$option_section = 'main';
		if(isset($_GET['section'])) {
			$option_section = $_GET['section'];
		}

		if(null !== $option = $this->option($option_page, $option_section)) { 
			$class = $option['current']['class'];
			$class->register_options();
			?>
			<div class="wrap ux-wrapper">
				<form method="post">
					<div id="icon-themes" class="icon32"></div>
					<h2><?php echo $option['current']['title']; ?></h2>
					<div class="ux-tab">
						<?php if(count($option['navs']) > 0) { ?> 
						<ul class="nav nav-tabs" id="navRight" role="tablist">
							<?php
							foreach ($option['navs'] as $name => $title) { ?>
							<li class="nav-item">
								<a class="nav-link active" id="home-tab" data-toggle="tab" href="?page=<?php echo $current_page; ?>&section=<?php echo $name; ?>"  aria-selected="true"><?php echo $title; ?></a>
							</li>
							<?php }
							?>
						</ul>
						<?php } ?>
						<div class="ux-section pt-10 rwmb-meta-box" data-autosave="false" data-object-type="stencil">
							<?php
							$this->form->options($class->options());
							?>
							<?php submit_button(); ?>
						</div>
					</div>
				</form>
			</div>
			<?php
		}
		
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

