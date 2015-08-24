<?php

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

if( ! kt_is_wc() ) return;
vc_map( array(
    "name" => __( "List Products", THEME_LANG),
    "base" => "list_product",
    "category" => __('Kute Theme', THEME_LANG ),
    "description" => __( 'Show product in tab best sellers, on sales, new products on option 1', THEME_LANG ),
    "params" => array(
        array(
			'type' => 'textfield',
			'heading' => __( 'Title', THEME_LANG ),
			'value' => __( 'Special Products', THEME_LANG ),
			'param_name' => 'title',
			'description' => __( 'The "per_page" shortcode determines how many products to show on the page', THEME_LANG ),
            'admin_label' => false,
		),
        
        array(
            "type" => "kt_categories",
        	"heading" => __("Choose Category", THEME_LANG),
        	"param_name" => "cat",
            "admin_label" => true,
        ),
        array(
        	'type' => 'dropdown',
        	'heading' => __( 'Number Product', THEME_LANG ),
        	'param_name' => 'number',
        	'admin_label' => false,
        	'value' => array(
        		__( '2 Products', THEME_LANG ) => '2',
        		__( '3 Products', THEME_LANG ) => '3',
        		__( '4 Products', THEME_LANG ) => '4',
        		__( '6 Products', THEME_LANG ) => '6',
        	),
        	'description' => __( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', THEME_LANG )
        ),
        array(
        	'type' => 'dropdown',
        	'heading' => __( 'Type', THEME_LANG ),
        	'param_name' => 'types',
        	'admin_label' => false,
        	'value' => array(
        		__( 'Best saler', THEME_LANG )   => 'sale',
        		__( 'New arrivals', THEME_LANG ) => 'arrival',
        		__( 'Most Reviews', THEME_LANG ) => 'review'
        	),
        	'description' => __( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', THEME_LANG )
        ),
        array(
        	'type' => 'dropdown',
        	'heading' => __( 'CSS Animation', THEME_LANG ),
        	'param_name' => 'css_animation',
        	'admin_label' => false,
        	'value' => array(
        		__( 'No', THEME_LANG ) => '',
        		__( 'Top to bottom', THEME_LANG ) => 'top-to-bottom',
        		__( 'Bottom to top', THEME_LANG ) => 'bottom-to-top',
        		__( 'Left to right', THEME_LANG ) => 'left-to-right',
        		__( 'Right to left', THEME_LANG ) => 'right-to-left',
        		__( 'Appear from center', THEME_LANG ) => "appear"
        	),
        	'description' => __( 'Select type of animation if you want this element to be animated when it enters into the browsers viewport. Note: Works only in modern browsers.', THEME_LANG )
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
			'heading' => __( 'Css', THEME_LANG ),
			'param_name' => 'css',
			// 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', THEME_LANG ),
			'group' => __( 'Design options', THEME_LANG ),
            'admin_label' => false,
		),
    ),
));

class WPBakeryShortCode_List_Product extends WPBakeryShortCode {
    
    protected function content($atts, $content = null) {
        $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'list_product', $atts ) : $atts;
        $atts = shortcode_atts( array(
            'title'  => '',
            'cat'    => 0,
            'number' => 4,
            'types'  => 'sale',
            'css_animation' => '',
            'el_class' => '',
            'css' => ''
            
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
        
        ob_start();
        $meta_query = WC()->query->get_meta_query();
        $query = array(
			'post_type'				=> 'product',
			'post_status'			=> 'publish',
			'ignore_sticky_posts'	=> 1,
			'posts_per_page' 		=> $number,
			'meta_query' 			=> $meta_query,
		);
        global $woocommerce_loop;
        $woocommerce_loop['columns'] = $number;
        
        if($cat > 0){
            $query['tax_query'] = array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'id',
                    'terms'    => $cat,
                ),
            );
        }
        
        if( $types == 'arrival' ){
            $query['orderby'] = 'date';
            $query['order']   = 'DESC';
        }
        
        if( $types == 'sale' ){
            $product_ids_on_sale = wc_get_product_ids_on_sale();
            $query['meta_key'] = 'total_sales';
            $query['orderby']  = 'meta_value_num';
            $query['post__in'] = array_merge( array( 0 ), $product_ids_on_sale );
        }
        
        if( $types  == 'review' ) {
            add_filter( 'posts_clauses', array( __CLASS__, 'order_by_rating_post_clauses' ) );
        }
        
        $products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $query, $atts ));
        
        if($types == 'review'){
            remove_filter( 'posts_clauses', array( __CLASS__, 'order_by_rating_post_clauses' ) );
        }
        
        if ( $products->have_posts() ) :
        ?>
        <div class="mega-group">
            <h4 class="mega-group-header"><?php echo esc_attr( $title ); ?></h4>
            <div class="mega-products">
                <?php while ( $products->have_posts() ) : $products->the_post();?>
                    <?php wc_get_template_part( 'content', 'product-verticalmenu' ); ?>
                <?php endwhile; // end of the loop. ?>
            </div>
        </div>  
        <?php 
        endif;
        return ob_get_clean();
    }
    function kt_thumbnail_size(){
        return '248x303';
    }
}



