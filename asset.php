<?php
namespace Stencil;


if (!defined('ABSPATH'))
    exit;


final class Asset {

	public function init() {
		add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
		add_action('admin_enqueue_scripts', array($this, 'enqueue_styles'));
	}

	public function enqueue_scripts() {
		wp_register_script(
			'prisma-editor',
			STL_ASSET_URL . 'js/prism.js',
			[],
			STL_VERSION
		);
		wp_register_script(
			'codeflask',
			STL_ASSET_URL . 'js/codeflask.js',
			['prisma-editor'],
			STL_VERSION
		);
		wp_register_script(
			'codeflask-editor',
			STL_ASSET_URL . 'js/codeflask-editor.js',
			['codeflask'],
			STL_VERSION
		);
		wp_enqueue_script( 'codeflask-editor' );
	}


	public function enqueue_styles() {
		wp_register_style(
			'stencil-admin-css',
			STL_ASSET_URL . 'css/stencil.min.css',
			[
				
			],
			STL_VERSION
		);
		wp_register_style(
			'stencil-admin-css2',
			STL_ASSET_URL . 'css/admin.css',
			[
				
			],
			STL_VERSION
		);
		wp_enqueue_style( 'stencil-admin-css' );
		wp_enqueue_style( 'stencil-admin-css2' );
	}


    private static $instance;

    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
            self::$instance->init();
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


Asset::instance();