<?php
/**
 * Remove noties of wootheme update
 * */
if(is_admin())
    remove_action( 'admin_notices', 'woothemes_updater_notice' );

add_filter("woocommerce_product_get_rating_html", "kt_get_rating_html", 10, 2);

/**
 * Price Regular + Sale
 * */
add_action( "kt_after_loop_item_title", "woocommerce_template_loop_price", 5 );
/**
 * Sale price Percentage
 */

function woocommerce_custom_sales_price( $price, $product ) {
	$percentage = round( ( ( $product->regular_price - $product->sale_price ) / $product->regular_price ) * 100 );
	return $price . sprintf( __('<span class="colreduce-percentage">-%s <span class="colreduce-lable">%s</span></span>', THEME_LANG ), $percentage . '%', __( 'OFF', THEME_LANG ) );
}

/**
 * Change DOM html loop template price
 * */
if( ! function_exists("kt_get_price_html_from_to")){
    
    function kt_get_price_html_from_to($price, $from, $to, $product ){
        if($product->is_type( 'variable' )){
            // Main price
			$prices = array( $product->get_variation_price( 'min', true ), $product->get_variation_price( 'max', true ) );
            $multi_price = false;
            if($prices[0] !== $prices[1]){
                $multi_price = true;
            }
            $pr = $prices[0];
			// Sale
			$prices = array( $product->get_variation_regular_price( 'min', true ), $product->get_variation_regular_price( 'max', true ) );
            if($prices[0] !== $prices[1]){
                $multi_price = true;
            }
			$sale = $prices[1];
            $html_sale ='';
            if($multi_price){
                $html_sale .='~';
            }
            
            if($pr != $sale){
                $percentage = round( ( ( $sale - $pr  ) / $sale ) * 100 );
                $price .= sprintf( __('<span class="colreduce-percentage">-%s <span class="colreduce-lable">%s</span></span>', THEME_LANG ), $html_sale . $percentage . '%', __( 'OFF', THEME_LANG ) );
            }
        }
        return $price;
    }
}


function kt_get_rating_html($rating_html, $rating){
    $rating_html = '';
    global $product;
    if ( ! is_numeric( $rating ) ) {
        $rating = $product->get_average_rating();
    }
    $rating_html  = '<div class="product-star" title="' . sprintf( __( 'Rated %s out of 5', THEME_LANG ), $rating > 0 ? $rating : 0  ) . '">';
    for($i = 1;$i <= 5 ;$i++){
        if($rating >= $i){
            if( ( $rating - $i ) > 0 && ( $rating - $i ) < 1 ){
                $rating_html .= '<i class="fa fa-star-half-o"></i>';    
            }else{
                $rating_html .= '<i class="fa fa-star"></i>';
            }
        }else{
            $rating_html .= '<i class="fa fa-star-o"></i>';
        }
    }
    $rating_html .= '</div>';
    return $rating_html;
}

//content-product-tab.php
add_action('kt_loop_product_thumbnail', 'kt_template_loop_product_thumbnail', 10);

add_action('kt_after_shop_loop_item_title', 'woocommerce_template_loop_price', 5);

add_action('kt_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 10);

add_action( 'kt_loop_product_function' , 'kt_get_tool_wishlish', 1);

add_action( 'kt_loop_product_function' , 'kt_get_tool_compare', 5);

add_action( 'kt_loop_product_function' , 'kt_get_tool_quickview', 10);

add_action( 'kt_loop_product_label', 'kt_show_product_loop_new_flash', 5 );

add_action( 'kt_loop_product_label', 'woocommerce_show_product_loop_sale_flash', 10 );

if( ! function_exists('kt_get_tool_compare')){
    function kt_get_tool_compare(){
        if(defined( 'YITH_WOOCOMPARE' )){
            echo do_shortcode('[yith_compare_button]');
        }
    }
}
if( ! function_exists('kt_get_tool_wishlish') ){
    function kt_get_tool_wishlish(){
        if(class_exists('YITH_WCWL_UI')){
            echo do_shortcode('[yith_wcwl_add_to_wishlist]');    
        }
    }
}
if( ! function_exists('kt_get_tool_quickview') ){
    function kt_get_tool_quickview(){
        echo sprintf('<a title="%1$s" data-id="%2$s" class="search btn-quick-view" href="#"></a>', __('Quick view', THEME_LANG), get_the_ID() );
    }
}
if( ! function_exists( 'kt_template_loop_product_thumbnail' ) ){
    function kt_template_loop_product_thumbnail( $size = 'shop_catalog' ){
        $size = apply_filters( 'kt_template_loop_product_thumbnail_size' , $size );
        $size = $size ? $size : 'shop_catalog';
        echo woocommerce_get_product_thumbnail( $size );
    }
}

if ( ! function_exists( 'kt_show_product_loop_new_flash' ) ) {

	/**
	 * Get the sale flash for the loop.
	 *
	 * @subpackage	Loop
	 */
	function kt_show_product_loop_new_flash() {
		wc_get_template( 'loop/new-flash.php' );
	}
}

//Lastest Deal

add_action( 'woocommerce_datatime_sale_product', 'woocommerce_datatime_sale_product_variable' );

function woocommerce_datatime_sale_product_variable( $product = false, $post = false ){
    $product_id = 0;
    if(is_int( $product )){
        $product_id = $product;
    }elseif( is_object( $product ) ){
        $product_id = $product->id;
    }elseif( is_object( $post) ){
        $product_id = $post->ID;
    }else{
        global $post;
        $product_id =  $post->ID;
    }

    if( ! $product_id  ){
        return;
    }

    $cache_key = 'time_sale_price_'.$product_id;
    $cache = wp_cache_get($cache_key);
    if( $cache ){
        echo $cache;
        return;
    }
    // Get variations
    $args = array(
        'post_type'     => 'product_variation',
        'post_status'   => array( 'private', 'publish' ),
        'numberposts'   => -1,
        'orderby'       => 'menu_order',
        'order'         => 'asc',
        'post_parent'   => $product_id
    );
    $variations = get_posts( $args );
    $variation_ids = array();
    if( $variations ){
        foreach ( $variations as $variation ) {
            $variation_ids[]  = $variation->ID;
        }
    }
    $sale_price_dates_to = false;

    if( !empty(  $variation_ids )   ){
        global $wpdb;
        $sale_price_dates_to = $wpdb->get_var( "
            SELECT
            meta_value
            FROM $wpdb->postmeta
            WHERE meta_key = '_sale_price_dates_to' and post_id IN(".join(',',$variation_ids).")
            ORDER BY meta_value DESC
            LIMIT 1
        " );

        if( $sale_price_dates_to !='' ){
            $sale_price_dates_to = date('Y-m-d', $sale_price_dates_to);
        }
    }

    if( !$sale_price_dates_to ){
        $sale_price_dates_to 	= ( $date = get_post_meta( $product_id, '_sale_price_dates_to', true ) ) ? date_i18n( 'Y-m-d', $date ) : '';
    }

    if($sale_price_dates_to){
        $cache = 'data-countdown="'.$sale_price_dates_to.'" data-time="'.$sale_price_dates_to.'" data-strtotime="'.strtotime($sale_price_dates_to).'"';
        wp_cache_add( $cache_key, $cache );
        echo $cache;
    }else{
        wp_cache_delete( $cache_key );
    }
}

/**
 * Mini cart
 * */
add_action( 'kt_mini_cart', 'woocommerce_mini_cart' );

add_action( 'kt_mini_cart_content', 'kt_get_cart_content', 10, 1 );
// Ensure cart contents update when products are added to the cart via AJAX (place the following in functions.php)
//add_filter( 'add_to_cart_fragments', 'kt_header_add_to_cart_fragment', 1, 1 );

if( ! function_exists('kt_get_cart_content')){
    function kt_get_cart_content($check_out_url){
        if ( ! WC()->cart->is_empty() ) : ?>
            <div class="cart-block">
                <div class="cart-block-content">
                    <h5 class="cart-title"><?php _e( sprintf (_n( '%d item in my cart', '%d items in my cart', WC()->cart->cart_contents_count ), WC()->cart->cart_contents_count ), THEME_LANG ); ?></h5>
                    <div class="cart-block-list">
                        <ul>
                            <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ):
                                    $bag_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                                    $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
                                    
                                    if ( $bag_product &&  $bag_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ): 
                                    
                                    $product_name  = apply_filters( 'woocommerce_cart_item_name', $bag_product->get_title(), $cart_item, $cart_item_key );
                					$thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $bag_product->get_image('100x122'), $cart_item, $cart_item_key );
                					$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $bag_product ), $cart_item, $cart_item_key );
                                    ?>
                                        <li class="<?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item product-info', $cart_item, $cart_item_key ) ); ?>">
                                            <div class="p-left">
                                                <?php
                        						echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
                        							'<a href="%s" class="remove remove_link" title="%s" data-product_id="%s" data-product_sku="%s"></a>',
                        							esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
                        							__( 'Remove this item', 'woocommerce' ),
                        							esc_attr( $product_id ),
                        							esc_attr( $bag_product->get_sku() )
                        						), $cart_item_key );
                        						?>
                                                
                                                <a href="<?php echo get_permalink($cart_item['product_id']) ?>">
                                                    <?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ); ?>
                                                </a>
                                            </div>
                                            <div class="p-right">
                                                <p class="p-name"><?php echo $product_name; ?></p>
                                                <p class="p-rice"><?php echo $product_price ?></p>
                                                <?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<p class="quantity">' . sprintf( __('Qty: ', THEME_LANG).'%s', $cart_item['quantity'] ) . '</p>', $cart_item, $cart_item_key ); ?>
                                            </div>
                                        </li>
                                    <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="toal-cart">
                        <span><?php _e('Total', THEME_LANG) ?></span>
                        <span class="toal-price pull-right">
                            <?php echo WC()->cart->get_cart_total() ?>
                        </span>
                    </div>
                    <div class="cart-buttons">
                        <a href="<?php echo esc_url( $check_out_url ); ?>" class="btn-check-out"><?php echo _e( 'Checkout', THEME_LANG ); ?></a>
                    </div>
                </div>
            </div>
        <?php endif;
    }
}

add_filter( 'wc_add_to_cart_message', 'kt_add_to_cart_message', 10 );

function kt_add_to_cart_message(){
    global $woocommerce;
	// Output success messages
	if (get_option('woocommerce_cart_redirect_after_add')=='yes') :
		$return_to 	= get_permalink( woocommerce_get_page_id('shop') );
		$message 	= sprintf('<a href="%s" class="button">%s</a> %s', $return_to, __('Continue Shopping &rarr;', 'woocommerce'), __('Product successfully added to your cart.', 'woocommerce') );
	else :
		$message 	= sprintf('<a href="%s" class="button">%s</a> %s', get_permalink(woocommerce_get_page_id('cart')), __('View Cart &rarr;', 'woocommerce'), __('Product successfully added to your cart.', 'woocommerce') );
	endif;
		return $message;
}


add_action( 'kt_woocommerce_single_product', 'kt_woocommerce_single_product' );
function kt_woocommerce_single_product(){
    ?>
    <div class="product-detail-info">
        <div class="product-section">
            <?php
            woocommerce_template_single_meta();
            woocommerce_template_single_rating();
            woocommerce_template_single_excerpt();
            ?>
        </div>
        <div class="product-section">
            <?php
                woocommerce_template_single_add_to_cart();
            ?>
            <div class="group-product-price">
                <label><?php _e( 'Price', THEME_LANG );?></label>
                <?php woocommerce_template_single_price();?>
            </div>
        </div>
        <div class="product-section">
            <?php woocommerce_template_single_sharing();?>
        </div>
    </div>
    <?php
}

/***********************************
*AJAX
***********************************/
/**
 * Product Quick View callback AJAX request 
 *
 * @since 1.0
 * @return html
 */

function wp_ajax_frontend_product_quick_view_callback() {
    check_ajax_referer( 'screenReaderText', 'security' );
    
    global $product, $woocommerce, $post;

	$product_id = $_POST["product_id"];
	
	$post = get_post( $product_id );

	$product = wc_get_product( $product_id );
    
    // Call our template to display the product infos
    wc_get_template_part( 'content', 'quickview');
    
    die();
    
}
add_action( 'wp_ajax_frontend_product_quick_view', 'wp_ajax_frontend_product_quick_view_callback' );
add_action( 'wp_ajax_nopriv_frontend_product_quick_view', 'wp_ajax_frontend_product_quick_view_callback' );


/*
* Return a new number of maximum columns for shop archives
* @param int Original value
* @return int New number of columns
*/
function kt_loop_shop_columns( $number_columns ) {
    $kt_woo_grid_column = kt_option('kt_woo_grid_column','3');
    return $kt_woo_grid_column;
}
add_filter( 'loop_shop_columns', 'kt_loop_shop_columns', 1, 10 );

/**
* Custom category page
**/

//remove woocommerce resultcount
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

// add products display

if(!function_exists('kt_custom_display_view')){
    add_filter( 'woocommerce_before_shop_loop' , 'kt_custom_display_view' );
    function kt_custom_display_view(){
        $shop_products_layout = 'grid';
        if(isset($_SESSION['shop_products_layout'])){
            $shop_products_layout = $_SESSION['shop_products_layout'];
        }
        ?>
        <ul class="display-product-option">
            <li class="view-as-grid <?php if($shop_products_layout == "grid" ) echo esc_attr('selected');?>">
                <span><?php _e('grid',THEME_LANG);?></span>
            </li>
            <li class="view-as-list <?php if($shop_products_layout == "list" ) echo esc_attr('selected');?>">
                <span><?php _e('list', THEME_LANG );?></span>
            </li>
        </ul>
        <?php
    }
}
// kt_custom_class_list_product

if(!function_exists('kt_custom_class_list_product')){
    add_filter( 'kt_custom_class_list_product' , 'kt_custom_class_list_product' );
    function kt_custom_class_list_product(){
        // style view
        if(!is_singular( 'product' )){
            $shop_products_layout = 'grid';
            if(isset($_SESSION['shop_products_layout'])){
                $shop_products_layout = $_SESSION['shop_products_layout'];
            }
            echo $shop_products_layout;
        }
    }
}


/* Remove pagination on the bottom of shop page */
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );

/* Show pagination on the top of shop page */
add_action( 'woocommerce_after_shop_loop', 'kt_paging_nav', 10 );
add_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 11 );

/**
 * Custom  products per page
**/
add_filter( 'loop_shop_per_page','kt_custom_products_per_page', 20 );
function kt_custom_products_per_page(){
    $loop_shop_per_page = kt_option('kt_woo_products_perpage',18);
    // Display 24 products per page. Goes in functions.php
    return $loop_shop_per_page;
}


/*-----------------
Category slider
-----------------*/
if(!function_exists('kt_category_slider')){
    add_filter( 'kt_before_list_product','kt_category_slider', 1 );
    function kt_category_slider(){
        $cate = get_queried_object();
        $cateID = $cate->term_id;
        $category_slider = get_tax_meta($cateID,'kt_category_slider');
        if($category_slider){
            $list_image = explode('|', $category_slider['url']);
            if(count($list_image)>1){
                ?>
                <div class="category-slider">
                    <ul class="owl-carousel owl-style2" data-dots="false" data-loop="true" data-nav = "true" data-autoplay="true" data-items="1">
                        <?php 
                        foreach($list_image as $url){
                            ?>
                            <li>
                                <img src="<?php echo $url;?>" alt="category-slider">
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
                <?php
            }elseif (count($list_image)>0) {
                ?>
                <div class="category-slider">
                    <ul>
                        <?php 
                        foreach($list_image as $url){
                            ?>
                            <li>
                                <img src="<?php echo $url;?>" alt="category-slider">
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
                <?php
            }
        }
    }
}

/*-----------------
Sub category
-----------------*/

if(!function_exists('kt_display_sub_category')){
    add_filter( 'kt_before_list_product','kt_display_sub_category', 2 );
    function kt_display_sub_category(){
        global  $category;
        $cate = get_queried_object();
        $cateID = $cate->term_id;
        $cf = array(
            'hierarchical' => 1,
            'show_option_none' => '',
            'hide_empty' => 0,
            'parent' => $cateID,
            'taxonomy' => 'product_cat',
            'number'=>4
        );
        $subcats = get_categories($cf);
        if($subcats){

            ?>
            <div class="subcategories">
                <ul>
                    <li class="current-categorie">
                        <a href="#"><?php echo $cate->name;?></a>
                    </li>
                    <?php
                    foreach($subcats as $cat){
                        ?>
                        <li>
                            <a href="<?php echo get_term_link( $cat->slug, $cat->taxonomy );?>"><?php echo $cat->name; ?></a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <?php
        }
    }
}

/*----------------------
Product view style
----------------------*/
function  wp_ajax_fronted_set_products_view_style_callback(){
    check_ajax_referer( 'screenReaderText', 'security' );
    $style = $_POST['style'];
    $_SESSION['shop_products_layout'] = $style;
    die;
}
add_action( 'wp_ajax_fronted_set_products_view_style', 'wp_ajax_fronted_set_products_view_style_callback' );
add_action( 'wp_ajax_nopriv_fronted_set_products_view_style', 'wp_ajax_fronted_set_products_view_style_callback' );

/*------------------
Custom woocommerce_breadcrumb_defaults
-------------------*/

add_filter( 'woocommerce_breadcrumb_defaults', 'jk_change_breadcrumb_home_text' );
function jk_change_breadcrumb_home_text( $defaults ) {
    // Change the breadcrumb home text from 'Home' to 'Appartment'
    $defaults['delimiter'] = '<span class="navigation-pipe">&nbsp;</span>';
    return $defaults;
}
/*------------------
Custom woocommerce_page_title
-------------------*/
add_filter( 'woocommerce_page_title', 'custom_woocommerce_page_title');
function custom_woocommerce_page_title( $page_title ) {
  return  '<span>'.$page_title.'</span>';
}

// Product meta
remove_action('woocommerce_single_product_summary','woocommerce_template_single_meta',40);
if(!function_exists('kt_show_product_meta')){
    add_filter('woocommerce_single_product_summary','kt_show_product_meta',11);
    function kt_show_product_meta(){
        global $product;
        $sku          = $product->get_sku();
        $availability ="";
        if ( $product->is_in_stock() ) $availability = __('In stock', THEME_LANG);
        if ( !$product->is_in_stock() ) $availability = __('Out of stock', THEME_LANG);
        ?>
        <div class="product-meta">
            <?php if($sku!=""):?>
                <p><?php _e('Item Code', THEME_LANG );?>: #<?php echo $sku;?></p>
            <?php endif;?>
            <?php if($availability!=""):?>
                <p><?php _e('Availability', THEME_LANG );?>: <?php echo $availability;?></p>
            <?php endif;?>
        </div>
        <?php
    }
}
//Available Options

if(!function_exists('kt_available_options')){
    add_filter('woocommerce_single_product_summary','kt_available_options',21);
    function kt_available_options(){
        global $product;
        if( $product->is_type( 'variable' ) ){
            ?>
                <div class="available-options">
                    <h3 class="available-title"><?php echo _e('Available Options', THEME_LANG );?>:</h3>
                </div>
            <?php     
        }
    }
}
/**
* Custom item related_products
**/
if(!function_exists('kt_related_products_args')){
    add_filter( 'woocommerce_output_related_products_args', 'kt_related_products_args' );
    function kt_related_products_args( $args ) {
        $args['posts_per_page'] = 9; // 4 related product
        return $args;
    }
}

// Utilities
if(!function_exists('kt_utilities_single_product')){
    add_filter( 'woocommerce_single_product_summary', 'kt_utilities_single_product',51);
    function kt_utilities_single_product(){
        ?>
        <div class="utilities">
            <ul>
                <li><a href="javascript:print();"><i class="fa fa-print"></i> <?php _e('Print', THEME_LANG);?></a></li>
                <li><a href="<?php echo esc_url('mailto:?subject='.get_the_title());?>"><i class="fa fa-envelope-o"></i> <?php _e('Send to a friend', THEME_LANG);?></a></li>
            </ul>
        </div>
        <?php
    }   
}
//Tab category Deal
add_action('kt_loop_product_after_countdown', 'woocommerce_template_loop_rating', 5);
add_action('kt_loop_product_after_countdown', 'woocommerce_template_single_excerpt', 10);
