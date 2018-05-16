<?php

namespace Stencil\Core\Option;

if (!defined('ABSPATH'))
	exit; 


class Layout extends Option {

	protected $name = 'layout';
	protected $title = 'Layout';
	protected $description = '';
	protected $icon = '';



    public function register_options() {
    	$this->add_template('header_global', 'header', [
    		'name' => 'Header'
    	]);
    	$this->add_template('footer_global', 'footer', [
    		'name' => 'Footer'
    	]);
    	$this->add_template('container_global', 'container', [
    		'name' => 'Container'
    	]);
    	$this->add_template('content_global', 'content', [
    		'name' => 'Content'
    	]);
    	$this->add_template('collection_global', 'collection', [
    		'name' => 'Collection'
    	]);
    	$this->add_template('item_global', 'item', [
    		'name' => 'Item'
    	]);
	}
}