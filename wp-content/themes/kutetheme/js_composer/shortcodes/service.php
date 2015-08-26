<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

// Setting shortcode service
vc_map( array(
    "name" => __( "Service", 'kutetheme'),
    "base" => "service",
    "category" => __('Kute Theme', 'kutetheme' ),
    "description" => __( "Display service box", 'kutetheme'),
    "params" => array(
        array(
            "type"        => "textfield",
            "heading"     => __( "Items", 'kutetheme' ),
            "param_name"  => "items",
            "admin_label" => false,
            "std"         => 4,
            'description' => __( 'Display of items', 'kutetheme' )
        ),
        array(
            "type"        => "dropdown",
            "heading"     => __("Display Style", 'kutetheme'),
            "param_name"  => "style",
            "admin_label" => true,
            "value"       => array(
                'Style 1'   => '1',
                'Style 2'   => '2',
            ),
            "std"         => 1,
            "description" => __("The description", 'kutetheme')
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
            "heading" => __( "Extra class name", 'kutetheme' ),
            "param_name" => "el_class",
            "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
        )
    )
));
class WPBakeryShortCode_Service extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'service', $atts ) : $atts;
        $atts = shortcode_atts( array(
            'items' => 4,            
            'css_animation' => '',
            'el_class' => '',
            'css' => '',
            'style'=>1
            
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
            if($style==1):
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
        <?php elseif($style==2):?>
            <!-- Show display style 2 -->
            <div class="services2">
                <ul>
                    <?php
                    while ($service_query->have_posts()) {
                        $service_query->the_post();
                        $meta = get_post_meta( get_the_ID());
                        ?>
                        <li class="col-xs-12 col-sm-6 col-md-4 services2-item">
                            <div class="service-wapper">
                                <div class="row">
                                    <div class="col-sm-6 image">
                                        <?php if(has_post_thumbnail()):?>
                                        <div class="icon">
                                            <?php the_post_thumbnail(array(64, 64));?>
                                        </div>
                                    <?php endif;?>
                                        <h3 class="title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                                    </div>
                                    <div class="col-sm-6 text">
                                        <?php if(isset($meta['_kt_page_service_desc'])):?>
                                        <?php echo $meta['_kt_page_service_desc'][0];?>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
        <?php endif;?>
            <?php
        }
    }
}