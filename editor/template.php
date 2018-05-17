<?php

namespace Stencil\Editor;

if ( !defined( 'ABSPATH' ) ) exit;

use Stencil\Core\Template as CoreTemplate;
use Stencil\Form\Form;
use Stencil\Core\Repository;
class Template {

	protected $repository;
	protected $template;
	protected $form;
	public function __construct() {
		$this->repository = Repository::instance();
		$this->template = CoreTemplate::instance();
		$this->form = Form::instance();
		add_action('add_meta_boxes', array($this, 'add_metabox') );
		add_action('save_post', array($this, 'save_metabox') );
	}

	private function page_metaboxes() {
		return [
			[
				'name' => 'Header',
				'id' => '_header_template',
				'type' => 'select',
				'options' => [ 
					'' => 'Select'
				],
				'data_parser' => 'designs_header'
			],
			[
				'name' => 'Footer',
				'id' => '_footer_template',
				'type' => 'select',
				'options' => [ 
					'' => 'Select'
				],
				'data_parser' => 'designs_footer'
			],
			[
				'name' => 'Container',
				'id' => '_container_template',
				'type' => 'select',
				'options' => [ 
					'' => 'Select'
				],
				'data_parser' => 'designs_container'
			],
			[
				'id' => null,
				'type' => 'divider'
			],
			[
				'name' => 'Content Type',
				'id' => '_template_type',
				'type' => 'select',
				'options' => [ 
					'' => 'Select',
					'article' => 'Single/Article',
					'collection' => 'Collection',
					'static' => 'Static'
				]
			],
			[
				'id' => null,
				'type' => 'divider'
			],
			[
				'condition' => [
					'type' => 'combo',
					'parent' => '_template_type',
					'value' => 'article'
				],
				'name' => 'Template',
				'id' => '_article_template',
				'type' => 'select',
				'options' => [ 
					'' => 'Select'
				],
				'data_parser' => 'designs_article'
			],
			[
				'condition' => [
					'type' => 'combo',
					'parent' => '_template_type',
					'value' => 'static'
				],
				'name' => 'Template',
				'id' => '_static_template',
				'type' => 'select',
				'options' => [ 
					'' => 'Select'
				],
				'data_parser' => 'designs_static'
			],
			[
				'condition' => [
					'type' => 'combo',
					'parent' => '_template_type',
					'value' => 'collection'
				],
				'name' => 'Title',
				'id' => '_collection_title',
				'type' => 'text'
			],
			[
				'condition' => [
					'type' => 'combo',
					'parent' => '_template_type',
					'value' => 'collection'
				],
				'name' => 'Description',
				'id' => '_collection_description',
				'type' => 'textarea'
			],
			[
				'condition' => [
					'type' => 'combo',
					'parent' => '_template_type',
					'value' => 'collection'
				],
				'name' => 'Collection',
				'id' => '_collection_template',
				'type' => 'select',
				'options' => [ 
					'' => 'Select'
				],
				'data_parser' => 'designs_collection'
			],
			[
				'condition' => [
					'type' => 'combo',
					'parent' => '_template_type',
					'value' => 'collection'
				],
				'name' => 'Item Template',
				'id' => '_item_template',
				'type' => 'select',
				'options' => [ 
					'' => 'Select'
				],
				'data_parser' => 'designs_item'
			],
			[
				'condition' => [
					'type' => 'combo',
					'parent' => '_template_type',
					'value' => 'collection'
				],
				'name' => 'Pagination',
				'id' => '_pagination',
				'type' => 'checkbox'
			],
			[
				'condition' => [
					'type' => 'combo',
					'parent' => '_template_type',
					'value' => 'collection'
				],
				'name' => 'Filter',
				'id' => '_filter',
				'type' => 'checkbox'
			],
			[
				'condition' => [
					'type' => 'combo',
					'parent' => '_template_type',
					'value' => 'collection'
				],
				'name' => 'Navigation',
				'id' => '_navigation',
				'type' => 'checkbox'
			],
			[
				'condition' => [
					'type' => 'combo',
					'parent' => '_template_type',
					'value' => 'collection'
				],
				'name' => 'Column',
				'id' => '_column',
				'type' => 'text'
			],
			[
				'condition' => [
					'type' => 'combo',
					'parent' => '_template_type',
					'value' => 'collection'
				],
				'id' => null,
				'type' => 'divider'
			],
			[
				'condition' => [
					'type' => 'combo',
					'parent' => '_template_type',
					'value' => 'collection'
				],
				'name' => 'Post Type',
				'id' => '_post_type',
				'type' => 'text'
			],
			[
				'condition' => [
					'type' => 'combo',
					'parent' => '_template_type',
					'value' => 'collection'
				],
				'id' => null,
				'type' => 'divider'
			],
			[
				'condition' => [
					'type' => 'combo',
					'parent' => '_template_type',
					'value' => 'collection'
				],
				'name' => 'Taxonomies',
				'id' => '_taxonomies',
				'type' => 'text'
			],
			[
				'condition' => [
					'type' => 'combo',
					'parent' => '_template_type',
					'value' => 'collection'
				],
				'name' => 'Post Per Page',
				'id' => '_posts_per_page',
				'type' => 'text'
			],
			[
				'condition' => [
					'type' => 'combo',
					'parent' => '_template_type',
					'value' => 'collection'
				],
				'name' => 'Order By',
				'id' => '_order_by',
				'type' => 'select',
				'options' => [ 
					'id' => 'ID',
					'author' => 'author',
					'title' => 'title',
					'name' => 'name',
					'date' => 'date',
					'comment_count' => 'comment_count',
					'meta_value' => 'meta_value',
					'rand' => 'rand'
				]
			],
			[
				'condition' => [
					'type' => 'combo',
					'parent' => '_order_by',
					'value' => 'meta_value'
				],
				'name' => 'Order Meta Key',
				'id' => '_order_meta_key',
				'type' => 'text'
			],
			[
				'condition' => [
					'type' => 'combo',
					'parent' => '_order_by',
					'value' => 'meta_value'
				],
				'name' => 'Order Meta Value',
				'id' => '_order_by_value',
				'type' => 'text'
			],
			[
				'condition' => [
					'type' => 'combo',
					'parent' => '_template_type',
					'value' => 'collection'
				],
				'name' => 'Order',
				'id' => '_order',
				'type' => 'select',
				'options' => [ 
					'ASC' => 'ASC',
					'DESC' => 'DESC'
				]
			]
		];
	}

	private function post_metaboxes() {
		return [
			[
				'name' => 'Header',
				'id' => '_header_template',
				'type' => 'select',
				'options' => [ 
					'' => 'Select'
				],
				'data_parser' => 'designs_header'
			],
			[
				'name' => 'Footer',
				'id' => '_footer_template',
				'type' => 'select',
				'options' => [ 
					'' => 'Select'
				],
				'data_parser' => 'designs_footer'
			],
			[
				'name' => 'Container',
				'id' => '_container_template',
				'type' => 'select',
				'options' => [ 
					'' => 'Select'
				],
				'data_parser' => 'designs_container'
			],
			[
				
				'name' => 'Template',
				'id' => '_article_template',
				'type' => 'select',
				'options' => [ 
					'' => 'Select'
				],
				'data_parser' => 'designs_content'
			]
		];
	}
	
	

	public function add_metabox() {
		add_meta_box(
			'_template_metabox', 
			'Template', 
			array($this, 'view_metabox'), 
			$this->repository->posttypes(),
			'normal',
			'low' 
		);
	}

	public function options($post_id = null) {
		$options = [];
		$metaboxes = $this->post_metaboxes();
		if ( get_post_type( $post_id ) == 'page' ) {
			$metaboxes = $this->page_metaboxes();
		}
		foreach ($metaboxes as $key => $field) {
			$follow = false;
			if(isset($field['condition'])) {
				if($field['condition']['type'] == 'combo') {
					$parent_value = get_post_meta($post_id, $field['condition']['parent'], true);
					if(null != $parent_value && false != $parent_value && $parent_value === $field['condition']['value']) {
						$follow = true;
					}
				}
			} else {
				$follow = true;
			}
			if(isset($field['data_parser'])) {
				$data = explode('_', $field['data_parser']);
				if(isset($data[0])) {
					if(null !== $designs = $this->template->list($data[1])) {
						$field['options'] =$designs;
					}
				}
			}
			if($follow) {
				$field = array_merge($field, [
					'value' => get_post_meta($post_id, $field['id'], true)
				]);
				$options[] = $field;
			}
		}
		return $options;
	}

	public function option($template, $post_id) {
		$options = [];

		return $options;
	}

	
	public function view_metabox() {
		global $post;  
		?>
		<input type="hidden" name="_template_page_meta_box_nonce" value="<?php echo wp_create_nonce( basename(__FILE__) ); ?>">
		<div class="rwmb-meta-box">
			<?php 
			foreach ($this->options($post->ID) as $key => $field) {
				echo $this->form->mirror($field, '');
			}
			?>
			
		</div>
		<?php 
	}

	public function save_metabox($post_id) {

		if(!isset($_POST['_template_page_meta_box_nonce'])) {
			return $post_id; 
		}
		if ( !wp_verify_nonce( $_POST['_template_page_meta_box_nonce'], basename(__FILE__) ) ) {
			return $post_id; 
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		foreach ($this->options($post_id) as $key => $field) {
			$meta_key =  $field['id'];
			$old = get_post_meta( $post_id, $meta_key, true );
			$new = $_POST[$meta_key];
			if ( $new && $new !== $old ) {
				update_post_meta( $post_id, $meta_key, $new );
			} elseif ( '' === $new && $old ) {
				delete_post_meta( $post_id, $meta_key, $old );
			}
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