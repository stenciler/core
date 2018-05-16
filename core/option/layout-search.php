<?php

namespace Stencil\Core\Option;

if (!defined('ABSPATH'))
    exit; 

class Layout_Search extends Option{

    protected $parent = 'layout';
	protected $name = 'search';
	protected $title = 'Search';
	protected $description = '';
	protected $icon = '';
	protected $group = 'layout';
	protected $prefix = 'search';

	public function register_options() {
    	$this->add_template('header_search', 'header', [
    		'name' => 'Header'
    	]);
    	$this->add_template('footer_search', 'footer', [
    		'name' => 'Footer'
    	]);
    	$this->add_template('container_search', 'container', [
    		'name' => 'Container'
    	]);
    	$this->add_template('content_search', 'content', [
    		'name' => 'Content'
    	]);
    	$this->add_template('collection_search', 'collection', [
    		'name' => 'Collection'
    	]);
    	$this->add_template('item_search', 'item', [
    		'name' => 'Item'
    	]);
	}
}