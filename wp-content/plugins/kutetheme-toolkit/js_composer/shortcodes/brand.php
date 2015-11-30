<?php
/**
 * @author  AngelsIT
 * @package KUTE TOOLKIT
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

vc_map( array(
    "name"        => __( "Brands", 'kutetheme'),
    "base"        => "brand",
    "category"    => __('Kute Theme', 'kutetheme' ),
    "description" => __( "Display brand showcase", 'kutetheme'),
    "params"      => array(
        array(
            "type"        => "textfield",
            "heading"     => __( "Title", 'kutetheme' ),
            "param_name"  => "title",
            "admin_label" => true,
            'description' => __( 'Show tittle when "show product" is not checked', 'kutetheme' )
        ),
        array(
            'type'  => 'dropdown',
            'value' => array(
                __( 'Yes', 'js_composer' ) => 'true',
                __( 'No', 'js_composer' )  => 'false'
            ),
            'std'         => 'true',
            'heading'     => __( 'Show product', 'kutetheme' ),
            'param_name'  => 'show_product',
            'admin_label' => false,
            'description' => __( 'Yes, Box product will show by brand. If It\'s checked then Null value title is not allow', 'kutetheme' )
		),
        array(
            'type'  => 'dropdown',
            'value' => array(
                __( '1 Line', 'js_composer' )    => '1-line',
                __( '2 Line', 'js_composer' )    => '2-line',
                __( 'Show logo style 1', 'js_composer' ) => 'show-logo',
                __( 'Show logo style 2', 'js_composer' ) => 'show-logo2',
            ),
            'heading'     => __( 'Line', 'kutetheme' ),
            'param_name'  => 'line_brand',
            'admin_label' => false,
            "dependency"  => array(
                "element" => "show_product",
                "value" => array( 
                    'false' 
                )
             ),
		),
        array(
            "type"       => "dropdown",
            "heading"    => __("Order by", 'kutetheme'),
            "param_name" => "orderby",
            "value"      => array(
        		__('None', 'kutetheme')     => 'none',
                __('ID', 'kutetheme')       => 'ID',
                __('Author', 'kutetheme')   => 'author',
                __('Name', 'kutetheme')     => 'name',
                __('Date', 'kutetheme')     => 'date',
                __('Modified', 'kutetheme') => 'modified',
                __('Rand', 'kutetheme')     => 'rand',
        	),
            'std'         => 'date',
            "description" => __("Select how to sort retrieved posts.",'kutetheme'),
        ),
        array(
            "type"       => "dropdown",
            "heading"    => __("Order", 'kutetheme'),
            "param_name" => "order",
            "value"      => array(
                __('ASC', 'kutetheme')  => 'ASC',
                __('DESC', 'kutetheme') => 'DESC'
        	),
            'std'         => 'DESC',
            "description" => __("Designates the ascending or descending order.",'kutetheme')
        ),

        // Carousel
        array(
            'type'  => 'dropdown',
            'value' => array(
                __( 'Yes', 'js_composer' ) => 'true',
                __( 'No', 'js_composer' )  => 'false'
            ),
            'std'         => 'false',
            'heading'     => __( 'AutoPlay', 'kutetheme' ),
            'param_name'  => 'autoplay',
            'group'       => __( 'Carousel settings', 'kutetheme' ),
            'admin_label' => false
		),
        array(
            'type'  => 'dropdown',
            'value' => array(
                __( 'Yes', 'js_composer' ) => 'true',
                __( 'No', 'js_composer' )  => 'false'
            ),
            'std'         => 'false',
            'heading'     => __( 'Navigation', 'kutetheme' ),
            'param_name'  => 'navigation',
            'description' => __( "Show buton 'next' and 'prev' buttons.", 'kutetheme' ),
            'group'       => __( 'Carousel settings', 'kutetheme' ),
            'admin_label' => false,
		),
        array(
            'type'  => 'dropdown',
            'value' => array(
                __( 'Yes', 'js_composer' ) => 'true',
                __( 'No', 'js_composer' )  => 'false'
            ),
            'std'         => 'false',
            'heading'     => __( 'Loop', 'kutetheme' ),
            'param_name'  => 'loop',
            'description' => __( "Inifnity loop. Duplicate last and first items to get loop illusion.", 'kutetheme' ),
            'group'       => __( 'Carousel settings', 'kutetheme' ),
            'admin_label' => false,
		),
        array(
            "type"        => "kt_number",
            "heading"     => __("Slide Speed", 'kutetheme'),
            "param_name"  => "slidespeed",
            "value"       => "250",
            "suffix"      => __("milliseconds", 'kutetheme'),
            "description" => __('Slide speed in milliseconds', 'kutetheme'),
            'group'       => __( 'Carousel settings', 'kutetheme' ),
            'admin_label' => false,
	  	),
        array(
            "type"        => "kt_number",
            "heading"     => __("Margin", 'kutetheme'),
            "param_name"  => "margin",
            "value"       => 1,
            "suffix"      => __("px", 'kutetheme'),
            "description" => __('Distance( or space) between 2 item', 'kutetheme'),
            'group'       => __( 'Carousel settings', 'kutetheme' ),
            'admin_label' => false,
	  	),
        array(
            'type'  => 'dropdown',
            'value' => array(
                __( 'Yes', 'js_composer' ) => 1,
                __( 'No', 'js_composer' )  => 0
            ),
            'std'         => 1,
            'heading'     => __( 'Use Carousel Responsive', 'kutetheme' ),
            'param_name'  => 'use_responsive',
            'description' => __( "Try changing your browser width to see what happens with Items and Navigations", 'kutetheme' ),
            'group'       => __( 'Carousel responsive', 'kutetheme' ),
            'admin_label' => false,
		),
        array(
            "type"        => "kt_number",
            "heading"     => __("The items on destop (Screen resolution of device >= 992px )", 'kutetheme'),
            "param_name"  => "items_destop",
            "value"       => "8",
            "suffix"      => __("item", 'kutetheme'),
            "description" => __('The number of items on destop', 'kutetheme'),
            'group'       => __( 'Carousel responsive', 'kutetheme' ),
            'admin_label' => false,
	  	),
        array(
            "type"        => "kt_number",
            "heading"     => __("The items on tablet (Screen resolution of device >=768px and < 992px )", 'kutetheme'),
            "param_name"  => "items_tablet",
            "value"       => "6",
            "suffix"      => __("item", 'kutetheme'),
            "description" => __('The number of items on destop', 'kutetheme'),
            'group'       => __( 'Carousel responsive', 'kutetheme' ),
            'admin_label' => false,
	  	),
        array(
            "type"        => "kt_number",
            "heading"     => __("The items on mobile (Screen resolution of device < 768px)", 'kutetheme'),
            "param_name"  => "items_mobile",
            "value"       => "4",
            "suffix"      => __("item", 'kutetheme'),
            "description" => __('The numbers of item on destop', 'kutetheme'),
            'group'       => __( 'Carousel responsive', 'kutetheme' ),
            'admin_label' => false,
	  	),
        array(
            'type'           => 'css_editor',
            'heading'        => __( 'Css', 'js_composer' ),
            'param_name'     => 'css',
            // 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
            'group'          => __( 'Design options', 'js_composer' )
		),
        array(
            "type"        => "textfield",
            "heading"     => __( "Extra class name", 'kutetheme' ),
            "param_name"  => "el_class",
            "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
        )
    )
));
class WPBakeryShortCode_Brand extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'brand', $atts ) : $atts;
                        
        $atts = shortcode_atts( array(
            'title'          => '',
            'line_brand'     => '1-line',
            'show_product'   => 'true',
            'orderby'        => 'date',
            'order'          => 'desc',
            'css_animation'  => '',
            'el_class'       => '',
            'css'            => '',
            
            //Carousel            
            'autoplay'       => 'false', 
            'navigation'     => 'false',
            'margin'         => 1,
            'slidespeed'     => 250,
            'css'            => '',
            'css_animation'  => '',
            'el_class'       => '',
            'nav'            => 'true',
            'loop'           => 'true',
            
            //Default
            'use_responsive' => 1,
            'items_destop'   => 8,
            'items_tablet'   => 6,
            'items_mobile'   => 4,
            
        ), $atts );
        extract($atts);
        
        $elementClass = array(
            'base'             => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'brand ', $this->settings['base'], $atts ),
            'extra'            => $this->getExtraClass( $el_class ),
            'css_animation'    => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
        );
        $data_carousel = array(
            "autoplay"           => $autoplay,
            "nav"               => $navigation,
            "margin"             => $margin,
            "slidespeed"         => $slidespeed,
            "theme"              => 'style-navigation-bottom',
            "autoheight"         => 'false',
            'dots'               => 'false',
            'loop'               => $loop,
            'autoplayTimeout'    => 1000,
            'autoplayHoverPause' => 'true'
        );
        
        if( $use_responsive){
            $arr = array( 
                '0'   => array( 
                    "items" => $items_mobile 
                ), 
                '768' => array( 
                    "items" => $items_tablet 
                ), 
                '992' => array(
                    "items" => $items_destop
                )
            );
            $data_responsive = json_encode($arr);
            $data_carousel["responsive"] = $data_responsive;
        }else{
            $data_carousel['items'] = 8;
        }
        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        ob_start();
        //Set up the taxonomy object and get terms
		$tax   = get_taxonomy('product_brand');
        if( $tax ):
    		$terms = get_terms( 'product_brand',array( 'hide_empty' => 0, 'orderby' => $orderby, 'order' => $order ) );
            if( ! is_wp_error($terms) && count( $terms ) > 0 ) :
                if( $show_product == "true" ) :
                    ?>
                    <div class="brand-showcase <?php echo esc_attr( $elementClass ); ?>">
                        <?php if( $title ): ?>
                            <h2 class="brand-showcase-title"><?php echo esc_html( $title ) ; ?></h2>
                        <?php endif; ?>
                        <div class="brand-showcase-box">
                            <ul class="brand-showcase-logo owl-carousel" <?php echo _data_carousel($data_carousel); ?>>
                                <?php $i = 1; ?>
                                <?php foreach($terms as $term): ?>
                                <li data-tab="showcase-<?php echo esc_attr( $term->term_id ); ?>" class="item<?php echo ( $i ==1 ) ? ' active' : '' ?>">
                                    <h3><?php echo esc_html( $term->name ); ?></h3>
                                </li>
                                <?php $i ++ ; ?>
                                <?php endforeach; ?>
                            </ul>
                            <div class="brand-showcase-content">
                                <?php $i = 1; ?>
                                <?php //add_filter( 'kt_template_loop_product_thumbnail_size', array( $this, 'kt_thumbnail_size' ) ); ?>
                                <?php foreach($terms as $term): ?>
                                    <div class="brand-showcase-content-tab<?php echo ( $i ==1 ) ? ' active' : '' ?>" id="showcase-<?php echo esc_attr( $term->term_id ) ?>">
                                        <?php 
                                        $term_link = get_term_link( $term );
                                        
                                        $thumbnail_id = absint( get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true ) );
        
                                		if ( $thumbnail_id ) {
                                		  $image = wp_get_attachment_image( intval( $thumbnail_id ), 'full' );
                                		} else {
                                			$image = "";
                                		}
                                        $meta_query = WC()->query->get_meta_query();
                                        $args = array(
                                			'post_type'				=> 'product',
                                			'post_status'			=> 'publish',
                                			'ignore_sticky_posts'	=> 1,
                                			'posts_per_page' 		=> 4,
                                			'meta_query' 			=> $meta_query,
                                            'suppress_filter'       => true,
                                            'tax_query'             => array(
                                                array(
                                                    'taxonomy' => 'product_brand',
                                                    'field'    => 'id',
                                                    'terms'    => $term->term_id,
                                                    'operator' => 'IN'
                                                ),
                                            )
                                		);
                                        $products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );
                                        if( $products->have_posts() ):
                                        ?>
                                        <div class="row">
                                            <div class="col-xs-12 col-sm-4 trademark-info">
                                                <?php if($image): ?>
                                                <div class="trademark-logo">
                                                    <a href="<?php echo esc_url( $term_link ); ?>">
                                                        <?php echo apply_filters( 'kt_brand_image_' . $term->slug, $image ) ?>
                                                    </a>
                                                </div>
                                                <?php endif;?>
                                                <div class="trademark-desc">
                                                    <?php echo esc_html( $term->description ) ?>
                                                </div>
                                                <a href="<?php echo esc_url( $term_link ); ?>" class="trademark-link"><?php _e( 'shop this brand', 'kutetheme' ) ?></a>
                                            </div>
                                            <div class="col-xs-12 col-sm-8 trademark-product">
                                                <div class="row">
                                                    <?php while($products->have_posts()): $products->the_post(); 
                                                        $link = get_the_permalink();
                                                    ?>
                                                    <div class="col-xs-12 col-sm-6 product-item">
                                                        <div class="image-product hover-zoom">
                                                            <a href="<?php echo esc_url( $link ); ?>">
                                                                <?php
                                                        			/**
                                                        			 * kt_loop_product_thumbnail hook
                                                        			 *
                                                        			 * @hooked woocommerce_template_loop_product_thumbnail - 10
                                                        			 */
                                                        			echo woocommerce_get_product_thumbnail();
                                                        		?>
                                                            </a>
                                                        </div>
                                                        <div class="info-product">
                                                            <a href="<?php echo esc_url( $link ); ?>">
                                                                <h5><?php echo esc_html( get_the_title() ); ?></h5>
                                                            </a>
                                                            <div class="content_price">
                                                                <?php
                                                        			/**
                                                        			 * woocommerce_after_shop_loop_item_title hook
                                                        			 * @hooked woocommerce_template_loop_price - 5
                                                        			 * @hooked woocommerce_template_loop_rating - 10
                                                        			 */
                                                        			do_action( 'kt_after_shop_loop_item_title' );
                                                        		?>
                                                            </div>
                                                            <a class="btn-view-more" title="<?php _e( 'View More', 'kutetheme' ) ?>" href="<?php echo esc_url( $link ); ?>"><?php _e( 'View More', 'kutetheme' ) ?></a>
                                                        </div>
                                                    </div>
                                                    <?php endwhile; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        <?php wp_reset_query(); ?>
                                        <?php wp_reset_postdata(); ?>
                                    </div>
                                <?php $i ++ ; ?>
                                <?php endforeach; ?>
                                <?php //remove_filter( 'kt_template_loop_product_thumbnail_size', array( $this, 'kt_thumbnail_size' ) ); ?>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <?php if( $line_brand == '2-line' ): ?>
                        <div class="option7">
                            <!-- ./blog list -->
                            <div class="row-brand <?php echo esc_attr( $elementClass ); ?>">
                                <?php if( $title ): ?>
                                    <h2 class="page-heading">
                                        <span class="page-heading-title"><?php echo esc_html( $title ) ; ?></span>
                                    </h2>
                                <?php endif; ?>
                                <ul class="band-logo no-product owl-carousel" <?php echo _data_carousel($data_carousel); ?>>
                                    <?php for($i = 0; $i < count( $terms ); $i += 2 ): ?>
                                        <?php if( isset( $terms[ $i ] ) && $terms[ $i ] ): ?>
                                            <?php $term = $terms[ $i ]; ?>
                                            <li>
                                                <h3><?php echo esc_html( $term->name ); ?></h3>
                                                <?php if( isset( $terms[$i + 1] ) && $terms[$i + 1] ): ?>
                                                    <?php $term_2 = $terms[$i + 1]; ?>
                                                    <h3><?php echo esc_html( $term_2->name ); ?></h3>
                                                <?php endif; ?>
                                            </li>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </ul>
                            </div>
                            <!-- ./blog list -->
                        </div>
                    <?php elseif( $line_brand =='show-logo'):?>
                        <div class="block-manufacturer-logo <?php echo esc_attr( $elementClass ); ?>">
                            <ul class="owl-carousel" <?php echo _data_carousel($data_carousel); ?>>
                                <?php foreach($terms as $term): ?>
                                    <?php
                                    $thumbnail_id = absint( get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true ) );
    
                                    if ( $thumbnail_id ) {
                                      $image = wp_get_attachment_image( intval( $thumbnail_id ), 'full' );
                                    } else {
                                        $image = "";
                                    }
                                    ?>
                                    <?php if($image):?>
                                    <li><a href="<?php echo get_term_link( $term); ?> "><?php echo $image;?></a></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php elseif( $line_brand=="show-logo2"):?>
                        <div class="block-brands <?php echo esc_attr( $elementClass ); ?>">
                            <ul class="owl-carousel" <?php echo _data_carousel($data_carousel); ?>>
                                <?php foreach($terms as $term): ?>
                                    <?php
                                    $thumbnail_id = absint( get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true ) );
    
                                    if ( $thumbnail_id ) {
                                      $image = wp_get_attachment_image( intval( $thumbnail_id ), 'full' );
                                    } else {
                                        $image = "";
                                    }
                                    ?>
                                    <?php if($image):?>
                                    <li><a href="<?php echo get_term_link( $term); ?> "><?php echo $image;?></a></li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php else: ?>
                        <div class="<?php echo esc_attr( $elementClass ); ?> band-logo no-product owl-carousel" <?php echo _data_carousel($data_carousel); ?>>
                            <?php foreach($terms as $term): ?>
                                <h3><?php echo esc_html( $term->name ); ?></h3>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    <?php
                endif;
            endif;
        endif;
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }
}