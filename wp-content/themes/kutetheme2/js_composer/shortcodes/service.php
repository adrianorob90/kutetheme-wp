<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

if( class_exists( 'WPBakeryShortCode' ) ){
    // Setting shortcode service
    vc_map( array(
        "name" => __( "Service", THEME_LANG),
        "base" => "service",
        "category" => __('Kute Theme', THEME_LANG ),
        "description" => __( "Display service box", THEME_LANG),
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __( "Title", THEME_LANG ),
                "param_name" => "title",
                "admin_label" => true,
                'description' => __( 'Display title service box, It\'s hidden when empty', THEME_LANG )
            ),
            array(
                "type" => "textfield",
                "heading" => __( "Subtitle", THEME_LANG ),
                "param_name" => "subtitle",
                "admin_label" => false,
                'description' => __( 'Display subtitle service box', THEME_LANG )
            ),
            array(
                "type" => "attach_image",
                "heading" => __( "Icon", THEME_LANG ),
                "param_name" => "icon",
                "admin_label" => false,
                'description' => __( 'Upload icon', THEME_LANG )
            ),
            array(
                "type" => "textfield",
                "heading" => __( "Link", THEME_LANG ),
                "param_name" => "href",
                "admin_label" => false,
                'description' => __( 'Navigation', THEME_LANG )
            ),array(
    			'type' => 'css_editor',
    			'heading' => __( 'Css', 'js_composer' ),
    			'param_name' => 'css',
    			// 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
    			'group' => __( 'Design options', 'js_composer' )
    		),
            array(
                "type" => "textfield",
                "heading" => __( "Extra class name", THEME_LANG ),
                "param_name" => "el_class",
                "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
            )
        )
    ));
}
class WPBakeryShortCode_Service extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        $tab = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'service', $atts ) : $atts;
        $atts = shortcode_atts( array(
            'title' => '',
            'subtitle' => '',
            'icon' => '',
            'link' => '#',
            
            'css_animation' => '',
            'el_class' => '',
            'css' => '',
            
        ), $atts );
        extract($atts);
        
        
        $elementClass = array(
        	'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'service-item ', $this->settings['base'], $atts ),
        	'extra' => $this->getExtraClass( $el_class ),
        	'css_animation' => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
        );
        
        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        
        if($title){
            ob_start();
            ?>
            <div class="service">
                <div class="<?php echo esc_attr( $elementClass ); ?>">
                    <?php if($icon): ?>
                    
                    <div class="icon">
                        <?php 
                            echo wp_get_attachment_image( $icon, '40x40' );
                        ?>
                    </div>
                    <?php endif; ?>
                    <div class="info">
                        <a href="<?php echo esc_attr( $link ); ?>">
                            <h3><?php echo $title; ?></h3>
                        </a>
                        <span><?php echo $subtitle; ?></span>
                    </div>
                </div>
            </div>
            <?php
            $result = ob_get_contents();
            ob_end_clean();
            return $result;
        }else{
            return "";
        }
    }
}