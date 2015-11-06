<?php
/*
 * Plugin Name: CMB2 Custom Field Type - Page
 * Description: Makes available an 'Page' CMB2 Custom Field Type
 * Author: AngelsIT
 * Author URI: http://kutethemes.com
 * Version: 1.0.0
 */
/**
 * Render 'Page' custom field type
 *
 * @since 0.1.0
 *
 * @param array  $field              The passed in `CMB2_Field` object
 * @param mixed  $value              The value of this field escaped.
 *                                   It defaults to `sanitize_text_field`.
 *                                   If you need the unescaped value, you can access it
 *                                   via `$field->value()`
 * @param int    $object_id          The ID of the current object
 * @param string $object_type        The type of object you are working with.
 *                                   Most commonly, `post` (this applies to all post-types),
 *                                   but could also be `comment`, `user` or `options-page`.
 * @param object $field_type_object  The `CMB2_Types` object
 */
function kt_cmb2_render_page_field_callback( $field, $value, $object_id, $object_type, $field_type_object ) {
    $args = array( 'name' => $field->args['id'], 'id' => $field->args['id'] );
    
    if( $field->value ){
        $args['selected'] = $field->value;
    }
    $option_none  = $this->field->args( 'show_option_none' );
	if ( ! empty( $option_none ) ) {
		$args['show_option_none'] = $option_none;
	}
    wp_dropdown_pages($args);
    if( isset( $field->args ['description'] ) && $field->args ['description'] ){
        echo '<p class="cmb2-metabox-description">'.( $field->args ['description'] ).'</p>';
    }
}

add_filter( 'cmb2_render_page', 'kt_cmb2_render_page_field_callback', 10, 5 );

function cmb2_sanitize_page_callback( $override_value, $value ) {
    
    if( ! $value ){
        return $override_value;
    }
    return $value;
}
add_filter( 'cmb2_sanitize_page', 'cmb2_sanitize_page_callback', 10, 2 );

