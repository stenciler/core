<?php

namespace Stencil\Core\Option;

if (!defined('ABSPATH'))
	exit; 

class Layout_Post extends Option{

	protected $parent = 'layout';
	protected $name = 'post';
	protected $title = 'Post';
	protected $description = '';
	protected $icon = '';
	protected $group = 'layout';
	protected $prefix = 'post';
	
	public function register_options() {
		$this->add_template('header_post', 'header', [
			'name' => 'Header'
		]);
		$this->add_template('footer_post', 'footer', [
			'name' => 'Footer'
		]);
		$this->add_template('container_post', 'container', [
			'name' => 'Container'
		]);
		$this->add_template('content_post', 'content', [
			'name' => 'Content'
		]);
		$this->add_template('collection_post', 'collection', [
			'name' => 'Collection'
		]);
		$this->add_template('item_post', 'item', [
			'name' => 'Item'
		]);
	}
}