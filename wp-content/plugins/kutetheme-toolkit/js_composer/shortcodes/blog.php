<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

vc_map( array(
     "name" => __( "Blogs", 'kutetheme'),
     "base" => "blog_carousel",
     "category" => __('Kute Theme', 'kutetheme' ),
     "description" => __( "Display blog by carousel", 'kutetheme'),
     "params" => array(
        array(
            "type" => "textfield",
            "heading" => __( "Title", 'kutetheme' ),
            "param_name" => "title",
            "admin_label" => true,
        ),
        array(
            "type" => "textfield",
            "heading" => __( "Number Post", 'kutetheme' ),
            "param_name" => "per_page",
            'std' => 10,
            "admin_label" => false,
            'description' => __( 'Number post in a slide', 'kutetheme' )
        ),
        array(
            "type" => "dropdown",
        	"heading" => __("Order by", 'kutetheme'),
        	"param_name" => "orderby",
        	"value" => array(
        		__('None', 'kutetheme')     => 'none',
                __('ID', 'kutetheme')       => 'ID',
                __('Author', 'kutetheme')   => 'author',
                __('Name', 'kutetheme')     => 'name',
                __('Date', 'kutetheme')     => 'date',
                __('Modified', 'kutetheme') => 'modified',
                __('Rand', 'kutetheme')     => 'rand',
        	),
            'std' => 'date',
        	"description" => __("Select how to sort retrieved posts.",'kutetheme'),
        ),
        array(
            "type" => "dropdown",
        	"heading" => __("Order", 'kutetheme'),
        	"param_name" => "order",
        	"value" => array(
                __('ASC', 'kutetheme') => 'ASC',
                __('DESC', 'kutetheme') => 'DESC'
        	),
            'std' => 'DESC',
        	"description" => __("Designates the ascending or descending order.",'kutetheme')
        ),
        // Carousel
        array(
			'type' => 'checkbox',
			'heading' => __( 'AutoPlay', 'kutetheme' ),
			'param_name' => 'autoplay',
			'value' => array( __( 'Yes, please', 'kutetheme' ) => 'true' ),
            'group' => __( 'Carousel settings', 'kutetheme' ),
            'admin_label' => false
		),
        array(
			'type' => 'checkbox',
            'heading' => __( 'Navigation', 'kutetheme' ),
			'param_name' => 'navigation',
			'value' => array( __( "Don't use Navigation", 'kutetheme' ) => 'false' ),
            'description' => __( "Don't display 'next' and 'prev' buttons.", 'kutetheme' ),
            'group' => __( 'Carousel settings', 'kutetheme' ),
            'admin_label' => false,
		),
        array(
			'type' => 'checkbox',
            'heading' => __( 'Loop', 'kutetheme' ),
			'param_name' => 'loop',
			'value' => array( __( "Loop", 'kutetheme' ) => 'false' ),
            'description' => __( "Inifnity loop. Duplicate last and first items to get loop illusion.", 'kutetheme' ),
            'group' => __( 'Carousel settings', 'kutetheme' ),
            'admin_label' => false,
		),
        array(
			"type" => "kt_number",
			"heading" => __("Slide Speed", 'kutetheme'),
			"param_name" => "slidespeed",
			"value" => "250",
            "suffix" => __("milliseconds", 'kutetheme'),
			"description" => __('Slide speed in milliseconds', 'kutetheme'),
            'group' => __( 'Carousel settings', 'kutetheme' ),
            'admin_label' => false,
	  	),
        array(
			"type" => "kt_number",
			"heading" => __("Margin", 'kutetheme'),
			"param_name" => "margin",
			"value" => "0",
            "suffix" => __("px", 'kutetheme'),
			"description" => __('Distance( or space) between 2 item', 'kutetheme'),
            'group' => __( 'Carousel settings', 'kutetheme' ),
            'admin_label' => false,
	  	),
        array(
			'type' => 'checkbox',
            'heading' => __( 'Don\'t Use Carousel Responsive', 'kutetheme' ),
			'param_name' => 'use_responsive',
			'value' => array( __( "Don't use Responsive", 'kutetheme' ) => 'false' ),
            'description' => __( "Try changing your browser width to see what happens with Items and Navigations", 'kutetheme' ),
            'group' => __( 'Carousel responsive', 'kutetheme' ),
            'admin_label' => false,
		),
        array(
			"type" => "kt_number",
			"heading" => __("The items on destop (Screen resolution of device >= 992px )", 'kutetheme'),
			"param_name" => "items_destop",
			"value" => "4",
            "suffix" => __("item", 'kutetheme'),
			"description" => __('The number of items on destop', 'kutetheme'),
            'group' => __( 'Carousel responsive', 'kutetheme' ),
            'admin_label' => false,
	  	),
        array(
			"type" => "kt_number",
			"heading" => __("The items on tablet (Screen resolution of device >=768px and < 992px )", 'kutetheme'),
			"param_name" => "items_tablet",
			"value" => "2",
            "suffix" => __("item", 'kutetheme'),
			"description" => __('The number of items on destop', 'kutetheme'),
            'group' => __( 'Carousel responsive', 'kutetheme' ),
            'admin_label' => false,
	  	),
        array(
			"type" => "kt_number",
			"heading" => __("The items on mobile (Screen resolution of device < 768px)", 'kutetheme'),
			"param_name" => "items_mobile",
			"value" => "1",
            "suffix" => __("item", 'kutetheme'),
			"description" => __('The numbers of item on destop', 'kutetheme'),
            'group' => __( 'Carousel responsive', 'kutetheme' ),
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
        
    )
));

class WPBakeryShortCode_Blog_Carousel extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'blog_carousel', $atts ) : $atts;
        extract( shortcode_atts( array(
            'title'      => __( 'From the blog', 'kutetheme' ),
            'per_page'   => 10,
            'orderby'    => 'date',
            'order'      => 'desc',
            
            //Carousel            
            'autoplay' => 'false', 
            'navigation' => 'false',
            'margin'    => 30,
            'slidespeed' => 250,
            'css' => '',
            'css_animation' => '',
            'el_class' => '',
            'nav' => 'true',
            'loop'  => 'true',
            //Default
            'use_responsive' => 0,
            'items_destop' => 4,
            'items_tablet' => 2,
            'items_mobile' => 1,
        ), $atts ) );
        
         global $woocommerce_loop;
        
        $elementClass = array(
        	'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'blog-list ', $this->settings['base'], $atts ),
        	'extra' => $this->getExtraClass( $el_class ),
        	'css_animation' => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
        );
        
        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        
        $data_carousel = array(
            "autoplay"   => $autoplay,
            "navigation" => $navigation,
            "margin"     => $margin,
            "slidespeed" => $slidespeed,
            "theme"      => 'style-navigation-bottom',
            "autoheight" => 'false',
            'nav'        => 'true',
            'dots'       => 'false',
            'loop'       => 'false',
            'autoplayTimeout'    => 1000,
            'autoplayHoverPause' => 'true'
        );
        
        if( ! $use_responsive){
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
            $data_carousel['items'] = 4;
        }
        $args = array(
			'post_type'				=> 'post',
			'post_status'			=> 'publish',
			'ignore_sticky_posts'	=> 1,
			'posts_per_page' 		=> $per_page,
            'suppress_filter'       => true,
            'orderby'               => $orderby,
            'order'                 => $order
		);
        $posts = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );
        
        ob_start();
        if( $posts->have_posts() ):                    
        ?>
        <!-- blog list -->
        <div class="<?php echo $elementClass; ?>">
            <h2 class="page-heading">
                <span class="page-heading-title"><?php echo esc_html( $title ) ?></span>
            </h2>
            <div class="blog-list-wapper">
                <ul class="owl-carousel" <?php echo _data_carousel($data_carousel); ?>>
                    <?php while( $posts->have_posts() ): $posts->the_post(); ?>
                    <li>
                        <div class="post-thumb image-hover2">
                            <a target="_blank" href="<?php the_permalink() ?>"><?php the_post_thumbnail('268x255') ?></a>
                        </div>
                        <div class="post-desc">
                            <h5 class="post-title">
                                <a target="_blank" href="<?php the_permalink() ?>"><?php the_title() ?></a>
                            </h5>
                            <div class="post-meta">
                                <span class="date"><?php echo get_the_date('F j, Y');?></span>
                                <span class="comment">
                                    <?php comments_number(
                                        __('0 Comment', 'kutetheme'),
                                        __('1 Comment', 'kutetheme'),
                                        __('% Comments', 'kutetheme')
                                    ); ?>
                                </span>
                            </div>
                            <div class="readmore">
                                <a target="_blank" href="<?php the_permalink() ?>"><?php _e( 'Readmore', 'kutetheme' ) ?></a>
                            </div>
                        </div>
                    </li>
                    <?php endwhile; ?>
                </ul>
            </div>
        </div>
        <!-- ./blog list -->
        <?php
        endif;
        $result = ob_get_clean();
        wp_reset_query();
        wp_reset_postdata();
        return $result;
    }
}