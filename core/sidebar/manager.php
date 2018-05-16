<?php
namespace Stencil\Core\Sidebar;

class Manager  {

	protected $post_type = '_manager_sidebar';
	public function post_create($name, $sidebar_id, $sidebar_class, $before_widget, $after_widget, $before_title, $after_title) {
		$post_id = wp_insert_post(
			array(
				'comment_status'	=>	'closed',
				'ping_status'		=>	'closed',
				'post_name'		=>	$sidebar_id,
				'post_title'		=>	$name,
				'post_status'		=>	'publish',
				'post_type'		=>	'_manager_sidebar'
			)
		);
		add_post_meta( $post_id, '_sidebar_id', $sidebar_id );
		add_post_meta( $post_id, '_sidebar_class', $sidebar_class);
		add_post_meta( $post_id, '_before_widget', $before_widget );
		add_post_meta( $post_id, '_after_widget', $after_widget );
		add_post_meta( $post_id, '_before_title', $before_title );
		add_post_meta( $post_id, '_after_title', $after_title );
		return $post_id;
	}

	public function admin_create() {
		if (!current_user_can('manage_options')) {
			wp_die('Unauthorized user');
		}
		if($_POST && isset($_POST['name']) && isset($_POST['sidebar_id'])) {
			$post_id = $this->post_create(
				$_POST['name'], 
				$_POST['sidebar_id'], 
				$_POST['sidebar_class'], 
				$_POST['before_widget'], 
				$_POST['after_widget'], 
				$_POST['before_title'], 
				$_POST['after_title']
			);
			if($post_id) {
				wp_redirect('post.php?post='.$post_id.'&action=edit');
			}
		}
		?>
		<div class="wrap ux-wrapper">
			<form method="post">
				<div id="icon-themes" class="icon32"></div>
				<h2>Create Content Manager</h2>
				<div class="ux-tab">
					<div class="ux-section pt-10 rwmb-meta-box" data-autosave="false" data-object-type="stencil">
						<div class="form-group">
							<label >Name</label>
							<input name="name" type="text" class="form-control" placeholder="">
						</div>
						<div class="form-group">
							<label >ID</label>
							<input name="sidebar_id" type="text" class="form-control" placeholder="">
						</div>
						<div class="form-group">
							<label >Class</label>
							<input name="sidebar_class" type="text" class="form-control" placeholder="">
						</div>
						<div class="form-group">
							<label >Before Widget</label>
							<input name="before_widget" type="text" class="form-control" placeholder="">
						</div>
						<div class="form-group">
							<label >After Widget</label>
							<input name="after_widget" type="text" class="form-control" placeholder="">
						</div>

						<div class="form-group">
							<label >Before Title</label>
							<input name="before_title" type="text" class="form-control" placeholder="">
						</div>
						<div class="form-group">
							<label >After Title</label>
							<input name="after_title" type="text" class="form-control" placeholder="">
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
			if($pagenow === 'post-new.php' && isset($_GET['post_type']) && $_GET['post_type'] == '_manager_sidebar') {
				wp_safe_redirect(admin_url( 'admin.php?page=create-sidebar-manager' ) );
			}
		});
	}


	

	public function metaboxes() {
		add_action('add_meta_boxes', array($this, 'add_metabox') );
		add_action('save_post', array($this, 'save_metabox') );
	}

	public function add_metabox() {
		add_meta_box(
			'_manager_sidebar_metabox', 
			'Settings', 
			array($this, 'view_metabox'), 
			'_manager_sidebar',
			'normal',
			'high' 
		);

	}

	
	public function view_metabox() {
		global $post;  
		$sidebar_id = get_post_meta( $post->ID, '_sidebar_id', true ); 
		$sidebar_class = get_post_meta( $post->ID, '_sidebar_class', true ); 
		$before_widget = get_post_meta( $post->ID, '_before_widget', true ); 
		$after_widget = get_post_meta( $post->ID, '_after_widget', true ); 
		$before_title = get_post_meta( $post->ID, '_before_title', true ); 
		$after_title = get_post_meta( $post->ID, '_after_title', true ); 
		?>
		<input type="hidden" name="_manager_sidebar_meta_box_nonce" value="<?php echo wp_create_nonce( basename(__FILE__) ); ?>">
		<?php

	}

	public function save_metabox($post_id) {
		
		if(!isset($_POST['_manager_sidebar_meta_box_nonce'])) {
			return $post_id; 
		}
		if ( !wp_verify_nonce( $_POST['_manager_sidebar_meta_box_nonce'], basename(__FILE__) ) ) {
			return $post_id; 
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		$old = get_post_meta( $post_id, '_sidebar_class', true );
		$new = $_POST['_sidebar_class'];
		if ( $new && $new !== $old ) {
			update_post_meta( $post_id, '_sidebar_class', $new );
		} elseif ( '' === $new && $old ) {
			delete_post_meta( $post_id, '_sidebar_class', $old );
		}


	}

	public function repos() {
		$data = [];
		$args = [
			'post_type' => '_manager_sidebar',
			'posts_per_page' => -1
		];
		$query = new \WP_Query($args);
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				global $post;
				$id = $post->ID;
				$item = [];
				$item['title'] = $post->post_title;
				$item['sidebar_id'] = get_post_meta($id, '_sidebar_id', true);
				$item['sidebar_class'] = get_post_meta($id, '_sidebar_class', true);
				$item['before_widget'] = get_post_meta($id, '_before_widget', true);
				$item['after_widget'] = get_post_meta($id, '_after_widget', true);
				$item['before_title'] = get_post_meta($id, '_before_title', true);
				$item['after_title'] = get_post_meta($id, '_after_title', true);
				
				$data[] = $item;
			}
		} 
		wp_reset_postdata();
		return $data;
	}

	public function register() {
		
		add_action( 'setup_theme', function() {
			$repos = $this->repos();
			foreach ($repos as $key => $repo) {
				
			}
			
		});

	}

	private function library() {
		
	}
	public function register_posttype() {
		add_action( 'after_setup_theme', function() {
			$args = array(
				'label' 	=> 'Sidebar',
				'description' => '',
				'labels'                => array(
					'menu_name'              => __( 'Sidebar', 'stencil' )
				),
				'supports' => array(
					'title'
				),
				'taxonomies'            => [],
				'hierarchical'          => false,
				'public'                => true,
				'show_ui'               => true,
				'show_in_menu'          => 'manager-main',
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
		});
	}

	/******************************
	*
	*******************************/
	private static $instance;
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
			self::$instance->library();
			self::$instance->redirect();
			self::$instance->register();
			self::$instance->register_posttype();
			self::$instance->metaboxes();
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