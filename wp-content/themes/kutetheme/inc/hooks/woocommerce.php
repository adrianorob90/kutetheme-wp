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
	return $price . sprintf( '<span class="colreduce-percentage"><span class="colreduce-parenthesis-open" >%3$s</span>-%1$s<span class="colreduce-lable">%2$s</span><span class="colreduce-parenthesis-close" >%4$s</span></span>', $percentage . __('%', 'kutetheme'), __( ' OFF', 'kutetheme' ), __( '(', 'kutetheme' ), __( ')', 'kutetheme' ) );
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
                $price . sprintf( '<span class="colreduce-percentage"><span class="colreduce-parenthesis-open" >%3$s</span>-%1$s<span class="colreduce-lable">%2$s</span><span class="colreduce-parenthesis-close" >%4$s</span></span>', $html_sale . $percentage . __('%', 'kutetheme'), __( ' OFF', 'kutetheme' ), __( '(', 'kutetheme' ), __( ')', 'kutetheme' ) );
                //$price .= sprintf( '<span class="colreduce-percentage">-%s <span class="colreduce-lable">%s</span></span>', $html_sale . $percentage . __('%', 'kutetheme'), __( 'OFF', 'kutetheme' ) );
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
    if($rating <=0) return'';
    $rating_html  = '<div class="product-star" title="' . sprintf( __( 'Rated %s out of 5', 'kutetheme' ), $rating > 0 ? $rating : 0  ) . '">';
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

if ( ! function_exists( 'kt_template_single_price' ) ) {

	/**
	 * Output the product price.
	 *
	 * @subpackage	Product
	 */
	function kt_template_single_price() {
	    add_filter("woocommerce_get_price_html_from_to", "kt_get_price_html_from_to", 10 , 4);
        add_filter( 'woocommerce_sale_price_html', 'woocommerce_custom_sales_price', 10, 2 );
		wc_get_template( 'single-product/price.php' );
        remove_filter( "woocommerce_get_price_html_from_to", "kt_get_price_html_from_to", 10 , 4);
        remove_filter( 'woocommerce_sale_price_html', 'woocommerce_custom_sales_price', 10, 2 );
	}
}
remove_action ( 'woocommerce_single_product_summary', 'woocommerce_template_single_price');
add_action( 'woocommerce_single_product_summary', 'kt_template_single_price', 15 );

//content-product-tab.php
add_action('kt_loop_product_thumbnail', 'kt_template_loop_product_thumbnail', 10);

add_action( 'woocommerce_template_loop_product_thumbnail', 'woocommerce_template_loop_product_thumbnail', 10 );

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
        echo sprintf('<a title="%1$s" data-id="%2$s" class="search btn-quick-view" href="#"></a>', __('Quick view', 'kutetheme'), get_the_ID() );
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

if( ! function_exists('woocommerce_datatime_sale_product_variable') ){
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
}

add_action( 'woocommerce_datatime_sale_product', 'woocommerce_datatime_sale_product_variable' );

/**
 * Mini cart
 * */
add_action( 'kt_mini_cart', 'woocommerce_mini_cart' );

add_action( 'kt_mini_cart_content', 'kt_get_cart_content', 10, 1 );
// Ensure cart contents update when products are added to the cart via AJAX (place the following in functions.php)
//add_filter( 'add_to_cart_fragments', 'kt_header_add_to_cart_fragment', 1, 1 );

if( ! function_exists('kt_get_cart_content') ){
    function kt_get_cart_content($check_out_url){
        if ( ! WC()->cart->is_empty() ) : ?>
            <div class="cart-block">
                <div class="cart-block-content">
                    <h5 class="cart-title"><?php _e( sprintf (_n( '%d item in my cart', '%d items in my cart', WC()->cart->cart_contents_count, 'kutetheme' ), WC()->cart->cart_contents_count ), 'kutetheme' ); ?></h5>
                    <div class="cart-block-list">
                        <ul>
                            <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ):
                                    $bag_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                                    $product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
                                    
                                    if ( $bag_product &&  $bag_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ): 
                                    
                                    $product_name  = apply_filters( 'woocommerce_cart_item_name', $bag_product->get_title(), $cart_item, $cart_item_key );
                					$thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $bag_product->get_image(), $cart_item, $cart_item_key );
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
                                                <?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<p class="quantity">' . sprintf( __('Qty: ', 'kutetheme').__('%s', 'kutetheme'), $cart_item['quantity'] ) . '</p>', $cart_item, $cart_item_key ); ?>
                                            </div>
                                        </li>
                                    <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="toal-cart">
                        <span><?php _e('Total', 'kutetheme') ?></span>
                        <span class="toal-price pull-right">
                            <?php echo WC()->cart->get_cart_total() ?>
                        </span>
                    </div>
                    <div class="cart-buttons">
                        <a href="<?php echo esc_url( $check_out_url ); ?>" class="btn-check-out"><?php echo _e( 'Checkout', 'kutetheme' ); ?></a>
                    </div>
                </div>
            </div>
        <?php endif;
    }
}

//Cart messsage

if( ! function_exists( 'kt_add_to_cart_message' ) ){
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
}

add_filter( 'wc_add_to_cart_message', 'kt_add_to_cart_message', 10 );

add_action( 'kt_woocommerce_single_product', 'kt_woocommerce_single_product' );

if( ! function_exists( 'kt_woocommerce_single_product' ) ){

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
                    <label><?php _e( 'Price', 'kutetheme' );?></label>
                    <?php woocommerce_template_single_price();?>
                </div>
            </div>
            <div class="product-section">
                <?php woocommerce_template_single_sharing();?>
            </div>
        </div>
        <?php
    }
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
if( ! function_exists( 'wp_ajax_frontend_product_quick_view_callback' ) ){
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
}
add_action( 'wp_ajax_frontend_product_quick_view', 'wp_ajax_frontend_product_quick_view_callback' );
add_action( 'wp_ajax_nopriv_frontend_product_quick_view', 'wp_ajax_frontend_product_quick_view_callback' );


/*
* Return a new number of maximum columns for shop archives
* @param int Original value
* @return int New number of columns
*/
if( ! function_exists( 'kt_loop_shop_columns' ) ){
    function kt_loop_shop_columns( $number_columns ) {
        $kt_woo_grid_column = kt_option('kt_woo_grid_column','3');
        return $kt_woo_grid_column;
    }
}
add_filter( 'loop_shop_columns', 'kt_loop_shop_columns', 1, 10 );

/**
* Custom category page
**/

//remove woocommerce resultcount
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

// add products display

if( ! function_exists( 'kt_custom_display_view' ) ){
    add_filter( 'woocommerce_before_shop_loop' , 'kt_custom_display_view' );
    function kt_custom_display_view(){
        $shop_products_layout = 'grid';
        if(isset($_SESSION['shop_products_layout'])){
            $shop_products_layout = $_SESSION['shop_products_layout'];
        }
        ?>
        <ul class="display-product-option">
            <li class="view-as-grid <?php if($shop_products_layout == "grid" ) echo esc_attr('selected');?>">
                <span><?php _e('grid','kutetheme');?></span>
            </li>
            <li class="view-as-list <?php if($shop_products_layout == "list" ) echo esc_attr('selected');?>">
                <span><?php _e('list', 'kutetheme' );?></span>
            </li>
        </ul>
        <?php
    }
}
// kt_custom_class_list_product

if( ! function_exists( 'kt_custom_class_list_product' ) ){
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

if( ! function_exists( 'kt_custom_products_per_page' )){
    function kt_custom_products_per_page(){
        $loop_shop_per_page = kt_option('kt_woo_products_perpage',18);
        // Display 24 products per page. Goes in functions.php
        return $loop_shop_per_page;
    }
}

/*-----------------
Category slider
-----------------*/
if( ! function_exists( 'kt_category_slider' ) ) {
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

if( ! function_exists( 'kt_display_sub_category' ) ) {
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
if( ! function_exists( 'wp_ajax_fronted_set_products_view_style_callback' ) ){
    function  wp_ajax_fronted_set_products_view_style_callback(){
        check_ajax_referer( 'screenReaderText', 'security' );
        $style = $_POST['style'];
        $_SESSION['shop_products_layout'] = $style;
        die;
    }
}

add_action( 'wp_ajax_fronted_set_products_view_style', 'wp_ajax_fronted_set_products_view_style_callback' );
add_action( 'wp_ajax_nopriv_fronted_set_products_view_style', 'wp_ajax_fronted_set_products_view_style_callback' );

/*------------------
Custom woocommerce_breadcrumb_defaults
-------------------*/

add_filter( 'woocommerce_breadcrumb_defaults', 'kt_change_breadcrumb_home_text' );

if( ! function_exists( 'kt_change_breadcrumb_home_text' ) ){
    function kt_change_breadcrumb_home_text( $defaults ) {
        // Change the breadcrumb home text from 'Home' to 'Appartment'
        $defaults['delimiter'] = '<span class="navigation-pipe">&nbsp;</span>';
        return $defaults;
    }
}
/*------------------
Custom woocommerce_page_title
-------------------*/
add_filter( 'woocommerce_page_title', 'custom_woocommerce_page_title');
if( ! function_exists( 'custom_woocommerce_page_title' ) ){
    function custom_woocommerce_page_title( $page_title ) {
      return  '<span>'.$page_title.'</span>';
    }
}

// Product meta
remove_action('woocommerce_single_product_summary','woocommerce_template_single_meta',40);

if( ! function_exists('kt_show_product_meta') ){
    add_filter('woocommerce_single_product_summary','kt_show_product_meta',11);
    function kt_show_product_meta(){
        global $product;
        $sku          = $product->get_sku();
        $availability ="";
        if ( $product->is_in_stock() ) $availability = __('In stock', 'kutetheme');
        if ( !$product->is_in_stock() ) $availability = __('Out of stock', 'kutetheme');
        ?>
        <div class="product-meta">
            <?php if($sku!=""):?>
                <p><?php _e('Item Code', 'kutetheme' );?>: #<?php echo $sku;?></p>
            <?php endif;?>
            <?php if($availability!=""):?>
                <p><?php _e('Availability', 'kutetheme' );?>: <?php echo $availability;?></p>
            <?php endif;?>
        </div>
        <?php
    }
}
//Available Options

if( ! function_exists( 'kt_available_options' ) ){
    add_filter('woocommerce_single_product_summary','kt_available_options',22);
    function kt_available_options(){
        global $product;
        if( $product->is_type( 'variable' ) ){
            ?>
                <div class="available-options">
                    <h3 class="available-title"><?php echo _e('Available Options', 'kutetheme' );?>:</h3>
                </div>
            <?php     
        }
    }
}
/**
* Custom item related_products
**/
if( ! function_exists( 'kt_related_products_args' ) ) {
    add_filter( 'woocommerce_output_related_products_args', 'kt_related_products_args' );
    function kt_related_products_args( $args ) {
        $args['posts_per_page'] = 9; // 4 related product
        return $args;
    }
}

// Utilities
if( ! function_exists( 'kt_utilities_single_product' ) ){
    add_filter( 'woocommerce_single_product_summary', 'kt_utilities_single_product',51);
    function kt_utilities_single_product(){
        ?>
        <div class="utilities">
            <ul>
                <li><a href="javascript:print();"><i class="fa fa-print"></i> <?php _e('Print', 'kutetheme');?></a></li>
                <li><a href="<?php echo esc_url('mailto:?subject='.get_the_title());?>"><i class="fa fa-envelope-o"></i> <?php _e('Send to a friend', 'kutetheme');?></a></li>
            </ul>
        </div>
        <?php
    }   
}
// size chart 
if( ! function_exists('kt_product_size_chart') ){
    add_filter( 'woocommerce_single_product_summary', 'kt_product_size_chart',21);
    function kt_product_size_chart(){
        $option_product = get_post_meta( get_the_ID()) ;
        if(isset($option_product['kt_product_size_chart'])){
            ?>
            <div class="product-size-chart">
            <a id="size_chart" class="fancybox" href="<?php echo esc_url( $option_product['kt_product_size_chart'][0]);?>"><?php _e('Size Chart','kutetheme')?></a>
            </div>
            <?php
        }
    }
}
//Tab category Deal
add_action('kt_loop_product_after_countdown', 'woocommerce_template_loop_rating', 5);
add_action('kt_loop_product_after_countdown', 'kt_template_single_excerpt', 10);
if(!function_exists('kt_template_single_excerpt')){
    function kt_template_single_excerpt(){
        global $post;
        if ( ! $post->post_excerpt ) {
            return;
        }

        ?>
        <div class="product-description">
            <?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt ) ?>
        </div>
        <?php
    }
}

add_action('single_product_large_thumbnail_size','kt_shop_single' );
if( ! function_exists( 'kt_shop_single' ) ){
    function kt_shop_single($shop_single){
        return 'kt_shop_single';
    }
}


add_action('single_product_small_thumbnail_size', 'kt_shop_thumbnail_image_size');

if ( ! function_exists( 'kt_shop_thumbnail_image_size' ) ) {
    function kt_shop_thumbnail_image_size( $shop_thumbnail ) {
        return 'kt_shop_thumbnail_image_size';
    }
}



// Custom single product images

if( ! function_exists( 'kt_show_product_images' ) ) {
    $kt_woo_style_image_product = kt_option('kt_woo_style_image_product','popup');
    if( $kt_woo_style_image_product =='zoom' ){
        remove_action( 'woocommerce_before_single_product_summary' , 'woocommerce_show_product_images',20);
        add_action( 'woocommerce_before_single_product_summary' ,'kt_show_product_images', 21 );
    }
    
    function kt_show_product_images(){
        global $post, $woocommerce, $product;
        ?>
        <div class="images single-product-image">
            <?php
            if( has_post_thumbnail() ){
                $image_title    = esc_attr( get_the_title( get_post_thumbnail_id() ) );
                $image_caption  = get_post( get_post_thumbnail_id() )->post_excerpt;
                $image_link     = wp_get_attachment_url( get_post_thumbnail_id() );
                $image          = get_the_post_thumbnail( $post->ID,array(417,510), array(
                    'title' => $image_title,
                    'alt'   => $image_title
                    ) );
                ?>
                <div class="product-image easyzoom easyzoom--overlay easyzoom--with-thumbnails">
                    <a href="<?php echo esc_url( $image_link );?>">
                        <?php
                        echo $image;
                        ?>
                    </a>
                </div>
                <?php
            }

            $attachment_ids = $product->get_gallery_attachment_ids();
            if( $attachment_ids ){
                ?>
                <div class="product-list-thumb">
                    <ul class="thumbnails kt-owl-carousel" data-margin="10" data-nav="true" data-responsive='{"0":{"items":2},"600":{"items":2},"1000":{"items":3}}'>
                            <?php foreach ($attachment_ids as $attachment_id) {
                            $image_link = wp_get_attachment_url( $attachment_id );
                            if(!$image_link)
                                continue;

                            $image_title    = esc_attr( get_the_title( $attachment_id ) );

                            $image       = wp_get_attachment_image( $attachment_id,array(100,122), 0, $attr = array(
                                'title' => $image_title,
                                'alt'   => $image_title
                                ) );
                            $standard_link = wp_get_attachment_url( $attachment_id);
                            ?>
                            <li>
                                <a href="<?php echo esc_url( $image_link );?>" data-standard="<?php echo esc_url( $standard_link );?>">
                                    <?php echo $image ;?>
                                </a>
                            </li>
                            <?php
                        } 
                        ?>
                    </ul>
                </div>
                <?php
            }
        ?>
        </div>
        <?php
    }
}
/**
 * Define image sizes
 */
if ( ! function_exists( 'kt_woocommerce_image_dimensions' ) ) {
    function kt_woocommerce_image_dimensions() {
        $catalog = array(
            'width'     => '300',   // px
            'height'    => '366',   // px
            'crop'      => 1        // true
        );
    
        $single = array(
            'width'     => '420',   // px
            'height'    => '512',   // px
            'crop'      => 1        // true
        );
    
        $thumbnail = array(
            'width'     => '100',   // px
            'height'    => '122',   // px
            'crop'      => 0        // false
        );
    
        // Image sizes
        update_option( 'shop_catalog_image_size', $catalog );       // Product category thumbs
        update_option( 'shop_single_image_size', $single );         // Single product image
        update_option( 'shop_thumbnail_image_size', $thumbnail );   // Image gallery thumbs
    }
    
    /*
     * Hook in on activation
     *
     */
    add_action( 'init', 'kt_woocommerce_image_dimensions', 1 );

}

if ( ! function_exists( 'kt_get_product_thumbnail' ) ) {

	/**
	 * Get the product thumbnail, or the placeholder if not set.
	 *
	 * @subpackage	Loop
	 * @param string $size (default: 'shop_catalog')
	 * @param int $deprecated1 Deprecated since WooCommerce 2.0 (default: 0)
	 * @param int $deprecated2 Deprecated since WooCommerce 2.0 (default: 0)
	 * @return string
	 */
	function kt_get_product_thumbnail( $size = 'shop_catalog', $deprecated1 = 0, $deprecated2 = 0 ) {
		global $post;
        
        $dimensions = wc_get_image_size( $size );
        
        $placeholder = 'images/placeholder-'.$size.'.png';
        
        if( ! file_exists( THEME_DIR . $placeholder ) ){
            if( wc_placeholder_img_src() ){
                $placeholder = wc_placeholder_img_src();
            }else{
                $placeholder = THEME_URL . 'images/placeholder-shop_catalog.png';
            }
        }else{
            $placeholder = THEME_URL . $placeholder;
        }
        
        $title = $post->post_title;
		if ( has_post_thumbnail() ) {
		    $id = get_post_thumbnail_id();
			$thumbnail_src = wp_get_attachment_image_src( $id, $size );
            
            $thumbnail = '<img class="lazy attachment-' . $size . ' wp-post-image" src="' . $placeholder . '"  data-original="' . $thumbnail_src[0] . '" width="' . esc_attr( $dimensions['width'] ) . '" height="' . esc_attr( $dimensions['height'] ) . '" alt="' . esc_attr( $title ) . '" >';
            return $thumbnail;
		}else{
		    $thumbnail = '<img class="attachment-' . $size . '" src="' . $placeholder . '" width="' . esc_attr( $dimensions['width'] ) . '" height="' . esc_attr( $dimensions['height'] ) . '" alt="' . esc_attr( $title ) . '" >';
            return $thumbnail;  
		}
	}
}

if ( ! function_exists( 'kt_template_loop_product_thumbnail' ) ) {

	/**
	 * Get the product thumbnail for the loop.
	 *
	 * @subpackage	Loop
	 */
	function kt_template_loop_product_thumbnail() {
		echo kt_get_product_thumbnail();
	}
}


if(!function_exists('kt_short_tring')){
    function kt_short_tring($str,$words=10,$after='...'){
        echo $str = preg_replace('!\s+!', ' ', $str);
        $output="";
        if($str!=""){
            $atrr = explode(' ',$str);
            if(count($atrr) <= $words){
                return $str;
            }
            for($i=0;$i<= $words; $i++){
                $output.=$atrr[$i]." ";
            }
            $output = trim($output).$after;

        }
        return $output;
    }
}

if(!function_exists('kt_get_hot_product_tags')){
    function kt_get_hot_product_tags($number=3){
        $args = array(
            'number'  =>$number,
            'orderby' =>'count',
            'order'   =>'DESC'
        );
        $terms = get_terms( 'product_tag',$args);
       ?>
       <?php if($terms):?>
       <div class="keyword">
            <p class="lebal"><?php _e('Keywords', 'kutetheme')?>:</p>
            <p>
                <?php
                    $i=0;
                ?>
                <?php foreach($terms as $term):?>
                    <?php
                    $i++;
                    ?>
                    <a href="<?php echo get_term_link( $term );?>"><?php echo $term->name;?><?php if($i < $number) echo ', '; else echo ' ..';?></a>
                <?php endforeach;?>
            </p>
        </div>
    <?php endif;?>
       <?php
    }
}

if(!function_exists('kt_get_social_header')){
    function kt_get_social_header(){
        $social_icons = '';
        $facebook   = kt_option('kt_facebook_link_id');
        $twitter    = kt_option('kt_twitter_link_id');
        $pinterest  = kt_option('kt_pinterest_link_id');
        $dribbble   = kt_option('kt_dribbble_link_id');
        $vimeo      = kt_option('kt_vimeo_link_id');
        $tumblr     = kt_option('kt_tumblr_link_id');
        $skype      = kt_option('kt_skype_link_id');
        $linkedin   = kt_option('kt_linkedIn_link_id');
        $vk         = kt_option('kt_vk_link_id');
        $googleplus = kt_option('kt_google_plus_link_id');
        $youtube    = kt_option('kt_youtube_link_id');
        $instagram  = kt_option('kt_instagram_link_id');
        
        if ($facebook) {
            $social_icons .= '<a href="'.esc_url($facebook).'" title ="Facebook" ><i class="fa fa-facebook"></i></a>';
        }
        if ($twitter) {
            $social_icons .= '<a href="http://www.twitter.com/'.esc_attr($twitter).'" title ="Twitter" ><i class="fa fa-twitter"></i></a>';
        }
        if ($dribbble) {
            $social_icons .= '<a href="http://www.dribbble.com/'.esc_attr($dribbble).'" title ="Dribbble" ><i class="fa fa-dribbble"></i></a>';
        }
        if ($vimeo) {
            $social_icons .= '<a href="http://www.vimeo.com/'.esc_attr($vimeo).'" title ="Vimeo" ><i class="fa fa-vimeo-square"></i></a>';
        }
        if ($tumblr) {
            $social_icons .= '<a href="http://'.esc_attr($tumblr).'.tumblr.com/" title ="Tumblr" ><i class="fa fa-tumblr"></i></a>';
        }
        if ($skype) {
            $social_icons .= '<a href="skype:'.esc_attr($skype).'" title ="Skype" ><i class="fa fa-skype"></i></a>';
        }
        if ($linkedin) {
            $social_icons .= '<a href="'.esc_attr($linkedin).'" title ="Linkedin" ><i class="fa fa-linkedin"></i></a>';
        }
        if ($googleplus) {
            $social_icons .= '<a href="'.esc_url( $googleplus ).'" title ="Google Plus" ><i class="fa fa-google-plus"></i></a>';
        }
        if ($youtube) {
            $social_icons .= '<a href="http://www.youtube.com/user/'.esc_attr( $youtube ).'" title ="Youtube"><i class="fa fa-youtube"></i></a>';
        }
        if ($pinterest) {
            $social_icons .= '<a href="http://www.pinterest.com/'.esc_attr( $pinterest ).'/" title ="Pinterest" ><i class="fa fa-pinterest-p"></i></a>';
        }
        if ($instagram) {
            $social_icons .= '<a href="http://instagram.com/'.esc_attr( $instagram ).'" title ="Instagram" ><i class="fa fa-instagram"></i></a>';
        }
        
        if ($vk) {
            $social_icons .= '<a href="https://vk.com/'.esc_attr( $vk ).'" title ="Vk" ><i class="fa fa-vk"></i></a>';
        }
        ?>
        <?php if($social_icons!=""):?>
        <div class="top-bar-social">
            <?php echo $social_icons;?>
        </div>
        <?php endif;?>
        <?php
    }
}

// Custom rating review

if( !function_exists( 'kt_review_rating_html' ) ){
    function kt_review_rating_html( $rating ){
        $rating_html = '';
        if($rating <=0) return '';
        $rating_html  = '<div class="review-rating" title="' . sprintf( __( 'Rated %s out of 5', 'kutetheme' ), $rating > 0 ? $rating : 0  ) . '">';
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
}