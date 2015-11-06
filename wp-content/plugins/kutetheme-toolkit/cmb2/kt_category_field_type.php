<?php
/*
 * Plugin Name: CMB2 Custom Field Type - Cate
 * Description: Makes available an 'Cate' CMB2 Custom Field Type
 * Author: AngelsIT
 * Author URI: http://kutethemes.com
 * Version: 1.0.0
 */
/**
 * Render 'Cate' custom field type
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
 *                                   but could also be `comment`, `user` or `options-Cate`.
 * @param object $field_type_object  The `CMB2_Types` object
 */
function kt_cmb2_render_cate_field_callback( $field, $value, $object_id, $object_type, $field_type_object ) {
    $args = array(
      'id'          => $field->args['id'],
      'name'        => $field->args['id'],
      'taxonomy'   => 'category',
      'hide_empty'  => 0,
      'orderby'     => 'name',
      'order'       => "desc",
      'tab_index'   => true,
      'hierarchical'=> true,
      'echo'        => 1
    );
    if( $field->value ){
        $args['selected'] = $field->value;
    }
    if( isset( $field->args['post_type'] ) && $field->args['post_type'] ){
        $args['type'] = $field->args['post_type'];
    }
    
    if( isset( $field->args['taxonomy'] ) && $field->args['taxonomy'] ){
        $args['taxonomy'] = $field->args['taxonomy'];
    }
    if( isset( $field->args['orderby'] ) && $field->args['orderby'] ){
        $args['orderby'] = $field->args['orderby'];
    }
    if( isset( $field->args['order'] ) && $field->args['order'] ){
        $args['order'] = $field->args['order'];
    }
    
    if( isset( $field->args['hide_empty'] ) && $field->args['hide_empty'] ){
        $args['hide_empty'] = $field->args['hide_empty'];
    }
    wp_dropdown_categories( $args );
    if( isset( $field->args ['description'] ) && $field->args ['description'] ){
        echo '<p class="cmb2-metabox-description">'.( $field->args ['description'] ).'</p>';
    }
}

add_filter( 'cmb2_render_cate', 'kt_cmb2_render_cate_field_callback', 10, 5 );

function cmb2_sanitize_cate_callback( $override_value, $value ) {
    
    if( ! $value ){
        return $override_value;
    }
    return $value;
}
add_filter( 'cmb2_sanitize_cate', 'cmb2_sanitize_cate_callback', 10, 2 );

