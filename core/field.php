<?php

namespace Stencil\Core;

use Stencil\Core\Base\Field_Base;

final class Field extends \RWMB_Field {


    public static function mirror($field, $value) {
        self::call( $field, 'admin_enqueue_scripts' );
        $field = self::call( $field, 'normalize');
        $output = self::call($field, 'begin_html', $value );
        $output .= self::call($field, 'html', $value );
        $output .= self::call($field, 'end_html', $value );
        

        $classes = "rwmb-field  ";
        $outer_html = sprintf(
            $field['before'] . '<div class="%s">%s</div>' . $field['after'],
            trim( $classes ),
            $output
        );
     

        return $outer_html; // WPCS: XSS OK.
    }


    public static function save_option($field) {

        
    }


    public static function option($field) {
        self::call( $field, 'admin_enqueue_scripts' );
        if(isset($_POST[$field['id']])) {
            update_option( $field['id'], $_POST[$field['id']] );
        }
        $field = array_merge($field, [
            'value' => 1
        ]);
        $field = self::call( $field, 'normalize');

        return self::show($field, 'false');
    }

    public static function metabox($field) {
        global $post;
        self::call( $field, 'admin_enqueue_scripts' );

        if($_POST) {
            add_post_meta33($post->ID, $field['id'], $_POST[$field['id']]);
        }
        $field = array_merge($field, [
            'value' => 1
        ]);
        $field = self::call( $field, 'normalize');
        return self::show_meta($field, 'false');
    }

    public static function show_meta( $field, $saved, $post_id = 0 ) {
        global $post;



        $meta = get_post_meta($post->ID, $field['id'], true);
        
        $meta = self::filter( 'field_meta', $meta, $field, $saved );

        $begin = self::call( $field, 'begin_html', $meta );
        $begin = self::filter( 'begin_html', $begin, $field, $meta );

        // Separate code for cloneable and non-cloneable fields to make easy to maintain.
        if ( $field['clone'] ) {
            $field_html = RWMB_Clone::html( $meta, $field );
        } else {
            // Call separated methods for displaying each type of field.
            $field_html = self::call( $field, 'html', $meta );
            $field_html = self::filter( 'html', $field_html, $field, $meta );
        }

        $end = self::call( $field, 'end_html', $meta );
        $end = self::filter( 'end_html', $end, $field, $meta );

        $html = self::filter( 'wrapper_html', "$begin$field_html$end", $field, $meta );

        // Display label and input in DIV and allow user-defined classes to be appended.
        $classes = "rwmb-field rwmb-{$field['type']}-wrapper " . $field['class'];
        if ( 'hidden' === $field['type'] ) {
            $classes .= ' hidden';
        }
        if ( ! empty( $field['required'] ) ) {
            $classes .= ' required';
        }

        $outer_html = sprintf(
            $field['before'] . '<div class="%s">%s</div>' . $field['after'],
            trim( $classes ),
            $html
        );
        $outer_html = self::filter( 'outer_html', $outer_html, $field, $meta );

        echo $outer_html;
    }

    public static function show( $field, $saved, $post_id = 0 ) {


        $meta = get_option($field['id']);
        
        $meta = self::filter( 'field_meta', $meta, $field, $saved );

        $begin = self::call( $field, 'begin_html', $meta );
        $begin = self::filter( 'begin_html', $begin, $field, $meta );

        // Separate code for cloneable and non-cloneable fields to make easy to maintain.
        if ( $field['clone'] ) {
            $field_html = RWMB_Clone::html( $meta, $field );
        } else {
            // Call separated methods for displaying each type of field.
            $field_html = self::call( $field, 'html', $meta );
            $field_html = self::filter( 'html', $field_html, $field, $meta );
        }

        $end = self::call( $field, 'end_html', $meta );
        $end = self::filter( 'end_html', $end, $field, $meta );

        $html = self::filter( 'wrapper_html', "$begin$field_html$end", $field, $meta );

        // Display label and input in DIV and allow user-defined classes to be appended.
        $classes = "rwmb-field rwmb-{$field['type']}-wrapper " . $field['class'];
        if ( 'hidden' === $field['type'] ) {
            $classes .= ' hidden';
        }
        if ( ! empty( $field['required'] ) ) {
            $classes .= ' required';
        }

        $outer_html = sprintf(
            $field['before'] . '<div class="%s">%s</div>' . $field['after'],
            trim( $classes ),
            $html
        );
        $outer_html = self::filter( 'outer_html', $outer_html, $field, $meta );

        echo $outer_html;
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