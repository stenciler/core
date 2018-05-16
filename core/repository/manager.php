<?php
namespace Stencil\Core\Repository;



class Manager  {
	protected $posttype;
	protected $post_type = '_manager_content';

	public function post_create($post_type, $name, $description, $capability, $extend) {
		$post_id = wp_insert_post(
			array(
				'comment_status'	=>	'closed',
				'ping_status'		=>	'closed',
				'post_name'		=>	$name,
				'post_title'		=>	$name,
				'post_status'		=>	'publish',
				'post_type'		=>	'_manager_content'
			)
		);
		add_post_meta( $post_id, '_post_type', $post_type );
		add_post_meta( $post_id, '_capability', $capability );
		add_post_meta( $post_id, '_extend', $extend );
		add_post_meta( $post_id, '_args', json_encode([]));
		add_post_meta( $post_id, '_taxonomies', json_encode([]));
		add_post_meta( $post_id, '_metaboxes', json_encode([]));
		return $post_id;
	}

	public function admin_create() {
		if (!current_user_can('manage_options')) {
			wp_die('Unauthorized user');
		}
		if($_POST && isset($_POST['post_type']) && isset($_POST['name'])) {
			$post_id = $this->post_create($_POST['post_type'], $_POST['name'], $_POST['description'], $_POST['capability'], $_POST['extend']);
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
							<label >Post Type</label>
							<input name="post_type" type="text" class="form-control" placeholder="">
						</div>
						<div class="form-group">
							<label >Name</label>
							<input name="name" type="text" class="form-control" placeholder="">
						</div>
						<div class="form-group">
							<label >Description</label>
							<input name="description" type="text" class="form-control" placeholder="">
						</div>
						<div class="form-group">
							<label >Capability</label>
							<select class="form-control" name="capability">
								<option value="post">post</option>
								<option value="page">page</option>
							</select>
						</div>
						<div class="form-group">
							<label >Extends?</label>
							<input name="extend" type="checkbox" >
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
			if($pagenow === 'post-new.php' && isset($_GET['post_type']) && $_GET['post_type'] == '_manager_content') {
				wp_safe_redirect(admin_url( 'admin.php?page=create-content-manager' ) );
			}
		});
	}



	public function metaboxes() {
		add_action('add_meta_boxes', array($this, 'add_metabox') );
		add_action('save_post', array($this, 'save_metabox') );
	}

	public function add_metabox() {
		add_meta_box(
			'_manager_content_metabox', 
			'Settings', 
			array($this, 'view_metabox'), 
			'_manager_content',
			'normal',
			'high' 
		);
	}

	
	public function view_metabox() {
		global $post;  
		$args = get_post_meta( $post->ID, '_args', true ); 
		$taxonomies = get_post_meta( $post->ID, '_taxonomies', true ); 
		$metaboxes = get_post_meta( $post->ID, '_metaboxes', true ); 
		?>
		<input type="hidden" name="_manager_content_meta_box_nonce" value="<?php echo wp_create_nonce( basename(__FILE__) ); ?>">

		<p>
			<label for="your_fields[text]">Args</label>
			<br>
			<div id="args-editor" class="stencil-editor" data-language="html"><?php echo $args; ?></div>
			<input type="hidden" name="_args" id="args-data"  value="<?php echo $args; ?>">
		</p>
		<p>
			<label for="your_fields[text]">Taxonomies</label>
			<br>
			<div id="taxonomies-editor" class="stencil-editor" data-language="html"><?php echo $taxonomies; ?></div>
			<input type="hidden" name="_taxonomies" id="taxonomies-data"  value="<?php echo $taxonomies; ?>">
		</p>
		<p>
			<label for="your_fields[text]">Metaboxes</label>
			<br>

			<div id="metaboxes-editor" class="stencil-editor" data-language="html"><?php echo $metaboxes; ?></div>
			<input type="hidden" name="_metaboxes" id="metaboxes-data"  value="<?php echo $metaboxes; ?>">
		</p>
		
		<script>
			var flask = new CodeFlask;
			flask.run('#args-editor');
			flask.onUpdate(function(code) {
				document.getElementById("args-data").setAttribute('value',code);
			});

			var flask = new CodeFlask;
			flask.run('#taxonomies-editor');
			flask.onUpdate(function(code) {
				document.getElementById("taxonomies-data").setAttribute('value',code);
			});

			var flask = new CodeFlask;
			flask.run('#metaboxes-editor');
			flask.onUpdate(function(code) {
				document.getElementById("metaboxes-data").setAttribute('value',code);
			});
		</script>
		<?php

	}

	public function save_metabox($post_id) {
		
		if(!isset($_POST['_manager_content_meta_box_nonce'])) {
			return $post_id; 
		}
		if ( !wp_verify_nonce( $_POST['_manager_content_meta_box_nonce'], basename(__FILE__) ) ) {
			return $post_id; 
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		$old = get_post_meta( $post_id, '_args', true );
		$new = $_POST['_args'];
		if ( $new && $new !== $old ) {
			update_post_meta( $post_id, '_args', $new );
		} elseif ( '' === $new && $old ) {
			delete_post_meta( $post_id, '_args', $old );
		}

		$old = get_post_meta( $post_id, '_taxonomies', true );
		$new = $_POST['_taxonomies'];
		if ( $new && $new !== $old ) {
			update_post_meta( $post_id, '_taxonomies', $new );
		} elseif ( '' === $new && $old ) {
			delete_post_meta( $post_id, '_taxonomies', $old );
		}

		$old = get_post_meta( $post_id, '_metaboxes', true );
		$new = $_POST['_metaboxes'];
		if ( $new && $new !== $old ) {
			update_post_meta( $post_id, '_metaboxes', $new );
		} elseif ( '' === $new && $old ) {
			delete_post_meta( $post_id, '_metaboxes', $old );
		}

	}

	public function repos() {
		$data = [];
		$args = [
			'post_type' => '_manager_content',
			'posts_per_page' => -1
		];
		$query = new \WP_Query($args);
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				global $post;
				$id = $post->ID;
				$item = [];
				$configs = json_decode(get_post_meta($id, '_configs', true),true) ?? [];
				$item['posttype'] = [
					'post_type' => get_post_meta($id, '_post_type', true),
					'configs' => array_merge([
						'label' => get_the_title()
					],
						$configs
					),
					'metadata' => json_decode(get_post_meta($id, '_metadata', true),true),
					'category' => get_post_meta($id, '_category', true),
					'extend' => get_post_meta($id, '_extend', true)
				];

				$item['metaboxes'] = json_decode(get_post_meta($id, '_metadata', true), true) ?? [];
				$item['taxonomies'] = json_decode(get_post_meta($id, '_contexs', true), true) ?? [];
				
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
				'label' 	=> 'Content',
				'description' => '',
				'labels'                => array(
					'menu_name'              => __( 'Content', 'stencil' )
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