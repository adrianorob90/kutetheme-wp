<?php
// Exit if accessed directly
if ( !defined('ABSPATH')) exit;

if( class_exists( 'WPBakeryShortCode' ) ){
    // Setting shortcode service
    vc_map( array(
        "name" => __( "Categories", THEME_LANG),
        "base" => "categories",
        "category" => __('Kute Theme', THEME_LANG ),
        "description" => __( "Display box categories same hot categories in option 1", THEME_LANG),
        "params" => array(
            array(
                "type" => "textfield",
                "heading" => __( "Title", THEME_LANG ),
                "param_name" => "title",
                "admin_label" => true,
                'description' => __( 'Display title box categories', THEME_LANG )
            ),array(
                "type" => "kt_taxonomy",
                "taxonomy" => "product_cat",
                "class" => "",
                "heading" => __("Category", THEME_LANG),
                "param_name" => "taxonomy",
                "value" => '',
                'parent' => 0,
                'multiple' => true,
                'placeholder' => _('Choose categoy'),
                "description" => __("Note: By default, all your catrgory will be displayed. <br>If you want to narrow output, select category(s) above. Only selected categories will be displayed. if nothing selected will show all of categories.", THEME_LANG)
            ),
            array(
                "type" => "kt_number",
                "heading" => __( "Number", THEME_LANG ),
                "param_name" => "number",
                "value" => "3",
                "admin_label" => true,
                'description' => __( 'The `number` field is used to display the number of subcategory.', THEME_LANG )
            ),array(
    			'type' => 'dropdown',
    			'heading' => __( 'Order by', 'js_composer' ),
    			'param_name' => 'orderby',
    			'value' => array(
                    __( 'Random', THEME_LANG )  => 'rand',
    				__( 'Date', THEME_LANG )    => 'date',
    				__( 'ID', THEME_LANG )      => 'id',
                    __( 'Author', THEME_LANG )  => 'author',
                    __( 'Title', THEME_LANG )   => 'title',
    			)
    		),
            array(
    			'type' => 'dropdown',
    			'heading' => __( 'Order Way', 'js_composer' ),
    			'param_name' => 'order',
    			'value' => array(
    				__( 'Descending', 'js_composer' ) => 'desc',
    				__( 'Ascending', 'js_composer' ) => 'asc'
    			)
    		),
            
            array(
    			'type' => 'dropdown',
    			'heading' => __( 'Hide Empty', 'js_composer' ),
    			'param_name' => 'hide',
    			'value' => array(
    				__( 'Yes', 'js_composer' ) => '0',
    				__( 'No', 'js_composer' ) => '1'
    			)
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
                "type" => "textfield",
                "heading" => __( "Extra class name", THEME_LANG ),
                "param_name" => "el_class",
                "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
            ),array(
    			'type' => 'css_editor',
    			'heading' => __( 'Css', 'js_composer' ),
    			'param_name' => 'css',
    			// 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),
    			'group' => __( 'Design options', 'js_composer' )
    		),
        )
    ));
}
class WPBakeryShortCode_Categories extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        $tab = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'categories', $atts ) : $atts;
                        
        $atts = shortcode_atts( array(
            'title' => 'Hot Categories',
            'taxonomy' => '',
            'number' => 3,
            'orderby' => 'date',
            'order' => 'desc',
            'hide' => 0,
            
            'items_destop' => 4,
            'items_tablet' => 2,
            'items_mobile' => 1,
            
            'css_animation' => '',
            'el_class' => '',
            'css' => '',
            
        ), $atts );
        extract($atts);
        
        $elementClass = array(
        	'base' => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'hot-categories row', $this->settings['base'], $atts ),
        	'extra' => $this->getExtraClass( $el_class ),
        	'css_animation' => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
        );
        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );
        
        ob_start();
        
        if($taxonomy){
            $ids = explode( ',',$taxonomy );
        }else{
            $ids = array();
        }
        $classes = 'col-xs-'.( 12 / $items_mobile ). ' col-sm-'. ( 12 / $items_tablet ). ' col-md-'.( 12 / $items_destop );
        // get terms and workaround WP bug with parents/pad counts
		$args = array(
			'orderby'    => 'id',
			'order'      => 'desc',
			'hide_empty' => 0,
            'include'    => $ids,
			'pad_counts' => true,
		);
        $product_categories = get_terms( 'product_cat', $args );
        
        $arg_child = array(
			'orderby'    => $orderby,
			'order'      => $order,
			'hide_empty' => 0,
			'pad_counts' => true,
            'number'     => $number
		);
        
        ?>
        <div id="hot-categories" class="<?php echo $elementClass; ?>">
            <div class="col-sm-12 group-title-box">
                <h2 class="group-title ">
                    <span><?php echo $title; ?></span>
                </h2>
            </div>
            <?php if( $product_categories ): ?>
                <?php foreach($product_categories as $term): 
                
                    $arg_child['parent'] = $term->term_id;
                    
                    $term_link = esc_attr(get_term_link( $term ) );
                    
                    $thumbnail_id = absint( get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true ) );

            		if ( $thumbnail_id ) {
            			$image = wp_get_attachment_image_src( $thumbnail_id, 'full' );
                        if( is_array($image) && isset($image[0]) && $image[0] ){
                            $image = $image[0];
                        }else{
                            $image = wc_placeholder_img_src();
                        }
            		} else {
            			$image = wc_placeholder_img_src();
            		}
                    $children = get_terms( 'product_cat', $arg_child );
                ?>
                    <div class="<?php echo esc_attr($classes) ?> cate-box">
                        <div class="cate-tit" >
                            <div class="div-1" style="width: 46%;">
                                <div class="cate-name-wrap">
                                    <p class="cate-name"><?php echo esc_attr($term->name) ?></p>
                                </div>
                                <a href="<?php echo $term_link; ?>" class="cate-link link-active" data-ac="flipInX" ><span><?php _e('shop now', THEME_LANG) ?></span></a>
                            </div>
                            <div class="div-2" >
                                <a href="<?php echo $term_link; ?>">
                                    <img src="<?php echo esc_attr($image) ?>" alt="<?php echo esc_attr($term->name) ?>" class="hot-cate-img" />
                                </a>
                            </div>
                            
                        </div>
                        <?php if( count( $children ) >0 ): ?>
                        <div class="cate-content">
                            <ul>
                                <?php foreach($children as $child): ?>
                                    <?php $chil_link = esc_attr(get_term_link( $child ) ); ?>
                                    <li><a href="<?php echo esc_attr($chil_link) ?>"><?php echo $child->name ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div> <!-- /.cate-box -->
                <?php endforeach; ?>
            <?php endif; ?>                                                    
        </div> <!-- /#hot-categories -->
        <?php
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }
    public function kt_thumbnail_size(){
        return '';
    }
}