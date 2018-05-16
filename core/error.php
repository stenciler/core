<?php

namespace Stencil\Core;


final class Error {

    protected $errors;

    public function log($type, $code, $message) {
        if(!isset($this->errors[$type])) {
            $this->errors[$type] = [];
        }
        $this->errors[$type][$code] = $message;
    }

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