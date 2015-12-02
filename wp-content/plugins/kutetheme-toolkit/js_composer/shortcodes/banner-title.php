<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

vc_map( array(
    "name" => __( "KT Banner", 'kutetheme'),
    "base" => "kt_banner",
    "category" => __('Kute Theme', 'kutetheme' ),
    "description" => __( 'Display a banner', 'kutetheme' ),
    "params" => array(
        array(
            "type"        => "dropdown",
            "heading"     => __("Banner Style", 'kutetheme'),
            "param_name"  => "banner_style",
            "admin_label" => true,
            'std'         => 'style-1',
            'value'       => $style_banner,
        ),
        array(
            "type"        => "attach_image",
            "heading"     => __("Banner Image", 'kutetheme'),
            "param_name"  => "banner_image",
            "admin_label" => false,
            'description' => __( 'It shows the image of banner', 'kutetheme' ),
            "dependency"  => array( "element" => "banner_style", "value" => array( 'style-1' )),
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("Link", 'kutetheme'),
            "param_name"  => "link",
            "admin_label" => false,
            'description' => __( 'It shows the link.', 'kutetheme' ),
            "dependency"  => array( "element" => "banner_style", "value" => array( 'style-1' )),
        ),
        array(
            'type'  => 'dropdown',
            'value' => array(
                __( 'Enable', 'js_composer' )  => 'on',
                __( 'Disable', 'js_composer' ) => 'off',
                
            ),
            'heading'     => __( 'Enable CountDown', 'kutetheme' ),
            'param_name'  => 'enable_countdown',
            'admin_label' => false,
            "dependency"  => array( "element" => "banner_style", "value" => array( 'style-1' )),
		),
        
        array(
            'type'  => 'kt_datetimepicker',
            'heading'     => __( 'Time', 'kutetheme' ),
            'param_name'  => 'time',
            'admin_label' => false,
            "dependency"  => array( "element" => "enable_countdown", "value" => array( 'on' )),
		),
        
        array(
            "type" => "textfield",
            "heading" => __( "Extra class name", "js_composer" ),
            "param_name" => "el_class",
            "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
            'admin_label' => false,
        ),
        array(
            'type' => 'css_editor',
            'heading' => __( 'Css', 'kutetheme' ),
            'param_name' => 'css',
            // 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'kutetheme' ),
            'group' => __( 'Design options', 'kutetheme' ),
            'admin_label' => false,
        ),
    ),
));

class WPBakeryShortCode_Kt_Banner extends WPBakeryShortCode {
    
    protected function content($atts, $content = null) {
        $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'kt_banner', $atts ) : $atts;
        $atts = shortcode_atts( array(
            'banner_style'  => '',
            'banner_image'  => '',
            'link'          => '#',
            'enable_countdown' => 'off',
            'el_class'      => '',
            'css'           => ''
            
        ), $atts );
        extract($atts);
        $elementClass = array(
            'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' ', $this->settings['base'], $atts ),
            'extra' => $this->getExtraClass( $el_class ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
        );
        
        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        
        $banner_url = "";
        if( $banner_image ){
            $banner = wp_get_attachment_image_src( $banner_image , 'full' );  
            $banner_url =  is_array($banner) ? esc_url($banner[0]) : ''; 
        }

        ob_start();
        
        return ob_get_clean();
    }
    

}