<?php

namespace Stencil\Core;



final class Form  {

    protected $fields;

    public function options($fields) {
        foreach ($fields as $key => $field) {
            if(isset($_POST[$field['id']])) {
                update_option( $field['id'], $_POST[$field['id']] );
            }
            echo $this->mirror($field, get_option($field['id']));
        }
    }


    public function display($fields, $values) {
        foreach ($fields as $key => $field) {
            echo  $this->mirror($field, isset($values[$field['id']]) ? $values[$field['id']] : '');
        }
    }

    public function mirror($field, $value) {
        return Field::mirror($field, $value);
    }

    public function show_field($field_name, $field_id, $args = []) {
        if(isset($this->fields[$field_name])) {
            $class = $this->fields[$field_name];
            $class->enqueue_scripts();
            $output = '<div class="form-group">';
            $output .= $class->show($field_id, $args);
            $output .= '</div>';
            return $output;
        }
    }

    public function add_field($name, $class) {
        $this->fields[$name] = $class;
    }

    public function register() {
        foreach ( $this->field_classes as $field ) {
            $this->require_file( STL_PATH . "$field.php" );
            $class = $this->className($field);
            $class = '\\Stencil\\Core\\Field\\'.$class;
            if(class_exists($class)) {
                $field_name = $this->filename($field);
                $this->add_field($field_name, new $class);
            }
        }
    }
    //instance
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