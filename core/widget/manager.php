<?php
namespace Stencil\Core\Widget;

use Stencil\Core\Form;
use Stencil\Core\Template;

class Manager  {

	protected $template;
	protected $finder;
	protected $widget;
	protected $widgets = [];
	protected $post_type = '_stencil_widget';

	public function __construct() {
		$this->template = Template::instance();
		$this->form = Form::instance();
		
	}

	public function widgets() {
		return $this->widgets;
	}

	public function widget($widget_id) {
		if(isset($this->widgets[$widget_id])) {
			$widget = $this->widgets[$widget_id];
			$design = $widget['template'];
			$args = [];
			return [
				'design' => $design,
				'args' => $args
			];
		}
	}

	public function post_create($name, $template) {
		$post_id = wp_insert_post(
			array(
				'comment_status'	=>	'closed',
				'ping_status'		=>	'closed',
				'post_title'		=>	$name,
				'post_status'		=>	'publish',
				'post_type'			=>	$this->post_type
			)
		);
		add_post_meta( $post_id, '_name', $name );
		add_post_meta( $post_id, '_template', $template );
		return $post_id;
	}

	public function admin_create() {
		if (!current_user_can('manage_options')) {
			wp_die('Unauthorized user');
		}
		if($_POST && isset($_POST['name'])  && isset($_POST['template'])) {
			$post_id = $this->post_create($_POST['name'], $_POST['template']);
			if($post_id) {
				wp_safe_redirect(admin_url('post.php?post='.$post_id.'&action=edit'));
			}
		}

		?>
		<div class="wrap ux-wrapper">
			<form method="post">
				<div id="icon-themes" class="icon32"></div>
				<h2>Create Widget.</h2>
				<div class="ux-tab">
					<div class="ux-section pt-10 rwmb-meta-box" data-autosave="false" data-object-type="stencil">
						<div class="form-group">
							<label>Name</label>
							<input name="name" type="text" class="form-control" placeholder="">
						</div>
						<div class="form-group">
							<label >Template</label>
							<select class="form-control" name="template">
								<?php
								foreach ($this->template->list('widget') as $name => $title) { 
									?>
									<option value="<?php echo $name; ?>">
										<?php echo $title; ?>

									</option>
									<?php
								} ?>
							</select>
						</div>
						<button type="submit" class="btn btn-primary mb-2">Create</button>
					</div>
				</div>
			</form>
		</div>
		<?php
	}

	public function redirect() {
		global $pagenow;
		add_action( 'admin_init', function() use($pagenow) {
			if($pagenow === 'post-new.php' && isset($_GET['post_type']) && $_GET['post_type'] == $this->post_type) {
				wp_safe_redirect(admin_url( 'admin.php?page=create-widget' ) );
			}
		});
	}


	public function add_metabox() {
		add_meta_box( $this->post_type.'_metabox', 
			'Editor', 
			array($this, 'view_metabox'), 
			$this->post_type,
			'normal',
			'high' 
		);
		add_meta_box( $this->post_type.'_metabox_tutorial', 
			'How to embed?', 
			array($this, 'howto_metabox'), 
			$this->post_type,
			'side',
			'high' 
		);
	}
	public function howto_metabox() {
		global $post;  
		$template = get_post_meta( $post->ID, '_template', true ); 
		?>
		<string>{{#widget}}<?php echo $post->ID; ?>{{/widget}}</string>
		<?php
	}


	public function view_metabox() {
		global $post;  
		$form = Form::instance();
		$design = get_post_meta( $post->ID, '_template', true ); 
		$design = $this->template->design('widget', $design);

		$values = [];
		foreach ($design->getOptions() as $key => $option) {
			$values[$option['id']] = get_post_meta($post->ID, $option['id'], true);
		}
		?>
		<div class="ux-wrapper">
			<input type="hidden" name="<?php echo $this->post_type; ?>_meta_box_nonce" value="<?php echo wp_create_nonce( basename(__FILE__) ); ?>">
			<?php 
			$this->form->display($design->getOptions(), $values);
			?>
		</div>
		<?php
	}

	public function save_metabox($post_id) {
		if(!isset($_POST[$this->post_type.'_meta_box_nonce'])) {
			return $post_id; 
		}
		if ( !wp_verify_nonce( $_POST[$this->post_type.'_meta_box_nonce'], basename(__FILE__) ) ) {
			return $post_id; 
		} 

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
		$design = get_post_meta( $post_id, '_template', true ); 
		$design = $this->template->design('widget', $design);
		foreach ($design->getOptions() as $key => $option) {
			$new = $_POST[$option['id']];
			update_post_meta( $post_id, $option['id'], $new );
		}
	}

	public function repositories() {
		$data = [];
		$args = [
			'post_type' => $this->post_type,
			'posts_per_page' => -1
		];
		$query = new \WP_Query($args);
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				global $post;
				$post_id = $post->ID;
				$values = [];


				$design = get_post_meta( $post_id, '_template', true );
			
				if(null !== $design = $this->template->design('widget', $design)) {
					foreach ($design->getOptions() as $key => $option) {
						$values[$option['id']] = get_post_meta($post->ID, $option['id'], true);
					}
				}
				$item = [];
				$item['id'] = $post_id;
				$item['name'] = get_post_meta($post_id, '_name', true);
				$item['template'] = get_post_meta($post_id, '_template', true);
				$item['values'] = $values;
				$data[$post_id] = $item;
			}
		} 
		wp_reset_postdata();
		return $data;
	}

	public function get($id) {

		if(isset($this->widgets[$id])) {
				$widget = $this->widgets[$id];
				if(null !== $design = $this->template->template('widget', $widget['template'])) {
					$design->values($widget['values']);
					return $design;
				}
		}

	}

	public function menu() {
		add_submenu_page(
			null, 
			'Create Widget', 
			'Create Widget', 
			'manage_options', 
			'create-widget', 
			array(self::$instance, 'admin_create'),
			0
		);
	}

	public function posttype() {
		$args = array(
			'label' 	=> 'Widget',
			'description' => '',
			'labels'                => array(
				'menu_name'              => __( 'Widget', 'stencil' )
			),
			'supports' => array(
				'title'
			),
			'taxonomies'            => [],
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => 'widget-main',
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'post',
		);
		register_post_type( $this->post_type, $args );
	}


	public function register_design() {
		$widgets = $this->repositories();
		foreach ($widgets as $key => $widget) {
			$this->widgets[$widget['id']] = $widget;
		}
	}

	public function view_hide() {
		global $pagenow;
		if($pagenow === 'edit.php' && isset($_GET['post_type']) && $_GET['post_type'] == $this->post_type) {
			return true;
		}
	}

	public function view_views() {

	}



	public function register() {
		add_filter('post_date_column_status', array($this, 'view_hide') );
		add_filter('post_date_column_time', array($this, 'view_hide') );
		add_filter('page_row_actions', array($this, 'view_hide') );
		add_filter('views_edit-'.$this->post_type, array($this, 'view_views') );
		add_filter('bulk_actions-edit-'.$this->post_type, array($this, 'view_hide') );
		add_filter('disable_months_dropdown', array($this, 'view_hide') );
		add_action('setup_theme', array($this, 'posttype'), 10);
		add_action('admin_menu', array($this, 'menu'), 16);
		add_action('after_setup_theme', array($this, 'register_design'), 10, 2);
		add_action('add_meta_boxes', array($this, 'add_metabox') );
		add_action('save_post', array($this, 'save_metabox') );
	}
	/******************************
	*
	*******************************/
	private static $instance;
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
			self::$instance->redirect();
			self::$instance->register();
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

Manager::instance();