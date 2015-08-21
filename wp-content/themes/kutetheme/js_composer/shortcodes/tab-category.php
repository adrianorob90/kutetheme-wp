<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

if( ! kt_is_wc() ) return;

vc_map( array(
    "name" => __( "Categories Tab", THEME_LANG),
    "base" => "categories_tab",
    "category" => __('Kute Theme', THEME_LANG ),
    "description" => __( "Show tab categories", THEME_LANG),
    "as_parent" => array('only' => 'tab_section'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
    "content_element" => true,
    "show_settings_on_create" => true,
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
            "type" => "textfield",
            "heading" => __( "Column", THEME_LANG ),
            "param_name" => "number_column",
            "admin_label" => false,
            'std' => 4,
            'description' => __( 'Number column display', THEME_LANG )
        ),
        array(
            "type" => "dropdown",
        	"heading" => __("Tabs Type", THEME_LANG),
        	"param_name" => "tabs_type",
            "admin_label" => true,
            'std' => 'tabs1',
            'value' => array(
        		__( 'Tab 1', THEME_LANG ) => 'tab-1',
                __( 'Tab 2', THEME_LANG ) => 'tab-2',
                __( 'Tab 3', THEME_LANG ) => 'tab-3',
                __( 'Tab 4', THEME_LANG ) => 'tab-4',
                __( 'Tab 5', THEME_LANG ) => 'tab-5',
                __( 'Tab 6', THEME_LANG ) => 'tab-6',
                __( 'Tab 7', THEME_LANG ) => 'tab-7',
        	),
        ),
        
        array(
            "type" => "kt_categories",
        	"heading" => __("Choose Category", THEME_LANG),
        	"param_name" => "category",
            "admin_label" => true,
        ),
        array(
            "type" => "colorpicker",
        	"heading" => __("Main Color", THEME_LANG),
        	"param_name" => "main_color",
            "admin_label" => true,
        ),
        
        array(
    		'type' => 'attach_image',
    		'heading' => __( 'Icon', THEME_LANG ),
    		'param_name' => 'icon',
            "dependency" => array("element" => "tabs_type","value" => array('tab-1', 'tab-2', 'tab-3', 'tab-4', 'tab-5')),
    		'description' => __( 'Setup icon for the tab', THEME_LANG )
    	),
        array(
    		'type' => 'attach_images',
    		'heading' => __( 'Banner top', THEME_LANG ),
    		'param_name' => 'banner_top',
            "dependency" => array("element" => "tabs_type","value" => array('tab-1')),
    		'description' => __( 'Setup image on  top of the tab', THEME_LANG )
    	),
        
        array(
    		'type' => 'attach_images',
    		'heading' => __( 'Banner left', THEME_LANG ),
    		'param_name' => 'banner_left',
            "dependency" => array("element" => "tabs_type","value" => array('tab-1', 'tab-2', 'tab-3', 'tab-4', 'tab-5')),
    		'description' => __( 'Setup image on  left of the tab', THEME_LANG )
    	),
        
        array(
    		'type' => 'checkbox',
    		'heading' => __( 'Featured', THEME_LANG ),
    		'param_name' => 'featured',
            "dependency" => array("element" => "tabs_type", "value" => array('tab-1')),
    		'description' => __( 'Setup image on  left of the tab', THEME_LANG ),
            'value' => array( __( 'Yes', THEME_LANG ) => 'yes' )
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
        
        // Carousel
        array(
			'type' => 'checkbox',
			'heading' => __( 'AutoPlay', THEME_LANG ),
			'param_name' => 'autoplay',
			'value' => array( __( 'Yes, please', THEME_LANG ) => 'true' ),
            'group' => __( 'Carousel settings', THEME_LANG ),
            'admin_label' => false,
            "dependency" => array("element" => "tabs_type","value" => array('tab-1')),
		),
        array(
			'type' => 'checkbox',
            'heading' => __( 'Navigation', THEME_LANG ),
			'param_name' => 'navigation',
			'value' => array( __( "Don't use Navigation", THEME_LANG ) => 'false' ),
            'description' => __( "Don't display 'next' and 'prev' buttons.", THEME_LANG ),
            'group' => __( 'Carousel settings', THEME_LANG ),
            'admin_label' => false,
            "dependency" => array("element" => "tabs_type","value" => array('tab-1')),
		),
        array(
			'type' => 'checkbox',
            'heading' => __( 'Loop', THEME_LANG ),
			'param_name' => 'loop',
			'value' => array( __( "Loop", THEME_LANG ) => 'false' ),
            'description' => __( "Inifnity loop. Duplicate last and first items to get loop illusion.", THEME_LANG ),
            'group' => __( 'Carousel settings', THEME_LANG ),
            'admin_label' => false,
            "dependency" => array("element" => "tabs_type","value" => array('tab-1')),
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
            "dependency" => array("element" => "tabs_type","value" => array('tab-1')),
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
            "dependency" => array("element" => "tabs_type","value" => array('tab-1')),
	  	),
        array(
			'type' => 'checkbox',
            'heading' => __( 'Don\'t Use Carousel Responsive', THEME_LANG ),
			'param_name' => 'use_responsive',
			'value' => array( __( "Don't use Responsive", THEME_LANG ) => 'false' ),
            'description' => __( "Try changing your browser width to see what happens with Items and Navigations", THEME_LANG ),
            'group' => __( 'Carousel responsive', THEME_LANG ),
            'admin_label' => false,
            "dependency" => array("element" => "tabs_type","value" => array('tab-1')),
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
            "dependency" => array("element" => "tabs_type","value" => array('tab-1')),
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
            "dependency" => array("element" => "tabs_type","value" => array('tab-1')),
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
            "dependency" => array("element" => "tabs_type","value" => array('tab-1')),
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
    "js_view" => 'VcColumnView'
));
vc_map( array(
    "name" => __("Section Tab", THEME_LANG),
    "base" => "tab_section",
    "content_element" => true,
    "as_child" => array('only' => 'categories_tab'), // Use only|except attributes to limit parent (separate multiple values with comma)
    "params" => array(
        // add params same as with any other content element
        array(
            "type" => "textfield",
            "heading" => __( "Header", THEME_LANG ),
            "param_name" => "header",
            "admin_label" => true,
        ),
        array(
            "type" => "dropdown",
        	"heading" => __("Section Type", THEME_LANG),
        	"param_name" => "section_type",
            "admin_label" => true,
            'std' => 'best-seller',
            'value' => array(
        		__( 'Best Sellers', THEME_LANG ) => 'best-seller',
                __( 'Most Reviews', THEME_LANG ) => 'most-review',
                __( 'New Arrivals', THEME_LANG ) => 'new-arrival',
                __( 'On Sales', THEME_LANG )     => 'on-sales',
                __( 'Category', THEME_LANG )     => 'category',
                __( 'Custom', THEME_LANG )     => 'custom'
        	),
        ),
        
        array(
            "type" => "kt_categories",
        	"heading" => __("Choose Category", THEME_LANG),
        	"param_name" => "section_cate",
            "admin_label" => false,
            "dependency" => array("element" => "section_type", "value" => array('category')),
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
                __('Sale Price', THEME_LANG) => '_sale_price'
        	),
            'std' => 'date',
        	"description" => __("Select how to sort retrieved posts.",THEME_LANG),
            "dependency"  => array("element" => "section_type", "value" => array('custom', 'on-sales', 'category')),
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
            "dependency" => array("element" => "section_type", "value" => array('custom', 'on-sales', 'category')),
        ),
        array(
            "type" => "textfield",
            "heading" => __( "Extra class name", "js_composer" ),
            "param_name" => "el_class",
            "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
            'admin_label' => false,
        ),
    )
) );
class WPBakeryShortCode_Categories_Tab extends WPBakeryShortCodesContainer {
    protected function content($atts, $content = null) {
        $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'categories_tab', $atts ) : $atts;
        extract( shortcode_atts( array(
            'title'      => 'Tabs Name',
            'tabs_type'  => 'tab-1',
            'per_page'   => 10,
            'column'     => 4,
            'category'   => 0,
            'main_color' => '#ff3366',
            'icon'       => '',
            'banner_top' => '',
            'banner_left'=> '',
            "featured"   => false,
            
            
            //Carousel            
            'autoplay' => 'false', 
            'navigation' => 'false',
            'margin'    => 0,
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
        	'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'container box-tab-category ', $this->settings['base'], $atts ),
        	'extra' => $this->getExtraClass( $el_class ),
        	'css_animation' => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
        );
        
        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        if( function_exists( 'kt_hex2rgb' )){
            $main_color_rgb = kt_hex2rgb($main_color);
        }else{
            $main_color_rgb = array( 'red' => 255, 'green' => 51, 'blue' => 102 );
        }
        
        $elementClass = apply_filters( 'kt_category_tab_class_container', $elementClass );
        
        
        $tabs = kt_get_all_attributes( 'tab_section', $content );
        
        $id = uniqid($category);
        
        $term = get_term( $category, 'product_cat' );
        
        if( count( $tabs ) >0 && $term ):
            $term_link = get_term_link($term);
            $args = array(
               'hierarchical' => 1,
               'show_option_none' => '',
               'hide_empty' => 0,
               'parent' => $term->term_id,
               'taxonomy' => 'product_cat'
            );
            $subcats = get_categories($args);
            
            if( file_exists( THEME_DIR.'js_composer/includes/'.$tabs_type.'.php' ) ){
                if( $tabs_type == 'tab-1' ){
                    $elementClass .= ' option1 tab-1';
                }elseif( $tabs_type == 'tab-2' ){
                    $elementClass .= ' option2 tab-2';
                }elseif( $tabs_type == 'tab-3' ){
                    $elementClass .= ' option2 tab-3';
                }elseif( $tabs_type == 'tab-4' ){
                    $elementClass .= ' option2 tab-4';
                }elseif( $tabs_type == 'tab-5' ){
                    $elementClass .= ' option2 tab-5';
                }elseif( $tabs_type == 'tab-6' ){
                    $elementClass .= ' option6 tab-6';
                }elseif( $tabs_type == 'tab-7' ){
                    $elementClass .= ' option7 tab-7';
                }
                @include( locate_template( 'js_composer/includes/'.$tabs_type.'.php' ) );
            }
        endif;
    }
    /**
     * order_by_rating_post_clauses function.
     *
     * @access public
     * @param array $args
     * @return array
     */
    public function order_by_rating_post_clauses( $args ) {
    	global $wpdb;
    
    	$args['fields'] .= ", AVG( $wpdb->commentmeta.meta_value ) as average_rating ";
    
    	$args['where'] .= " AND ( $wpdb->commentmeta.meta_key = 'rating' OR $wpdb->commentmeta.meta_key IS null ) ";
    
    	$args['join'] .= "
    		LEFT OUTER JOIN $wpdb->comments ON($wpdb->posts.ID = $wpdb->comments.comment_post_ID)
    		LEFT JOIN $wpdb->commentmeta ON($wpdb->comments.comment_ID = $wpdb->commentmeta.comment_id)
    	";
    
    	$args['orderby'] = "average_rating DESC, $wpdb->posts.post_date DESC";
    
    	$args['groupby'] = "$wpdb->posts.ID";
    
    	return $args;
    }
    public function kt_thumbnail_size173x211(){
        return '173x211';
    }
    public function kt_thumbnail_size_131x160(){
        return '131x160';
    }
    public function kt_thumbnail_size175x214(){
        return '175x214';
    }
}