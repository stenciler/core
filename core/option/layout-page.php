<?php

namespace Stencil\Core\Option;

if (!defined('ABSPATH'))
    exit; 

class Layout_Page extends Option{

    protected $parent = 'layout';
	protected $name = 'page';
	protected $title = 'Page';
	protected $description = '';
	protected $icon = '';
	protected $group = 'layout';
    
	public function register_options() {
    	$this->add_template('header_page', 'header', [
    		'name' => 'Header'
    	]);
    	$this->add_template('footer_page', 'footer', [
    		'name' => 'Footer'
    	]);
    	$this->add_template('container_page', 'container', [
    		'name' => 'Container'
    	]);
    	$this->add_template('content_page', 'content', [
    		'name' => 'Content'
    	]);
    	$this->add_template('collection_page', 'collection', [
    		'name' => 'Collection'
    	]);
    	$this->add_template('item_page', 'item', [
    		'name' => 'Item'
    	]);
	}
}