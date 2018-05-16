<?php

namespace Stencil\Core\Option;

if (!defined('ABSPATH'))
    exit; 

class Layout_Archive extends Option{
    protected $parent = 'layout';
	protected $name = 'archive';
	protected $title = 'Archive';
	protected $description = '';
	protected $icon = '';
	protected $group = 'layout';
	protected $prefix = 'archive';

	public function register_options() {
    	$this->add_template('header_archive', 'header', [
    		'name' => 'Header'
    	]);
    	$this->add_template('footer_archive', 'footer', [
    		'name' => 'Footer'
    	]);
    	$this->add_template('container_archive', 'container', [
    		'name' => 'Container'
    	]);
    	$this->add_template('content_archive', 'content', [
    		'name' => 'Content'
    	]);
    	$this->add_template('collection_archive', 'collection', [
    		'name' => 'Collection'
    	]);
    	$this->add_template('item_archive', 'item', [
    		'name' => 'Item'
    	]);
	}
}