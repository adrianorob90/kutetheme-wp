<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;
if( ! kt_is_wc() ) return;
// Setting shortcode service
vc_map( array(
    "name" => __( "Lastest Deal Products Carousel", THEME_LANG),
    "base" => "lastest_deal_products",
    "category" => __('Kute Theme', THEME_LANG ),
    "description" => __( "List lastest deal product are display by owl carousel", THEME_LANG),
    "params" => array(
        array(
            "type" => "textfield",
            "heading" => __( "Title", THEME_LANG ),
            "param_name" => "title",
            "admin_label" => true,
            'description' => __( 'It displays title list product', THEME_LANG )
        ),
        array(
            "type"      => 'kt_product_taxonomy',
            'taxonomy'  => 'product_cat',
            'class'     => '',
            "heading" => __("Category", THEME_LANG),
            "param_name" => "taxonomy",
            "value" => '',
            'multiple' => false,
            "placeholder" => 'Please select your category',
            "description" => __("Note: By default, all your catrgory will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed. if nothing selected will show all of categories.", THEME_LANG)
        ),
        array(
            "type" => "textfield",
            "heading" => __("Number Product", THEME_LANG),
            "param_name" => "number",
            "value" => 12,
            "description" => __("Enter number of Product", THEME_LANG)
        ),
        array(
            "type" => "textfield",
            "heading" => __("Product per columns", THEME_LANG),
            "param_name" => "product_column",
            "value" => 3,
            "description" => __("Enter number product on columns", THEME_LANG)
        ),
        array(
            "type" => "dropdown",
        	"heading" => __("Order by", THEME_LANG),
        	"param_name" => "orderby",
        	"value" => array(
        		__('None', THEME_LANG) => 'none',
                __('ID', THEME_LANG) => 'ID',
                __('Author', THEME_LANG) => 'author',
                __('Name', THEME_LANG) => 'name',
                __('Date', THEME_LANG) => 'date',
                __('Modified', THEME_LANG) => 'modified',
                __('Rand', THEME_LANG) => 'rand',/*
                __('Regular Price', THEME_LANG) => '_regular_price',
                __('Sale Price', THEME_LANG) => '_sale_price',*/
        	),
            'std' => 'date',
        	"description" => __("Select how to sort retrieved posts.",THEME_LANG),
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
        	"description" => __("Designates the ascending or descending order.",THEME_LANG),
        ),
        array(
            "type" => "textfield",
            "heading" => __( "Extra class name", THEME_LANG ),
            "param_name" => "el_class",
            "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
        ),
        // Carousel
        array(
			'type' => 'checkbox',
			'heading' => __( 'AutoPlay', THEME_LANG ),
			'param_name' => 'autoplay',
			'value' => array( __( 'Yes, please', THEME_LANG ) => 'true' ),
            'group' => __( 'Carousel settings', THEME_LANG )
		),
        array(
			'type' => 'checkbox',
            'heading' => __( 'Navigation', THEME_LANG ),
			'param_name' => 'navigation',
			'value' => array( __( "Don't use Navigation", THEME_LANG ) => 'false' ),
            'description' => __( "Don't display 'next' and 'prev' buttons.", THEME_LANG ),
            'group' => __( 'Carousel settings', THEME_LANG )
		),
        array(
			'type' => 'checkbox',
            'heading' => __( 'Loop', THEME_LANG ),
			'param_name' => 'loop',
			'value' => array( __( "Loop", THEME_LANG ) => 'false' ),
            'description' => __( "Inifnity loop. Duplicate last and first items to get loop illusion.", THEME_LANG ),
            'group' => __( 'Carousel settings', THEME_LANG )
		),
        array(
			"type" => "kt_number",
			"heading" => __("Slide Speed", THEME_LANG),
			"param_name" => "slidespeed",
			"value" => "200",
            "suffix" => __("milliseconds", THEME_LANG),
			"description" => __('Slide speed in milliseconds', THEME_LANG),
            'group' => __( 'Carousel settings', THEME_LANG )
	  	),
        array(
			"type" => "kt_number",
			"heading" => __("Margin", THEME_LANG),
			"param_name" => "margin",
			"value" => "30",
            "suffix" => __("px", THEME_LANG),
			"description" => __('Distance( or space) between 2 item', THEME_LANG),
            'group' => __( 'Carousel settings', THEME_LANG )
	  	),
        array(
			'type' => 'checkbox',
            'heading' => __( 'Don\'t Use Carousel Responsive', THEME_LANG ),
			'param_name' => 'use_responsive',
			'value' => array( __( "Don't use Responsive", THEME_LANG ) => 'false' ),
            'description' => __( "Try changing your browser width to see what happens with Items and Navigations", THEME_LANG ),
            'group' => __( 'Carousel responsive', THEME_LANG )
		),
        array(
			"type" => "kt_number",
			"heading" => __("The items on destop (Screen resolution of device >= 992px )", THEME_LANG),
			"param_name" => "items_destop",
			"value" => "3",
            "suffix" => __("item", THEME_LANG),
			"description" => __('The number of item on destop', THEME_LANG),
            'group' => __( 'Carousel responsive', THEME_LANG )
	  	),
        array(
			"type" => "kt_number",
			"heading" => __("The items on tablet (Screen resolution of device >=768px and < 992px )", THEME_LANG),
			"param_name" => "items_tablet",
			"value" => "2",
            "suffix" => __("item", THEME_LANG),
			"description" => __('The number of item on destop', THEME_LANG),
            'group' => __( 'Carousel responsive', THEME_LANG )
	  	),
        array(
			"type" => "kt_number",
			"heading" => __("The items on mobile (Screen resolution of device < 768px)", THEME_LANG),
			"param_name" => "items_mobile",
			"value" => "1",
            "suffix" => __("item", THEME_LANG),
			"description" => __('The number of item on destop', THEME_LANG),
            'group' => __( 'Carousel responsive', THEME_LANG )
	  	),
        
        array(
			'type' => 'css_editor',
			'heading' => __( 'Css', THEME_LANG ),
			'param_name' => 'css',
			// 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
			'group' => __( 'Design options', THEME_LANG )
		)
    )
));
class WPBakeryShortCode_Lastest_Deal_Products extends WPBakeryShortCode {
    
    protected function content($atts, $content = null) {
        $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'lastest_deal_products', $atts ) : $atts;
        $atts = shortcode_atts( array(
            'title'    => '&nbsp;',
            'taxonomy' => '',
            'number'   => 10,
            'product_column' => 5,
            'orderby' =>'date',
            'order' => 'DESC',
            //Carousel            
            'autoplay' => '', 
            'navigation' => '',
            'margin'    => 10,
            'slidespeed' => 200,
            'css' => '',
            'el_class' => '',
            'nav' => "true",
            'loop'  => "true",
            //Default
            'use_responsive' => 0,
            'items_destop' => 5,
            'items_tablet' => 3,
            'items_mobile' => 1,
            //
            'columns' => 1,
        ), $atts );
        extract($atts);
        // Get products on sale
		$product_ids_on_sale = wc_get_product_ids_on_sale();

		$meta_query = WC()->query->get_meta_query();
        
        $args = array(
			'posts_per_page' => $number,
            'post_type'      => 'product',
            'order'          => $order,
            'no_found_rows' 	=> 1,
			'post_status' 		=> 'publish',
			'meta_query' 		=> $meta_query,
			'post__in'			=> array_merge( array( 0 ), $product_ids_on_sale )
		);
        $args["orderby"] = $orderby;
        
        if($taxonomy){
            $args['tax_query'] = 
                array(
            		array(
            			'taxonomy' => 'product_cat',
            			'field' => 'id',
            			'terms' => explode( ",", $taxonomy )
            		)
                );
        }
        $q = apply_filters( 'woocommerce_shortcode_products_query', $args, $atts );
        $query_product = new WP_Query( $q );
        global $woocommerce_loop, $post;
        $woocommerce_loop['columns'] = $columns;
        
        ob_start();
        if ( $query_product->have_posts() ) : 
            $data_carousel = array(
                "autoplay"      => $autoplay,
                "navigation"    => $navigation,
                "margin"        => $margin,
                "slidespeed"    => $slidespeed,
                "theme"         => 'style-navigation-bottom',
                "autoheight"    => "false",
                'nav'           => "true",
                'dots'          => "false"
            );
            if(!$use_responsive){
                $arr = array('0' => array("items" => $items_mobile), '768' => array("items" => $items_tablet), '992' => array("items" => $items_destop));
                $data_responsive = json_encode($arr);
                $data_carousel["responsive"] = $data_responsive;
            }else{
                if( $product_column > 0 )
                    $data_carousel['items'] =  $product_column;
            }
            
            $elementClass = array(
                'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
            );
            $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        ?>
        <div class="<?php  echo esc_attr($el_class); ?>">
            <?php if( $title ): ?>
            <h2 class="page-heading">
                <span class="page-heading-title"><?php echo esc_html($title); ?></span>
            </h2>
            <?php endif; ?>
            <div class="latest-deals-product container-data-time">
                <span class="count-down-time2">
                    <span class="icon-clock"></span>
                    <span><?php _e( 'end in', THEME_LANG ); ?></span>
                    <span class="countdown-lastest stick-countdown"></span>
                </span>
                <ul class="product-list owl-carousel" <?php echo _data_carousel($data_carousel); ?>>
                     <?php
                        add_filter( 'kt_template_loop_product_thumbnail_size', array( $this, 'kt_thumbnail_size_204x249' ) );
        				add_filter("woocommerce_get_price_html_from_to", "kt_get_price_html_from_to", 10 , 4);
                        add_filter( 'woocommerce_sale_price_html', 'woocommerce_custom_sales_price', 10, 2 );
                        while ( $query_product->have_posts() ) : $query_product->the_post(); $id = get_the_ID(); global $post;  ?>
                            <li>
                                <input class="data-time" type="hidden" <?php do_action('woocommerce_datatime_sale_product', $id, $post) ?> />
        					   <?php wc_get_template_part( 'content', 'product-lastest-deal' );?>
                            </li>
                        <?php
        				endwhile; // end of the loop.
                        remove_filter( 'kt_template_loop_product_thumbnail_size', array( $this, 'kt_thumbnail_size_204x249' ) );
                        remove_filter( "woocommerce_get_price_html_from_to", "kt_get_price_html_from_to", 10 , 4);
                        remove_filter( 'woocommerce_sale_price_html', 'woocommerce_custom_sales_price', 10, 2 );
                     ?>
                </ul>
            </div>
        </div>
        <?php
        endif; wp_reset_postdata();wp_reset_query();
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }
    public function kt_thumbnail_size_204x249(){
        return '204x249';
    }
}
