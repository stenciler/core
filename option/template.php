<?php

namespace Stencil\Option;

if ( !defined( 'ABSPATH' ) ) exit;

use Stencil\Core\Template as CoreTemplate;
use Stencil\Core\Option as CoreOption;


class Template {

	protected $template;
	protected $option;
	public function __construct() {
		$this->option = CoreOption::instance();
		$this->template = CoreTemplate::instance();

	}

	private function base_options() {
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
				'name' => 'Single Template',
				'id' => '_article_template',
				'type' => 'select',
				'options' => [ 
					'' => 'Select'
				],
				'data_parser' => 'designs_article'
			],
			[
				'name' => 'Collection Template',
				'id' => '_collection_template',
				'type' => 'select',
				'options' => [ 
					'' => 'Select'
				],
				'data_parser' => 'designs_collection'
			],
			[
				'id' => null,
				'type' => 'divider'
			],
			[
				'id' => null,
				'name' => 'Single/Article',
				'type' => 'heading'
			],
			[
				'id' => null,
				'type' => 'divider'
			],
			[
				'name' => 'Header',
				'id' => '_single_header_template',
				'type' => 'select',
				'options' => [ 
					'' => 'Select'
				],
				'data_parser' => 'designs_header'
			],
			[
				'name' => 'Footer',
				'id' => '_single_footer_template',
				'type' => 'select',
				'options' => [ 
					'' => 'Select'
				],
				'data_parser' => 'designs_footer'
			],
			[
				'name' => 'Container',
				'id' => '_single_container_template',
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
				'id' => null,
				'name' => 'Archive',
				'type' => 'heading'
			],
			[
				'id' => null,
				'type' => 'divider'
			],
			[
				'name' => 'Header',
				'id' => '_archive_header_template',
				'type' => 'select',
				'options' => [ 
					'' => 'Select'
				],
				'data_parser' => 'designs_header'
			],
			[
				'name' => 'Footer',
				'id' => '_archive_footer_template',
				'type' => 'select',
				'options' => [ 
					'' => 'Select'
				],
				'data_parser' => 'designs_footer'
			],
			[
				'name' => 'Container',
				'id' => '_archive_container_template',
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
				'id' => null,
				'name' => 'Collection',
				'type' => 'heading'
			],
			[
				'id' => null,
				'type' => 'divider'
			],
			[
				'name' => 'Item Template',
				'id' => '_item_template',
				'type' => 'select',
				'options' => [ 
					'' => 'Select'
				],
				'data_parser' => 'designs_item'
			],
			[
				'name' => 'Pagination',
				'id' => '_pagination',
				'type' => 'checkbox'
			],
			[
				'name' => 'Filter',
				'id' => '_filter',
				'type' => 'checkbox'
			],
			[
				'name' => 'Navigation',
				'id' => '_navigation',
				'type' => 'checkbox'
			],
			[
				'name' => 'Column',
				'id' => '_column',
				'type' => 'text'
			],
			[
				'id' => null,
				'type' => 'divider'
			],
			[
				'name' => 'Post Per Page',
				'id' => '_posts_per_page',
				'type' => 'text'
			],
			[
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


	public function options($post_type = null) {
		$options = [];
		$metaboxes = $this->base_options();
		foreach ($metaboxes as $key => $field) {
			if(!isset($field['id'])) {
				//continue;
			}
			$field_id = $field['id'];
			if($post_type) {
				$field_id = '_'.$post_type.$field_id;
			}
			$field = array_merge($field, [
				'id' => $field_id
			]);

			$follow = false;
			if(isset($field['condition'])) {
				if($field['condition']['type'] == 'combo') {
					$parent_value = get_option($field['condition']['parent']);
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
					if(null !==  $designs = $this->template->list($data[1])) {
						$field['options'] = $designs;
					}
				}
			}
			if($follow) {
				$field = array_merge($field, [
					'value' => get_option($field['id'])
				]);
				$options[] = $field;
			}
		}
		return $options;
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