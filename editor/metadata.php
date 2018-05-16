<?php

namespace Stencil\Editor;

if ( !defined( 'ABSPATH' ) ) exit;

class Metadata {


	public function __construct() {
		add_action('add_meta_boxes', array($this, 'add_metabox') );
		add_action('save_post', array($this, 'save_metabox') );
	}

	public function add_metabox() {
	
	}

	
	public function view_metabox() {
		global $post;  
		?>
		<input type="hidden" name="_manager_content_meta_box_nonce" value="<?php echo wp_create_nonce( basename(__FILE__) ); ?>">
		<div>
			<p>sdfsdfsdfsdfd
				<label for="your_fields[text]">Args</label>
				<br>
			</p>
		</div>
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