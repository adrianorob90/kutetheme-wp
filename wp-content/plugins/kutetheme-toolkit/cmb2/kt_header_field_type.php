<?php
/*
 * Plugin Name: CMB2 Custom Field Type - Header
 * Description: Makes available an 'Header' CMB2 Custom Field Type
 * Author: AngelsIT
 * Author URI: http://kutethemes.com
 * Version: 1.0.0
 */
/**
 * Render 'Header' custom field type
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
function kt_cmb2_render_header_field_callback( $field, $value, $object_id, $object_type, $field_type_object ) {
    if(isset($field->args['options']) && isset($field->args['id']) && is_array($field->args['options']) && count($field->args['options']) > 0):
        foreach($field->args['options'] as $k => $v):
        ?>
            <label class="kt_header" for="kt_header_<?php echo esc_attr( $k ) ; ?>">
                <input class="radio" style="display: none;" type="radio" <?php checked( $field->value ? $field->value : $field->escaped_value, $k ) ?> id="kt_header_<?php echo esc_attr( $k ) ; ?>" name="<?php echo  $field->args['id']; ?>" value="<?php echo esc_attr( $k ); ?>" />
                <img sty src="<?php echo esc_url( $v ) ?>" alt="<?php echo 'Header '. esc_attr( $k ) ?>"/>
            </label>
        <?php
        endforeach;
    endif;
     ?>
     <style type="text/css">
     .kt_header{
        display: block;
        margin-bottom: 10px;
     }
     .kt_header img{
        max-width: 800px;
     }
     .kt_header .radio:checked + img{
        outline: 3px solid #0073aa;
     }
     </style>
     <?php
}

add_filter( 'cmb2_render_header', 'kt_cmb2_render_header_field_callback', 10, 5 );

function cmb2_sanitize_header_callback( $override_value, $value ) {
    if( ! $value ){
        return $override_value;
    }
    return $value;
}
add_filter( 'cmb2_sanitize_header', 'cmb2_sanitize_header_callback', 10, 2 );

