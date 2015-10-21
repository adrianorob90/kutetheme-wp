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
    "name"        => __( "Kute Featured Products", 'kutetheme'),
    "base"        => "kt_featured_products",
    "category"    => __('Kute Theme', 'kutetheme' ),
    "description" => __( "Display Featured Products", 'kutetheme'),
    "params"      => array(
        array(
            "type"        => "textfield",
            "heading"     => __( "Title", 'kutetheme' ),
            "param_name"  => "title",
            "admin_label" => true,
            'description' => __( 'Display title box featured', 'kutetheme' )
        )
        ,
        array(
            "type"        => "dropdown",
            "heading"     => __("Box Type", 'kutetheme'),
            "param_name"  => "box_type",
            "admin_label" => true,
            'std'         => 'featured',
            'value'       => array(
                __( 'Featured', 'kutetheme' ) => 'featured',
                __( 'By IDs', 'kutetheme' ) => 'by_id',
            ),
        ),
        array(
            "type"        => "textfield",
            "heading"     => __( "IDs", 'kutetheme' ),
            "param_name"  => "ids",
            "admin_label" => false,
            'description' => __( 'Enter your product ID and separate by a commas ",". Ex: 1,2,3...', 'kutetheme' ),
            "dependency"  => array("element" => "box_type","value" => array('by_id'))
        ),
        array(
            "type"        => "kt_number",
            "heading"     => __( "Number", 'kutetheme' ),
            "param_name"  => "number",
            "value"       => "4",
            "admin_label" => true,
            'description' => __( 'The number of products put out from your store.', 'kutetheme' ),
            "dependency"  => array("element" => "box_type","value" => array('featured'))
        ),
        array(
            "type"        => "textfield",
            "heading"     => __( "Extra class name", 'kutetheme' ),
            "param_name"  => "el_class",
            "description" => __( "If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer" ),
        ),array(
            'type'           => 'css_editor',
            'heading'        => __( 'Css', 'js_composer' ),
            'param_name'     => 'css',
            // 'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'js_composer' ),

            'group'          => __( 'Design options', 'js_composer' )
        ),
    )
));

class WPBakeryShortCode_Kt_Featured_Products extends WPBakeryShortCode {
    protected function content($atts, $content = null) {
        $atts = function_exists( 'vc_map_get_attributes' ) ? vc_map_get_attributes( 'kt_featured_products', $atts ) : $atts;
                        
        $atts = shortcode_atts( array(
            'title'         => __('Hot Categories', 'kutetheme'),
            'box_type'      => 'featured',
            'ids'           =>'',
            'number'        => 4,
            'css_animation' => '',
            'el_class'      => '',
            'css'           => '',
            
        ), $atts );
        extract($atts);
        
        $elementClass = array(
            'base'             => apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, ' trending ', $this->settings['base'], $atts ),
            'extra'            => $this->getExtraClass( $el_class ),
            'css_animation'    => $this->getCSSAnimation( $css_animation ),
            'shortcode_custom' => vc_shortcode_custom_css_class( $css, ' ' )
        );
        $elementClass = preg_replace( array( '/\s+/', '/^\s|\s$/' ), array( ' ', '' ), implode( ' ', $elementClass ) );

        ob_start();
        $args = array(  
            'post_type' => 'product',  
            'meta_key' => '_featured',  
            'meta_value' => 'yes',  
            'posts_per_page' => $number  
        );
        if($ids){
            $ids = explode(',', $ids);
        }else{
            $ids =array();
        }
        if( $box_type =='by_id'){
             $args = array(
                'post_type'=>'product',
                'post__in' => $ids
            );
        }
         
          
        $products = get_posts($args);
        $count = count( $products );
        $per_page = 2;
        $loop = false;
        if( $count >2 ) $loop = true;
        ?>
        <div class=" <?php echo esc_attr( $elementClass ); ?>">
            <?php if( $title): ?>
            <h2 class="trending-title"><?php echo esc_html( $title );?></h2>
            <?php endif; ?>
            <div class="trending-product owl-carousel nav-center" data-items="1" data-dots="false" data-nav="true" data-autoplay="true" <?php if($loop): ?> data-loop="true" <?php endif;?>>
                <?php 
                    $page = 1;
                    if( $count % $per_page == 0 ){
                        $page = $count / $per_page;
                    }else{
                        $page = $count / $per_page + 1;
                    }
                ?>
                <?php for( $i = 1; $i <= $page ; $i++ ): ?>
                    <ul>
                        <?php 
                        $from = ( $i - 1 ) * $per_page; 
                        $to   = $i * $per_page; 
                        for ($from ; $from < $to; $from ++) { 
                            if( isset($products[$from]) && $products[$from] ){
                                $p = $products[$from];
                                $product = new WC_Product(  $p->ID );
                                ?>
                                    <li>
                                        <div class="product-container">
                                            <div class="product-image">
                                                <a href="<?php echo get_permalink($p->ID); ?>">
                                                   <?php  echo get_the_post_thumbnail($p->ID,'shop_thumbnai'); ?>
                                                </a>
                                            </div>
                                            <div class="product-info">
                                                <h5 class="product-name">
                                                    <a href="<?php echo get_permalink($p->ID); ?>"><?php echo esc_html($p->post_title);?></a>
                                                </h5>
                                                <div class="product-price">
                                                    <?php echo $product->get_price_html(); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                <?php endfor;?>
            </div>
        </div>
        <?php
        $result = ob_get_contents();
        ob_end_clean();
        return $result;
    }
}