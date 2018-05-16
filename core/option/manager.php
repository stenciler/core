<?php
namespace Stencil\Core\Option;


use Stencil\Core\Posttype;
use Stencil\Core\Base\Post_Base;

class Manager  {
	
	protected $post_type = '_manager_option';
	public function post_create($group, $name, $title,  $description) {
		$post_id = wp_insert_post(
			array(
				'comment_status'	=>	'closed',
				'ping_status'		=>	'closed',
				'post_name'		=>	$name,
				'post_title'		=>	$title,
				'post_status'		=>	'publish',
				'post_type'		=>	'_manager_option'
			)
		);
		add_post_meta( $post_id, '_group', $group );
		add_post_meta( $post_id, '_options', json_encode([]));
		return $post_id;
	}

	public function admin_create() {
		if (!current_user_can('manage_options')) {
			wp_die('Unauthorized user');
		}
		if($_POST && isset($_POST['group']) && isset($_POST['name'])) {
			$post_id = $this->post_create($_POST['group'], $_POST['name'], $_POST['title'], $_POST['description']);
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
							<label >Group</label>
							<input name="group" type="text" class="form-control" placeholder="">
						</div>
						<div class="form-group">
							<label >Name</label>
							<input name="name" type="text" class="form-control" placeholder="">
						</div>
						<div class="form-group">
							<label >Title</label>
							<input name="name" type="text" class="form-control" placeholder="">
						</div>
						<div class="form-group">
							<label >Description</label>
							<input name="description" type="text" class="form-control" placeholder="">
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
			if($pagenow === 'post-new.php' && isset($_GET['post_type']) && $_GET['post_type'] == '_manager_option') {
				wp_safe_redirect(admin_url( 'admin.php?page=create-option-manager' ) );
			}
		});
	}


	

	public function metaboxes() {
		add_action('add_meta_boxes', array($this, 'add_metabox') );
		add_action('save_post', array($this, 'save_metabox') );
	}

	public function add_metabox() {
		add_meta_box(
			'_manager_option_metabox', 
			'Settings', 
			array($this, 'view_metabox'), 
			'_manager_option',
			'normal',
			'high' 
		);

	}

	
	public function view_metabox() {
		global $post;  
		$options = get_post_meta( $post->ID, '_options', true ); 
		?>
		<input type="hidden" name="_manager_option_meta_box_nonce" value="<?php echo wp_create_nonce( basename(__FILE__) ); ?>">

		
		<p>
			<label for="your_fields[text]">Options</label>
			<br>
			<div id="options-editor" class="stencil-editor" data-language="html"><?php echo $options; ?></div>
			<input type="hidden" name="_options" id="options-data"  value="<?php echo $options; ?>">
		</p>
		
		<script>
			

			var flask = new CodeFlask;
			flask.run('#options-editor');
			flask.onUpdate(function(code) {
				document.getElementById("options-data").setAttribute('value',code);
			});

		</script>
		<?php

	}

	public function save_metabox($post_id) {
		
		if(!isset($_POST['_manager_option_meta_box_nonce'])) {
			return $post_id; 
		}
		if ( !wp_verify_nonce( $_POST['_manager_option_meta_box_nonce'], basename(__FILE__) ) ) {
			return $post_id; 
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		

		$old = get_post_meta( $post_id, '_options', true );
		$new = $_POST['_options'];
		if ( $new && $new !== $old ) {
			update_post_meta( $post_id, '_options', $new );
		} elseif ( '' === $new && $old ) {
			delete_post_meta( $post_id, '_options', $old );
		}


	}

	public function repos() {
		$data = [];
		$args = [
			'group' => '_manager_option',
			'posts_per_page' => -1
		];
		$query = new \WP_Query($args);
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				global $post;
				$id = $post->ID;
				$item = [];
				$item['id'] = $post->post_name; 
				$item['title'] = $post->post_title; 
				$item['group'] = get_post_meta($id, '_group', true);
				$item['options'] = json_decode(get_post_meta($id, '_options', true), true);
				
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
				'label' 	=> 'Options',
				'description' => '',
				'labels'                => array(
					'menu_name'              => __( 'Options', 'stencil' )
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