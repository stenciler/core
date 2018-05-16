<?php

namespace Stencil\Option;

if ( !defined( 'ABSPATH' ) ) exit;

use Stencil\Core\Option as CoreOption;
use Stencil\Core\Repository;
class Option {
	protected $repository;
	protected $option;
	protected $template;
	public function __construct() {
		$this->option = CoreOption::instance();
		$this->template = Template::instance();
		$this->repository = Repository::instance();
		add_action('init', array($this, 'register_template'));
	}


	public function register_template() {
		$this->option->register_option([
			'name' => 'general',
			'title' => 'General',
			'options' => [
				[
					'type' => 'file_input',
					'name' => 'Logo',
					'id'   => 'site_logo'
				],
				[
					'type' => 'file_input',
					'name' => 'Logo Light',
					'id'   => 'site_logo_light'
				],
				[
					'type' => 'file_input',
					'name' => 'Logo Dark',
					'id'   => 'site_logo_dark'
				],
				[
					'type' => 'file_input',
					'name' => 'Logo Footer',
					'id'   => 'site_logo_footer'
				],
				[
					'name'    => 'About Site',
					'id'      => 'site_about',
					'type'    => 'wysiwyg',
					'raw'     => false,
					'options' => [
						'textarea_rows' => 4,
						'teeny'         => true,
					]
				],
				[
					'name'    => 'Address',
					'id'      => 'site_address',
					'type'    => 'wysiwyg',
					'raw'     => false,
					'options' => [
						'textarea_rows' => 4,
						'teeny'         => true,
					]
				],
				[
					'type' => 'text',
					'name' => 'Copyright',
					'id'   => 'site_copyright'
				],
			]
		]);
		$this->option->register_option([
			'name' => 'typography',
			'title' => 'Typography',
			'options' => [
				[
					'type' => 'text',
					'name' => 'Font Size',
					'id'   => 'font_size'
				],
				[
					'type' => 'text',
					'name' => 'Font Family',
					'id'   => 'font_family'
				],
				[
					'type' => 'color',
					'name' => 'Font Color',
					'id'   => 'font_color'
				],
			]
		]);

		$this->option->register_option([
			'name' => 'template',
			'title' => 'Template',
			'options' => $this->template->options()
		]);
		foreach ($this->repository->posttypes() as $key => $posttype) {
			$this->option->register_option([
				'parent' => 'template',
				'name' => $posttype,
				'title' => ucfirst($posttype),
				'options' => $this->template->options($posttype)
			]);
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
Option::instance();