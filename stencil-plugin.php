<?php

/**
* Plugin Name: Stencil
* Plugin URI: http://www.olla.io/stencil
* Description: Stencil Builder & Editor
* Version: 1.0.0
* Author: olla.io
* Author URI: http://www.olla.io/stencil
* Text Domain: stencil
* Domain Path: /assets/langs/
* GitHub Plugin URI: https://github.com/stenciler/core
*/


if (!defined('ABSPATH'))
	exit;

define( 'STL_VERSION', '1.0.0' );
define( 'STL_PATH', plugin_dir_path( __FILE__ ) );
define( 'STL_URL', plugin_dir_url( __FILE__ ) );
define( 'STL_ASSET_URL', plugin_dir_url( __FILE__ ).'assets/' );


//loader
require_once plugin_dir_path( __FILE__ )  . 'autoloader.php';
require_once plugin_dir_path( __FILE__ )  . 'loader.php';


//includes
require_once plugin_dir_path( __FILE__ )  . 'includes/bootstrap-menu.php';



require_once plugin_dir_path( __FILE__ )  . 'asset.php';
require_once plugin_dir_path( __FILE__ )  . 'kernel.php';
require_once plugin_dir_path( __FILE__ )  . 'stencil.php';


require_once plugin_dir_path( __FILE__ )  . 'builtin.php';



