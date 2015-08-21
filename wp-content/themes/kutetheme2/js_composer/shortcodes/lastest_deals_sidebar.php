<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

if( class_exists( 'WPBakeryShortCode' ) ){
    // Setting shortcode lastest
    vc_map( array(
        "name" => __( "Lastest Deals", THEME_LANG),
        "base" => "lastest_deals_sidebar",
        "category" => __('Kute Theme', THEME_LANG ),
        "description" => __( "Show lastest deal products in sidebar", THEME_LANG),
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __( "Title", THEME_LANG ),
                "param_name" => "title",
                "admin_label" => true,
                'description' => __( 'Display title lastest deal box, It\'s hidden when empty', THEME_LANG )
            ),
            array(
                "type" => "kt_number",
                "heading" => __("Number Product", THEME_LANG),
                "param_name" => "number",
                "value" => 12,
                "description" => __("Enter number of Product", THEME_LANG)
            ),
            array(
                "type" => "dropdown",
            	"heading" => __("Order by", THEME_LANG),
            	"param_name" => "orderby",
            	"value" => array(
            		__('None', THEME_LANG)     => 'none',
                    __('ID', THEME_LANG)       => 'ID',
                    __('Author', THEME_LANG)   => 'author',
                    __('Name', THEME_LANG)     => 'name',
                    __('Date', THEME_LANG)     => 'date',
                    __('Modified', THEME_LANG) => 'modified',
                    __('Rand', THEME_LANG)     => 'rand',
            	),
                'std' => 'date',
            	"description" => __("Select how to sort retrieved posts.",THEME_LANG)
            ),
            array(
                "type" => "dropdown",
            	"heading" => __("Order", THEME_LANG),
            	"param_name" => "order",
            	"value" => array(
                    __('ASC', THEME_LANG) => 'ASC',
                    __('DESC', THEME_LANG) => 'DESC'
            	),
                'std' => 'DESC',
            	"description" => __("Designates the ascending or descending order.",THEME_LANG)
            ),
            array(
    			'type' => 'css_editor',
    			'heading' => __( 'Css', 'js_composer' ),
    			'param_name' => 'css',
    			// 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
    			'group' => __( 'Design options', 'js_composer' )
    		),
            
            // Carousel
            array(
    			'type' => 'checkbox',
    			'heading' => __( 'AutoPlay', THEME_LANG ),
    			'param_name' => 'autoplay',
    			'value' => array( __( 'Yes, please', THEME_LANG ) => 'true' ),
                'group' => __( 'Carousel settings', THEME_LANG ),
                'admin_label' => false,
    		),
            array(
    			'type' => 'checkbox',
                'heading' => __( 'Navigation', THEME_LANG ),
    			'param_name' => 'navigation',
    			'value' => array( __( "Don't use Navigation", THEME_LANG ) => 'false' ),
                'description' => __( "Don't display 'next' and 'prev' buttons.", THEME_LANG ),
                'group' => __( 'Carousel settings', THEME_LANG ),
                'admin_label' => false,
    		),
            array(
    			'type' => 'checkbox',
                'heading' => __( 'Loop', THEME_LANG ),
    			'param_name' => 'loop',
    			'value' => array( __( "Loop", THEME_LANG ) => 'false' ),
                'description' => __( "Inifnity loop. Duplicate last and first items to get loop illusion.", THEME_LANG ),
                'group' => __( 'Carousel settings', THEME_LANG ),
                'admin_label' => false,
    		),
            array(
    			"type" => "kt_number",
    			"heading" => __("Slide Speed", THEME_LANG),
    			"param_name" => "slidespeed",
    			"value" => "200",
                "suffix" => __("milliseconds", THEME_LANG),
    			"description" => __('Slide speed in milliseconds', THEME_LANG),
                'group' => __( 'Carousel settings', THEME_LANG ),
                'admin_label' => false,
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
class WPBakeryShortCode_Lastest_Deals_Sidebar extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        $atts = shortcode_atts( array(
            'title'      => '',
            'number'     => 12,
            //Carousel            
            'autoplay'   => "false",
            'navigation' => "false",
            'slidespeed' => 250,
            'loop'       => "false",
            'items'      => 1,
            
            'css_animation' => '',
            'el_class'   => '',
            'css'        => '',
            
        ), $atts );
        extract($atts);
        
        
        $elementClass = array(
        	'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'latest-deals ', $this->settings['base'], $atts ),
        	'extra' => $this->getExtraClass( $el_class ),
        	'css_animation' => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
        );
        
        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        
        $elementClass = apply_filters( 'kt_lastest_deals_sidebar_class_container', $elementClass );
        
        // Get products on sale
		$product_ids_on_sale = wc_get_product_ids_on_sale();

		$meta_query = WC()->query->get_meta_query();
        
        $args = array(
			'posts_per_page' => $number,
            'post_type'      => 'product',
            'orderby'        => 'meta_value_num',
            'meta_key'       => '_sale_price_dates_to',
            'order'          => 'DESC',
            'no_found_rows'  => 1,
			'post_status' 	 => 'publish',
			'meta_query' 	 => $meta_query,
			'post__in'		 => array_merge( array( 0 ), $product_ids_on_sale )
		);
        
        $q = apply_filters( 'woocommerce_shortcode_products_query', $args, $atts );
        
        $query = new WP_Query( $q );
        
        global $woocommerce_loop;
        
        ob_start();
        
        if ( $query->have_posts() ) :
            $data_carousel = array(
                "autoplay"   => $autoplay,
                "navigation" => $navigation,
                "slidespeed" => $slidespeed,
                "autoheight" => "false",
                'loop'       => "false",
                "dots"       => "false",
                'nav'        => "true",
                "autoplayTimeout" => 1000,
                "autoplayHoverPause" => "true",
                'items'      => 1,
            );
            add_filter( 'woocommerce_sale_price_html', 'woocommerce_custom_sales_price', 10, 2 );
            ?>
            <div class="<?php echo $elementClass; ?>">
                <h2 class="latest-deal-title"><?php echo $title; ?></h2>
                <div class="latest-deal-content">
                    <ul class="product-list owl-carousel" <?php echo _data_carousel( $data_carousel ); ?>>
                        <?php
                            add_filter("woocommerce_get_price_html_from_to", "kt_get_price_html_from_to", 10 , 4);
            				while ( $query->have_posts() ) : $query->the_post();
            					wc_get_template_part( 'content', 'product-sidebar' );
            				endwhile; // end of the loop.
                            remove_filter("woocommerce_get_price_html_from_to", "kt_get_price_html_from_to", 10 , 4);
                        ?>
                    </ul>
                </div>
            </div>
            <?php
            remove_filter( 'woocommerce_sale_price_html', 'woocommerce_custom_sales_price', 10, 2 );
        endif;
        wp_reset_postdata();
        wp_reset_query();
        $result = ob_get_contents();
        ob_clean();
        return $result;
    }
}