<?php
/**
 * @author  AngelsIT
 * @package KUTE TOOLKIT
 * @version 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if( is_admin() ){
    require_once KUTETHEME_PLUGIN_PATH . '/js_composer/custom-fields.php';
}
$style_banner = array(
	__( 'Style 1', 'kutetheme' ) => 'style-1',
    __( 'Style 2', 'kutetheme' ) => 'style-2',
);


if ( kt_check_active_plugin( 'woocommerce/woocommerce.php' ) ) {
    require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/tab-category.php';
    require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/tab-product.php';
    require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/lastest_deals_sidebar.php';
    require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/categories.php';
    require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/lastest_deals.php';
    require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/list_product.php';
    require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/popular-cat.php';
    require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/hot-deal-tab.php';
    require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/hot-deal.php';
    require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/box_product.php';
    require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/featured_products.php';
    require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/products_sidebar.php';
    require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/category_carousel.php';
    
    $style_banner = array(
    	__( 'Style 1', 'kutetheme' ) => 'style-1',
        __( 'Style 2', 'kutetheme' ) => 'style-2',
        __( 'Style 3', 'kutetheme' ) => 'style-3',
    );

}


require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/service.php';
require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/brand.php';
require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/blog.php';
require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/adv_banner.php';
require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/look_books.php';
require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/colection.php';
require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/testimonial.php';
require_once KUTETHEME_PLUGIN_PATH . '/js_composer/shortcodes/banner-title.php';