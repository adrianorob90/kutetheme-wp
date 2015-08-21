<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

vc_map( array(
    "name" => __( "Box Service", THEME_LANG),
    "base" => "box_service",
    "category" => __('Kute Theme', THEME_LANG ),
    "description" => __( "Display Box Service", THEME_LANG),
    "as_parent" => array( 'only' => 'item_service' ), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
    "show_settings_on_create" => true,
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __( "Title", THEME_LANG ),
            "param_name" => "title",
            "admin_label" => true,
        ),
        array(
			'type' => 'css_editor',
			'heading' => __( 'Css', 'js_composer' ),
			'param_name' => 'css',
			// 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
			'group' => __( 'Design options', 'js_composer' ),
            'admin_label' => false,
		)
    ),
    "js_view" => 'VcColumnView'
));
vc_map( array(
    "name"            => __("Item Service", THEME_LANG),
    "base"            => "item_service",
    "content_element" => true,
    "as_child"        => array( 'only' => 'box_service' ), // Use only|except attributes to limit parent (separate multiple values with comma)
    "params" => array(
        // add params same as with any other content element
        array(
            "type" => "textfield",
            "heading" => __( "Header", THEME_LANG ),
            "param_name" => "header",
            "admin_label" => true,
        ),
        array(
    		'type' => 'attach_image',
    		'heading' => __( 'Icon', THEME_LANG ),
    		'param_name' => 'icon',
            'description' => __( 'Setup icon for the child shortcode', THEME_LANG )
    	),
        array(
    		'type' => 'textarea',
    		'heading' => __( 'Desc', THEME_LANG ),
    		'param_name' => 'desc',
            'description' => __( 'Setup desc for the child shortcode', THEME_LANG )
    	)
    )
) );
class WPBakeryShortCode_Box_Service extends WPBakeryShortCodesContainer {
    protected function content($atts, $content = null) {
        $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'box_service', $atts ) : $atts;
        extract( shortcode_atts( array(
            'title'    => 'Box service',
            'css'      => '',
            'el_class' => '',
        ), $atts ) );
        
        $elementClass = array(
        	'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'services2 ', $this->settings['base'], $atts ),
        	'extra' => $this->getExtraClass( $el_class ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
        );
        
        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        ob_start();
        ?>
        <div class="<?php echo $elementClass; ?>">
            <ul>
                <?php echo do_shortcode( shortcode_unautop( $content ) );  ?>
            </ul>
        </div>
        <?php
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }
}
class WPBakeryShortCode_Item_Service extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'item_service', $atts ) : $atts;
        extract( shortcode_atts( array(
            'header' => 'Item service',
            'link'   => '#',
            'icon'   => '',
            'desc'   => '',
        ), $atts ) );
        ob_start();
        ?>
        <li class="col-xs-12 col-sm-6 col-md-4 services2-item">
            <div class="service-wapper">
                <div class="row">
                    <div class="col-sm-6 image">
                        <div class="icon">
                            <?php 
                                if( isset( $icon ) && $icon ): 
                                    $att_icon = wp_get_attachment_image_src( $icon, '64x64' );  
                                    $att_icon_url =  is_array( $att_icon ) ? esc_url( $att_icon[0] ) : ""; 
                                endif; 
                            ?>
                            <img alt="<?php  echo ( isset( $header ) && $header ) ? $header : __( 'Header', THEME_LANG );  ?>" src="<?php echo $att_icon_url; ?>" />
                        </div>
                        <h3 class="title"><a href="<?php echo esc_attr( $link ) ?>"><?php echo $header; ?></a></h3>
                    </div>
                    <div class="col-sm-6 text">
                        <?php echo $desc; ?>
                    </div>
                </div>
            </div>
        </li>
        <?php
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }
}