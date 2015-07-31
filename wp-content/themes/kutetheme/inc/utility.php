<?php
/**
* Function to get options in front-end
* @param int $option The option we need from the DB
* @param string $default If $option doesn't exist in DB return $default value
* @return string
*/
$kt_used_header = 1;
if( ! function_exists( 'kt_get_header' )){
    function kt_get_header(){
        global $kt_used_header;
        $setting = kt_option('kt_used_header', '1');
        
        $kt_used_header = intval($setting);
        
        get_template_part( 'templates/headers/header',  $setting);
    }
}

if( ! function_exists( 'kt_get_hotline' )){
    function kt_get_hotline(){
        $hotline = kt_option('kt_phone', false);
        $email   = kt_option('kt_email', false);
        ob_start();
        ?>
            <div class="nav-top-links link-contact-us">
                <?php if( $hotline ) : ?>
                    <a title="<?php echo $hotline;?>">
                        <img alt="<?php echo $hotline;?>" src="<?php $phone_icon = THEME_URL.'/images/phone.png'; echo $phone_icon; ?>" />
                        <span><?php echo $hotline;?></span>
                    </a>
                <?php endif; ?>
                <?php if( $email ) : ?>
                    <a href="mailto:<?php echo $email;?>" title="<?php echo $email;?>">
                        <img alt="<?php echo $email;?>" src="<?php $email_icon = THEME_URL.'/images/email.png'; echo $email_icon; ?>" />
                        <span><?php _e('Contact us today !', THEME_LANG) ?></span>
                    </a>
                <?php endif; ?>
            </div>
        <?php
        $result = ob_get_contents();
        ob_end_clean();
        return  $result;
    }
}
if ( ! function_exists( 'kt_option' ) ){
    function kt_option( $option = false, $default = false ){
        if($option === FALSE){
            return FALSE;
        }
        $option_name = apply_filters('theme_option_name', 'kt_options' );
        $kt_options  = wp_cache_get( $option_name );
        if(  ! $kt_options ){
            $kt_options = get_option( $option_name );
            if( empty($kt_options)  ){
                // get default theme option
                if( defined( 'ICL_LANGUAGE_CODE' ) ){
                    $kt_options = get_option( 'kt_options' );
                }
            }
            wp_cache_delete( $option_name );
            wp_cache_add( $option_name, $kt_options );
        }
        if(isset($kt_options[$option]) && $kt_options[$option] !== ''){
            return $kt_options[$option];
        }else{
            return $default;
        }
    }
}

if( ! function_exists( "kt_get_logo" ) ){
    function kt_get_logo(){
        $default = kt_option("kt_logo" , THEME_URL . '/images/logo.png');
        
        $html = '<a href="'.get_home_url().'"><img alt="'.get_bloginfo('name').'" src="'.esc_url($default).'" /></a>';
        return $html;
    }
}
/**
 * Display dropdown choose language
 * */
if( ! function_exists( "kt_get_wpml" )){
    function kt_get_wpml(){
        //Check function icl_get_languages exist 
        if( kt_is_wpml() ){
            $languages = icl_get_languages( 'skip_missing=0&orderby=code' );
            
            if(!empty($languages)){
                //Find language actived
                foreach( $languages as $lang_k => $lang ){
                    if( $lang['active'] ){
                        $active_lang = $lang;
                    }
                }
            }
            $html = '<div class="language">
                    <div class="dropdown">
                        <a class="current-open" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">
                            <img alt="email" src="'.esc_url($active_lang['country_flag_url']).'" />
                            <span>'.$active_lang["translated_name"].'</span>
                        </a>';
              $html .= '<ul class="dropdown-menu" role="menu">';
                            foreach($languages as $lang):
                                printf('<li><a href="%4$s"><img src="%1$s" alt="%2$s"><span>%3$s</span></a></li>',
                                    esc_url($lang['country_flag_url']),
                                    $lang["language_code"],
                                    $lang["translated_name"],
                                    $lang['url']
                                );
                            endforeach;
            $html .= '</ul>
                </div>
			</div>';
            return $html;
        }
    }
}
if( ! function_exists('kt_menu_my_account')){
    function kt_menu_my_account($output = ''){
        ob_start();
        ?>
        <div id="user-info-top" class="user-info pull-right">
            <div class="dropdown">
                <a class="current-open" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">
                    <span><?php _e( 'My Account', THEME_LANG ) ?></span>
                </a>
                <ul class="dropdown-menu mega_dropdown" role="menu">
                    <?php if ( ! is_user_logged_in() ):  ?>
                        <?php if( kt_is_wc() ): $url = get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>
                            <li><a href="<?php echo $url; ?>" title="<?php _e( 'Login / Register', THEME_LANG ) ?>"><?php _e('Login / Register', THEME_LANG); ?></a></li>
                        <?php else: 
                            $url = wp_login_url();
                            $url_register = wp_registration_url(); ?>
                            <li><a href="<?php echo $url; ?>" title="<?php _e('Login', THEME_LANG) ?>"><?php _e('Login', THEME_LANG) ?></a></li>
                            <li><a href="<?php echo $url_register; ?>" title="<?php _e('Register', THEME_LANG); ?>"><?php _e('Register', THEME_LANG); ?></a></li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li><a href="<?php echo wp_logout_url(); ?>"><?php _e('Logout', THEME_LANG) ?></a></li>
                        <?php if( function_exists( 'YITH_WCWL' ) ):
                            $wishlist_url = YITH_WCWL()->get_wishlist_url(); ?>
                            <li><a href="<?php echo $wishlist_url; ?>"><?php _e( 'Wishlists', THEME_LANG) ?></a></li>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php 
                    if(defined( 'YITH_WOOCOMPARE' )): global $yith_woocompare; $count = count($yith_woocompare->obj->products_list); ?>
                        <li><a href="#" class="yith-woocompare-open"><?php _e( "Compare", THEME_LANG) ?><span>(<?php echo $count ?>)</span></a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
        <?php
        $return = ob_get_contents();
        ob_clean();
        return $return;
    }
}
if( ! function_exists( 'kt_service_link' ) ){
    function kt_service_link(){
        $kt_page_service = kt_option( 'kt_page_service', false );
        if( $kt_page_service ){
            echo get_page_link( $kt_page_service );
        }
    }
}

if( ! function_exists( 'kt_support_link' ) ){
    function kt_support_link(){
        $kt_page_support = kt_option( 'kt_page_support', false );
        if( $kt_page_support ){
            echo get_page_link( $kt_page_support );
        }
    }
}

if( ! function_exists('kt_about_us_link')){
    function kt_about_us_link(){
        $kt_page_about_us = kt_option( 'kt_page_about_us', false );
        if( $kt_page_about_us ){
            echo get_page_link( $kt_page_about_us );
        }
    }
}

if( ! function_exists('kt_search_form') ){
    function kt_search_form(){
        if( kt_is_wc() ){
            get_template_part('templates/search-form/product', 'search-form' );
        }else{
            get_template_part('templates/search-form/post', 'search-form' );
        }
    }
}

if( ! function_exists('kt_cart_button')){
    function kt_cart_button(){
        if( kt_is_wc() ):
        ob_start();
        $cart_count =  WC()->cart->cart_contents_count ;
        $cart_total = WC()->cart->get_cart_total() ;
        $check_out_url = WC()->cart->get_cart_url();
        $cart_content = WC()->cart->cart_contents;
        global $kt_used_header;
        ?>
        
            <?php if( $kt_used_header == 6 ): ?>
                <div class="btn-cart" id="cart-block">
                    <a href="<?php echo $check_out_url; ?>" title="<?php _e( 'My cart', THEME_LANG ) ?>" ><?php _e( 'Cart', THEME_LANG ) ?></a>
                    <span class="notify notify-right"><?php echo $cart_count; ?></span>
                    <?php echo kt_get_cart_content($cart_content, $cart_total, $check_out_url); ?>
                </div>
            <?php else: ?>
                <div id="cart-block" class="shopping-cart-box col-xs-5 col-sm-2">
                    <a class="cart-link" href="<?php echo $check_out_url; ?>">
                        <span class="title"><?php _e('Shopping cart', THEME_LANG) ?></span>
                        <span class="total"><?php echo sprintf (_n( '%d item', '%d items', $cart_count ), $cart_count ); ?> <?php _e('-', THEME_LANG) ?> <?php echo $cart_total ?></span>
                        <span class="notify notify-left"><?php echo $cart_count; ?></span>
                    </a>
                    <?php echo kt_get_cart_content($cart_content, $cart_total, $check_out_url); ?>
                </div>
            <?php endif; ?>
        <?php
        endif;
        $result = ob_get_contents();
        ob_clean();
        return $result;
    }
}
if( ! function_exists('kt_get_cart_content')){
    function kt_get_cart_content($cart_content, $cart_total, $check_out_url, $option = 1){
        ob_start();
        if ( sizeof($cart_content) > 0 ): ?>
            <div class="cart-block">
                <div class="cart-block-content">
                    <h5 class="cart-title"><?php _e( sprintf (_n( '%d item in my cart', '%d items in my cart', WC()->cart->cart_contents_count ), WC()->cart->cart_contents_count ), THEME_LANG ); ?></h5>
                    <div class="cart-block-list">
                        <ul>
                            <?php foreach ( $cart_content as $cart_item_key => $cart_item ):
                                    $bag_product = $cart_item['data']; 
                                    
                                    if ( $bag_product->exists() && $cart_item['quantity'] > 0 ): ?>
                                        <li class="product-info">
                                            <div class="p-left">
                                                <a href="<?php echo esc_url( WC()->cart->get_remove_url( $cart_item_key ) ); ?>" class="remove_link"></a>
                                                <a href="<?php echo get_permalink($cart_item['product_id']) ?>">
                                                    <?php echo $bag_product->get_image('100x122'); ?>
                                                </a>
                                            </div>
                                            <div class="p-right">
                                                <p class="p-name"><?php echo $bag_product->get_title(); ?></p>
                                                <p class="p-rice"><?php echo wc_price($bag_product->get_price()) ?></p>
                                                <p><?php _e('Qty', THEME_LANG) ?><?php _e(':', THEME_LANG) ?> <?php echo $cart_item['quantity']; ?></p>
                                            </div>
                                        </li>
                                    <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="toal-cart">
                        <span><?php _e('Total', THEME_LANG) ?></span>
                        <span class="toal-price pull-right">
                            <?php echo $cart_total; ?>
                        </span>
                    </div>
                    <div class="cart-buttons">
                        <a href="<?php echo $check_out_url; ?>" class="btn-check-out"><?php echo _e('Checkout', THEME_LANG ); ?></a>
                    </div>
                </div>
            </div>
        <?php endif;//if ( sizeof(WC()->cart->cart_contents)>0 ) {
        $result = ob_get_contents();
        ob_clean();
        return $result;
    }
}
if( ! function_exists('get_wishlist_url') ){
    function get_wishlist_url(){
        if( function_exists( 'YITH_WCWL' ) ):
            $wishlist_url = YITH_WCWL()->get_wishlist_url();
            return $wishlist_url;
        endif;
    }
}

if( ! function_exists('kt_get_all_attributes') ){
    function kt_get_all_attributes( $tag, $text )
    {
        preg_match_all( '/' . get_shortcode_regex() . '/s', $text, $matches );
        $out = array();
        if( isset( $matches[2] ) )
        {
            foreach( (array) $matches[2] as $key => $value )
            {
                if( $tag === $value )
                    $out[] = shortcode_parse_atts( $matches[3][$key] );  
            }
        }
        return $out;
    }
}
/************************************************************************************************************/
/**
 * Function check install plugin wpnl
 * */
function  kt_is_wpml(){
    return function_exists( 'icl_get_languages' );
}
/**
 * Function check if WC Plugin installed
 */
function kt_is_wc(){
    return function_exists( 'is_woocommerce' );
}
/**
* Function check exist Visual composer
**/
 function kt_is_vc(){
    return function_exists( "vc_map" );
 }
 if ( ! function_exists( 'kt_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since Twenty Fourteen 1.0
 *
 * @global WP_Query   $wp_query   WordPress Query object.
 * @global WP_Rewrite $wp_rewrite WordPress Rewrite object.
 */
function kt_paging_nav() {
	global $wp_query, $wp_rewrite;
    
    // Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 ) {
		return;
	}
    
    echo get_the_posts_pagination( array(
        'prev_text'          => __( '<i class="fa fa-caret-left"></i>', THEME_LANG ),
        'next_text'          => __( '<i class="fa fa-caret-right"></i>', THEME_LANG ),
        'screen_reader_text' => __('Page:',THEME_LANG),
        'before_page_number' => '',
    ) );
    
}
endif;

if ( ! function_exists( 'kt_comment_nav' ) ) :
    /**
     * Display navigation to next/previous comments when applicable.
     *
     * @since London 1.0
     */
    function kt_comment_nav() {
        // Are there comments to navigate through?
        if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
            ?>
            <nav class="navigation comment-navigation" role="navigation">
                <h2 class="screen-reader-text"><?php _e( 'Comment navigation', THEME_LANG ); ?></h2>
                <div class="nav-links">
                    <?php
                    if ( $prev_link = get_previous_comments_link( __( 'Older Comments', THEME_LANG ) ) ) :
                        printf( '<div class="nav-previous">%s</div>', $prev_link );
                    endif;

                    if ( $next_link = get_next_comments_link( __( 'Newer Comments',  THEME_LANG ) ) ) :
                        printf( '<div class="nav-next">%s</div>', $next_link );
                    endif;
                    ?>
                </div><!-- .nav-links -->
            </nav><!-- .comment-navigation -->
        <?php
        endif;
    }
endif;

/**
 *
 * Custom call back function for default post type
 *
 * @param $comment
 * @param $args
 * @param $depth
 */
function kt_comments($comment, $args, $depth) {
    $GLOBALS[ 'comment' ] = $comment; ?>

<li <?php comment_class('comment'); ?> id="li-comment-<?php comment_ID() ?>">
    <div  id="comment-<?php comment_ID(); ?>" class="comment-item">

        <div class="comment-avatar">
            <?php echo get_avatar( $comment->comment_author_email, $size = '90', $default = '' ); ?>
        </div>
        <div class="comment-content">
            <div class="comment-meta">
                <a class="comment-author" href="#"><?php printf(__('<b class="author_name">%s </b>'), get_comment_author_link()) ?></a>
                <span class="comment-date"><?php printf( '%1$s' , get_comment_date( 'F j, Y \a\t g:i a' )); ?></span>
            </div>
            <div class="comment-entry entry-content">
                <?php comment_text() ?>
                <?php if ( $comment->comment_approved == '0' ) : ?>
                    <em><?php _e( 'Your comment is awaiting moderation.', THEME_LANG ) ?></em>
                <?php endif; ?>
            </div>
            <div class="comment-actions clear">
                <?php edit_comment_link( __( '(Edit)', THEME_LANG),'  ','' ) ?>
                <?php comment_reply_link( array_merge( $args,
                    array('depth' => $depth,
                        'max_depth' => $args['max_depth'],
                        'reply_text' =>'<i class="fa fa-share"></i> '.__('Reply')
                    ))) ?>
            </div>
        </div>

        <div class="clear"></div>
    </div>
<?php
}

function kt_get_all_revSlider( ){
	$options = array();
    
    if ( class_exists( 'RevSlider' ) ) {
        $revSlider = new RevSlider();
        $arrSliders = $revSlider->getArrSliders();
        
        if(!empty($arrSliders)){
			foreach($arrSliders as $slider){
			   $options[$slider->getParam("alias")] = $slider->getParam("title");
			}
        }
    }

	return $options;
}
/**
* Function to get sidebars
* 
* @return array
*/

if ( ! function_exists('kt_sidebars') ){
    function kt_sidebars( ){
        $sidebars = array();
        foreach ( $GLOBALS[ 'wp_registered_sidebars' ] as $item ) {
            $sidebars[ $item[ 'id' ] ] = $item[ 'name' ];
        }
        return $sidebars;
    }
}
/**
 * Function get menu by setting
 * Create menu's place holder
 * @param array $setting The Menu is changed by it
 * */
if( ! function_exists( "kt_get_menu" ) ){
    function kt_get_menu($setting = array( 'theme_location' => 'primary', 'container' => 'nav', 'container_id' => 'main-nav-mobile', 'menu_class' => 'menu navigation-mobile' )){
        if( ! isset($setting["walker"])){
            $setting[ "walker" ] = new KTMegaWalker();
        }
        wp_nav_menu( $setting );
    }
}