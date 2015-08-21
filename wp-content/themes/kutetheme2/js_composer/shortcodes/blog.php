<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

vc_map( array(
     "name" => __( "Blogs", THEME_LANG),
     "base" => "blog_carousel",
     "category" => __('Kute Theme', THEME_LANG ),
     "description" => __( "Display blog by carousel", THEME_LANG),
     "params" => array(
        array(
            "type" => "textfield",
            "heading" => __( "Title", THEME_LANG ),
            "param_name" => "title",
            "admin_label" => true,
        ),
        array(
            "type" => "textfield",
            "heading" => __( "Number Post", THEME_LANG ),
            "param_name" => "per_page",
            'std' => 10,
            "admin_label" => false,
            'description' => __( 'Number post in a slide', THEME_LANG )
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
        	"description" => __("Designates the ascending or descending order.",THEME_LANG)
        ),
        // Carousel
        array(
			'type' => 'checkbox',
			'heading' => __( 'AutoPlay', THEME_LANG ),
			'param_name' => 'autoplay',
			'value' => array( __( 'Yes, please', THEME_LANG ) => 'true' ),
            'group' => __( 'Carousel settings', THEME_LANG ),
            'admin_label' => false
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
			"value" => "250",
            "suffix" => __("milliseconds", THEME_LANG),
			"description" => __('Slide speed in milliseconds', THEME_LANG),
            'group' => __( 'Carousel settings', THEME_LANG ),
            'admin_label' => false,
	  	),
        array(
			"type" => "kt_number",
			"heading" => __("Margin", THEME_LANG),
			"param_name" => "margin",
			"value" => "0",
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
			"value" => "4",
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
        
    )
));


class WPBakeryShortCode_Blog_Carousel extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'blog_carousel', $atts ) : $atts;
        extract( shortcode_atts( array(
            'title'      => 'From the blog',
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
                                <span class="date"><?php the_date();?></span>
                                <span class="comment">
                                    <?php comments_number(
                                        __('0 Comment', THEME_LANG),
                                        __('1 Comment', THEME_LANG),
                                        __('% Comments', THEME_LANG)
                                    ); ?>
                                </span>
                            </div>
                            <div class="readmore">
                                <a target="_blank" href="<?php the_permalink() ?>"><?php _e( 'Readmore', THEME_LANG ) ?></a>
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
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }
}
?>