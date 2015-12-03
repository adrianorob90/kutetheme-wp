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
            "type"        => "textfield",
            "heading"     => __( "Product ID", 'kutetheme' ),
            "param_name"  => "product_id",
            "admin_label" => true,
            "dependency"  => array( "element" => "banner_style", "value" => array( 'style-3' ) ),
        ),
        array(
            'type'  => 'dropdown',
            'value' => array(
                __( 'Show', 'js_composer' )  => 'style1',
                __( 'Hide', 'js_composer' )  => 'style2',
            ),
            'std'         => 'style1',
            'heading'     => __( 'Hide Background', 'kutetheme' ),
            'param_name'  => 'hide_bg',
            'admin_label' => false,
            "dependency"  => array( "element" => "banner_style", "value" => array( 'style-3', 'style-2' )),
		),
        
        array(
            "type"        => "textarea_html",
            "heading"     => __( "Title", 'kutetheme' ),
            "param_name"  => "title",
            "admin_label" => false,
            "dependency"  => array( "element" => "banner_style", "value" => array( 'style-2' ) ),
        ),
        array(
            "type"        => "textarea",
            "heading"     => __( "SubTitle", 'kutetheme' ),
            "param_name"  => "sub_title",
            "admin_label" => false,
            "dependency"  => array( "element" => "banner_style", "value" => array( 'style-2' ) ),
        ),
        array(
            "type"        => "attach_image",
            "heading"     => __("Banner Image", 'kutetheme'),
            "param_name"  => "banner_image",
            "admin_label" => false,
            'description' => __( 'It shows the image of banner', 'kutetheme' ),
            "dependency"  => array( "element" => "banner_style", "value" => array( 'style-1', 'style-2', 'style-3' )),
        ),
        array(
            "type"        => "textfield",
            "heading"     => __("Link", 'kutetheme'),
            "param_name"  => "link",
            "admin_label" => false,
            'description' => __( 'It shows the link.', 'kutetheme' ),
            "dependency"  => array( "element" => "banner_style", "value" => array( 'style-1', 'style-2' )),
        ),
        array(
            'type'  => 'dropdown',
            'value' => array(
                __( 'Disable', 'js_composer' ) => 'off',
                __( 'Enable', 'js_composer' )  => 'on',
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
            'title'         => '',
            'sub_title'     => '',
            'hide_bg'       => 'style1',
            'product_id'    => '',
            'banner_image'  => '',
            'link'          => '#',
            'enable_countdown' => 'off',
            'time'          => '',
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
        $time = strtotime( $time );
        $y = date( 'Y', $time );
        $m = date( 'm', $time );
        $d = date( 'd', $time );
        $h = date( 'h', $time );
        $mi = date( 'i', $time );
        $s = date( 's', $time );
        ob_start();
        
        if( $banner_style == 'style-1' ): ?>
        <div class="featured-banner option11">
            <div class="banner-box">
                <?php if( $banner_url ): ?>
                    <a href="<?php echo esc_html( $link ) ?>">
                        <img src="<?php echo esc_url( $banner_url ) ?>" alt="" />
                    </a>
                <?php endif; ?>
                <?php if( $enable_countdown == 'on' && $y > 1970 ): ?>
                    <div class="box-countdown">
                        <h2 class="box-title"><?php _e( 'Hot deal', 'kutetheme' ) ?></h2>
                        <div class="box-countdown-inner countdown-lastest" data-y="<?php _e( esc_attr( $y ) ) ?>" data-m="<?php _e( esc_attr( $m ) ) ?>" data-d="<?php _e( esc_attr( $d ) ) ?>" data-h="<?php _e( esc_attr( $h  ) ) ?>" data-i="<?php _e( esc_attr( $mi ) ) ?>" data-s="<?php _e( esc_attr( $s ) ) ?>"></div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php elseif( $banner_style == 'style-2' ) : ?>
        <div class="featured-banner option11">
            <div class="banner-box">
                <div class="box-small-banner <?php echo esc_attr( $hide_bg ) ?>">
                    <?php if( $banner_url ) : ?>
                        <a class="banner" href="<?php echo esc_html( $link ) ?>">
                            <img src="<?php echo esc_url( $banner_url ) ?>" alt="" />
                        </a>
                    <?php endif; ?>
                    <div class="text-content">
                        <h3 class="title">
                            <?php echo apply_filters( 'kt_shortcode_banner_title' ,$title  ); ?>
                        </h3>
                        <span class="sub-title">
                            <?php echo esc_textarea( $sub_title ); ?>
                        </span>                        
                    </div>
                </div>
            </div>
        </div>
        <?php
        else:
            $meta_query = WC()->query->get_meta_query();
            
            $ids = explode( ',', $product_id );
            
            $args = array(
    			'post_type'			  => 'product',
    			'post_status'		  => 'publish',
    			'ignore_sticky_posts' => 1,
    			'posts_per_page' 	  => 1,
    			'meta_query' 		  => $meta_query,
                'suppress_filter'     => true,
    		);
            if( is_array( $ids ) && ! empty( $ids ) ){
                $args[ 'post__in' ] = $ids;
                $args [ 'orderby' ] = 'post__in';
            }
            $products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );
            if ( $products->have_posts() ) :
                remove_action( 'kt_after_shop_loop_item_title', 'woocommerce_template_loop_rating' );
                while ( $products->have_posts() ) : $products->the_post(); ?>
                    <div class="featured-banner option11">
                        <div class="box-small-banner <?php echo esc_attr( $hide_bg ) ?>">
                            <?php if( $banner_url ) : ?>
                                <a class="banner" href="<?php echo esc_html( $link ) ?>">
                                    <img src="<?php echo esc_url( $banner_url ) ?>" alt="" />
                                </a>
                            <?php endif; ?>
                            <div class="text-content">
                                <h3 class="title"><?php the_title(); ?></h3>
                                <span class="sub-title">
                                    <?php
                            			/**
                            			 * woocommerce_after_shop_loop_item_title hook
                                         * 
                            			 * @hooked woocommerce_template_loop_price - 5
                            			 * @hooked woocommerce_template_loop_rating - 10
                            			 */
                            			do_action( 'kt_after_shop_loop_item_title' );
                            		?>
                                </span>   
                            </div>
                            <div class="group-button">
                                <?php
                        			/**
                        			 * kt_loop_product_function hook
                        			 *
                                     * @hooked kt_get_tool_quickview - 1
                        			 * @hooked woocommerce_template_loop_add_to_cart - 5
                                     * @hooked kt_get_tool_compare - 10
                        			 */
                        			do_action( 'kt_loop_product_cart_function' );
                        		?>
                            </div>  
                        </div>
                    </div>
                <?php
                endwhile; // end of the loop.
                add_action( 'kt_after_shop_loop_item_title', 'woocommerce_template_loop_rating' );
            endif;
        endif;
        return ob_get_clean();
    }
    

}