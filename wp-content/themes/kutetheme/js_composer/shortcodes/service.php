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
                "type"        => "textfield",
                "heading"     => __( "Items", THEME_LANG ),
                "param_name"  => "items",
                "admin_label" => false,
                "std"         => 4,
                'description' => __( 'Display of items', THEME_LANG )
            ),
            array(
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
            'items' => 4,            
            'css_animation' => '',
            'el_class' => '',
            'css' => '',
            
        ), $atts );
        extract($atts);
        
        
        $elementClass = array(
            'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'service ', $this->settings['base'], $atts ),
            'extra' => $this->getExtraClass( $el_class ),
            'css_animation' => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
        );
        
        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        $args = array(
              'post_type' => 'service',
              'orderby'   => 'title',
              'order'     => 'ASC',
              'post_status' => 'publish',
              'posts_per_page' => $items,
            );
        $service_query = new WP_Query($args);
        if($service_query->have_posts()){
            ?>
            <div class="service-wapper">
            <div class="<?php echo esc_attr( $elementClass ); ?>">
            <?php
            while ($service_query->have_posts()) {
                $service_query->the_post();
                $meta = get_post_meta( get_the_ID());
                ?>
                <div class="col-xs-12 com-sm-6 col-md-3 service-item">
                    <?php if(has_post_thumbnail()):?>
                    <div class="icon">
                        <?php the_post_thumbnail(array(40, 40));?>
                    </div>
                    <?php endif;?>
                    <div class="info">
                        <a href="<?php the_permalink();?>"><h3><?php the_title();?></h3></a>
                        <?php if(isset($meta['_kt_page_service_sub_title'])):?>
                        <span><?php echo $meta['_kt_page_service_sub_title'][0];?></span>
                    <?php endif;?>
                    </div>
                </div>
                <?php
            }
            ?>
            </div>
            </div>
            <?php
        }
    }
}