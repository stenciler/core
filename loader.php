<?php

namespace Stencil;


if (!defined('ABSPATH'))
    exit;

final class Loader {

     protected $libraries = [
        'form/form',
        'form/field'
    ];

    protected $classes = [
        'core/engine/mustache',
        'core/template/finder',
        'core/template/registry',
        'core/template/manager',
        'core/repository/model',
        'core/repository/registry',
        'core/repository/manager',
        'core/sidebar/registry',
        'core/sidebar/manager',
        'core/menu/registry',
        'core/menu/manager',
        'core/option/registry',
        'core/option/manager',
        'core/widget/finder',
        'core/widget/manager',
        'core/widget/registry'
    ];
    
    protected $includes = [
        'core/repository', 
        'core/menu',
        'core/sidebar',
        'core/config',
        'core/field',
        'core/form',
        'core/option',
        'core/template',
        'core/template-engine',
        'core/data',
        'core/render',
        'core/css',
        'core/widget',
        'core/manager',
        'core/view',
        'core/error',
        'core/finder'
    ];

    protected $admins = [
        'admin/template', 
        'admin/manager', 
        'admin/option', 
        'admin/widget'
    ];

    protected $editors = [
        'editor/editor',
        'editor/template',
        'editor/metadata'
    ];

    protected $options = [
        'option/option',
        'option/common',
        'option/template',
        'option/font'
    ];

    protected $renders = [
        'render/render',
        'render/helper',
        'render/helpers/common',
        'render/helpers/posts',
        'render/helpers/post'
    ];


    public function __construct() {
        $this->classes();
        $this->includes();

         foreach ( $this->libraries as $include ) {
            $this->require_file( STL_PATH . "$include.php" );
        }

        foreach ( $this->admins as $include ) {
            $this->require_file( STL_PATH . "$include.php" );
        }
        foreach ( $this->editors as $include ) {
            $this->require_file( STL_PATH . "$include.php" );
        }
        foreach ( $this->options as $include ) {
            $this->require_file( STL_PATH . "$include.php" );
        }
        foreach ( $this->renders as $include ) {
            $this->require_file( STL_PATH . "$include.php" );
        }
    }


    protected function className($path, $prefix = null, $suffix = null) {
        $class = $this->filename($path);
        if($prefix) {
            $class = $prefix.$class;
        }
        if($suffix) {
            $class = $class.$suffix;
        }
        $class = str_replace("-", "_",$class);
        $class = ucwords(str_replace("_", " ",$class));
        $class = str_replace( " ", "_", $class );
        return $class;
    }

    protected function classes() {
        foreach ( $this->classes as $class ) {
            $this->require_file( STL_PATH . "$class.php" );
        }
    }
    protected function admins() {
        foreach ( $this->admins as $class ) {
            $this->require_file( STL_PATH . "$class.php" );
        }
    }

    protected function includes() {
        foreach ( $this->includes as $include ) {
            $this->require_file( STL_PATH . "$include.php" );
        }
    }


    protected function filename($path) {
        return basename($path);  
    }

    
    protected function require_file( $file ) {
        if ( file_exists( $file ) ) {
            require_once $file;
            return true;
        }
        return false;
    }





    private static $instance;

    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
            self::$instance->includes();
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

Loader::instance();
