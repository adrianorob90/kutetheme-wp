<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

if( ! kt_is_wc() ) return;

class WPBakeryShortCode_Tab_Producs extends WPBakeryShortCode {

    protected function content($atts, $content = null) {
        $atts = shortcode_atts( array(
            'per_page' => 12,
            'columns' => 4,
            'border_heading' => '',
            'css_animation' => '',
            'el_class' => '',
            'css' => '',   
            
            //Carousel            
            'autoplay' => 'false', 
            'navigation' => 'false',
            'margin'    => 30,
            'slidespeed' => 200,
            'css' => '',
            'el_class' => '',
            'nav' => 'true',
            'loop'  => 'true',
            //Default
            'use_responsive' => 0,
            'items_destop' => 3,
            'items_tablet' => 2,
            'items_mobile' => 1,
            
        ), $atts );
        extract($atts);

        global $woocommerce_loop;
        
        $elementClass = array(
        	'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'popular-tabs ', $this->settings['base'], $atts ),
        	'extra' => $this->getExtraClass( $el_class ),
        	'css_animation' => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
        );
        
        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        
        $elementClass = apply_filters( 'kt_product_tab_class_container', $elementClass );
        
        $tabs = array(
            'best-sellers' => __( 'Best Sellers', THEME_LANG ),
            'on-sales'     => __( 'On Sales', THEME_LANG ),
            'new-arrivals' => __( 'New Products', THEME_LANG )
        );
        
        $meta_query = WC()->query->get_meta_query();
        $args = array(
			'post_type'				=> 'product',
			'post_status'			=> 'publish',
			'ignore_sticky_posts'	=> 1,
			'posts_per_page' 		=> $per_page,
			'meta_query' 			=> $meta_query,
            'suppress_filter'       => true,
		);
        
        $uniqeID = uniqid();
        ob_start();
        ?>
        <div class="<?php echo $elementClass; ?>">
            <ul class="nav-tab">
                <?php $i = 0; ?>
                <?php foreach( $tabs as $k => $v ): ?>
                    <li <?php echo ( $i == 0 ) ? 'class="active"': '' ?> >
                        <a data-toggle="tab" href="#tab-<?php echo $k . $uniqeID  ?>"><?php echo $v; ?></a>
                        </li>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </ul>
            <div class="tab-container">
                <?php $i = 0; ?>
                <?php foreach( $tabs as $k => $v ): ?>
                    <?php 
                    $newargs = $args;
                    if( $k == 'best-sellers' ){
                        $newargs['meta_key'] = 'total_sales';
                        $newargs['orderby']  = 'meta_value_num';
                    }elseif( $k == 'on-sales' ){
                        $product_ids_on_sale = wc_get_product_ids_on_sale();
                        
                        $newargs['post__in'] = array_merge( array( 0 ), $product_ids_on_sale );
                        
                        $newargs['orderby'] = 'date';
                        $newargs['order'] 	 = 'DESC';
                    }else{
                        $newargs['orderby'] = 'date';
                        $newargs['order'] 	 = 'DESC';
                    } 
                    $products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $newargs, $atts ) );
                    
                    if ( $products->have_posts() ) :
                    
                    $data_carousel = array(
                        "autoplay" => $autoplay,
                        "navigation" => $navigation,
                        "margin"    => $margin,
                        "slidespeed" => $slidespeed,
                        "theme" => 'style-navigation-bottom',
                        "autoheight" => 'false',
                        'nav' => 'true',
                        'dots' => 'false',
                        'loop' => 'true',
                        'autoplayTimeout' => 1000,
                        'autoplayHoverPause' => 'true'
                    );
                    
                    if( ! $use_responsive){
                        $arr = array('0' => array("items" => $items_mobile), '768' => array("items" => $items_tablet), '992' => array("items" => $items_destop));
                        $data_responsive = json_encode($arr);
                        $data_carousel["responsive"] = $data_responsive;
                    }else{
                        if( $product_column > 0 )
                            $data_carousel['items'] =  $product_column;
                    }
                    
                    add_filter( 'kt_template_loop_product_thumbnail_size', array( $this, 'kt_thumbnail_size' ) );
                    ?>
                    <div id="tab-<?php echo $k . $uniqeID  ?>" class="tab-panel <?php echo ( $i == 0 ) ? 'active': '' ?>">
                        <ul class="product-list owl-carousel" <?php echo _data_carousel($data_carousel); ?>>
                            <?php while( $products->have_posts() ): $products->the_post(); ?>
                                <?php wc_get_template_part( 'content', 'product-tab' ); ?>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                    <?php 
                    
                    remove_filter( 'kt_template_loop_product_thumbnail_size', array( $this, 'kt_thumbnail_size' ) );
                    
                    endif; 
                    ?>
                    <?php 
                        wp_reset_query();
                        wp_reset_postdata();
                        $i++; 
                    ?>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
    function kt_thumbnail_size(){
        return '248x303';
    }
}



vc_map( array(
    "name" => __( "Tab Products", THEME_LANG),
    "base" => "tab_producs",
    "category" => __('Kute Theme', THEME_LANG ),
    "description" => __( 'Show product in tab best sellers, on sales, new products on option 1', 'js_composer' ),
    "params" => array(
        array(
			'type' => 'textfield',
			'heading' => __( 'Per page', 'js_composer' ),
			'value' => 12,
			'param_name' => 'per_page',
			'description' => __( 'The "per_page" shortcode determines how many products to show on the page', 'js_composer' ),
            'admin_label' => false,
		),
        array(
			'type' => 'textfield',
			'heading' => __( 'Columns', 'js_composer' ),
			'value' => 4,
			'param_name' => 'columns',
			'description' => __( 'The columns attribute controls how many columns wide the products should be before wrapping.', 'js_composer' ),
            'admin_label' => false,
		),
        
        array(
        	'type' => 'dropdown',
        	'heading' => __( 'CSS Animation', 'js_composer' ),
        	'param_name' => 'css_animation',
        	'admin_label' => false,
        	'value' => array(
        		__( 'No', 'js_composer' ) => '',
        		__( 'Top to bottom', 'js_composer' ) => 'top-to-bottom',
        		__( 'Bottom to top', 'js_composer' ) => 'bottom-to-top',
        		__( 'Left to right', 'js_composer' ) => 'left-to-right',
        		__( 'Right to left', 'js_composer' ) => 'right-to-left',
        		__( 'Appear from center', 'js_composer' ) => "appear"
        	),
        	'description' => __( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', 'js_composer' )
        ),
        array(
            "type" => "textfield",
            "heading" => __( "Extra class name", "js_composer" ),
            "param_name" => "el_class",
            "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
            'admin_label' => false,
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
			"type" => "kt_number",
			"heading" => __("Margin", THEME_LANG),
			"param_name" => "margin",
			"value" => "30",
            "suffix" => __("px", THEME_LANG),
			"description" => __('Distance( or space) between 2 item', THEME_LANG),
            'group' => __( 'Carousel settings', THEME_LANG ),
            'admin_label' => false,
	  	),
        array(
			'type' => 'checkbox',
            'heading' => __( 'Don\'t Use Carousel Responsive', THEME_LANG ),
			'param_name' => 'use_responsive',
			'value' => array( __( "Don't use Responsive", THEME_LANG ) => 'false' ),
            'description' => __( "Try changing your browser width to see what happens with Items and Navigations", THEME_LANG ),
            'group' => __( 'Carousel responsive', THEME_LANG ),
            'admin_label' => false,
		),
        array(
			"type" => "kt_number",
			"heading" => __("The items on destop (Screen resolution of device >= 992px )", THEME_LANG),
			"param_name" => "items_destop",
			"value" => "3",
            "suffix" => __("item", THEME_LANG),
			"description" => __('The number of items on destop', THEME_LANG),
            'group' => __( 'Carousel responsive', THEME_LANG ),
            'admin_label' => false,
	  	),
        array(
			"type" => "kt_number",
			"heading" => __("The items on tablet (Screen resolution of device >=768px and < 992px )", THEME_LANG),
			"param_name" => "items_tablet",
			"value" => "2",
            "suffix" => __("item", THEME_LANG),
			"description" => __('The number of items on destop', THEME_LANG),
            'group' => __( 'Carousel responsive', THEME_LANG ),
            'admin_label' => false,
	  	),
        array(
			"type" => "kt_number",
			"heading" => __("The items on mobile (Screen resolution of device < 768px)", THEME_LANG),
			"param_name" => "items_mobile",
			"value" => "1",
            "suffix" => __("item", THEME_LANG),
			"description" => __('The numbers of item on destop', THEME_LANG),
            'group' => __( 'Carousel responsive', THEME_LANG ),
            'admin_label' => false,
	  	),
        array(
			'type' => 'css_editor',
			'heading' => __( 'Css', 'js_composer' ),
			'param_name' => 'css',
			// 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
			'group' => __( 'Design options', 'js_composer' ),
            'admin_label' => false,
		),
    ),
));
