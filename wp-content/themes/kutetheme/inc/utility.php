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
        $hotline = kt_get_info_hotline();
        $email   = kt_get_info_email();
        ob_start();
        ?>
            <div class="nav-top-links link-contact-us">
                <?php if( $hotline ) : ?>
                    <a title="<?php echo esc_attr( $hotline ); ?>">
                        <span><i class="fa fa-phone"></i> <?php echo esc_attr( $hotline );?></span>
                    </a>
                <?php endif; ?>
                <?php if( $email && is_email( $email ) ) : ?>
                    <a href="<?php echo esc_attr( 'mailto:'. $email );?>" title="<?php echo esc_attr( $email );?>">
                        <span><i class="fa fa-envelope"></i> <?php _e( 'Contact us today !', 'kutetheme' ) ?></span>
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
        
        $html = '<a href="'.esc_url( get_home_url() ).'"><img alt="'.esc_attr( get_bloginfo('name') ).'" src="'.esc_url($default).'" /></a>';
        return $html;
    }
}

if( ! function_exists( "kt_get_logo_footer" ) ){
    function kt_get_logo_footer(){
        $default = kt_option("kt_logo_footer" , THEME_URL . 'images/logo.png');
        
        $html = '<a href="' . esc_url( get_home_url('/') ) . '"><img alt="' . esc_attr( get_bloginfo('name')) . '" src="' . esc_url($default) . '" /></a>';
        return $html;
    }
}
if( ! function_exists( 'kt_get_info_address' )){
    function kt_get_info_address(){
        return  kt_option('kt_address', false);
    }
}

if( ! function_exists( 'kt_get_info_hotline' )){
    function kt_get_info_hotline(){
        return  kt_option('kt_phone', false);
    }
}
if( ! function_exists( 'kt_get_info_email' )){
    function kt_get_info_email(){
        return kt_option('kt_email', false);
    }
}
if( ! function_exists('kt_get_info_copyrights') ){
    function kt_get_info_copyrights(){
        return kt_option( 'kt_copyrights', false );
    }
}
if( ! function_exists( 'kt_get_inline_css' ) ){
    function kt_get_inline_css(){
        return kt_option( 'kt_add_css', '' );
    }
}

if( ! function_exists( 'kt_get_customize_js' ) ){
    function kt_get_customize_js(){
        return kt_option( 'kt_add_js', '' );
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
    function kt_menu_my_account( $output = '' ){
        ob_start();
        ?>
        <div id="user-info-top" class="user-info pull-right">
            <div class="dropdown">
                <a class="current-open" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">
                    <span><?php _e( 'My Account', 'kutetheme' ) ?></span>
                </a>
                <ul class="dropdown-menu mega_dropdown" role="menu">
                    <?php if ( ! is_user_logged_in() ):  ?>
                        <?php if( kt_is_wc() ): 
                                $url = get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>
                            <li><a href="<?php echo esc_url( $url ); ?>" title="<?php _e( 'Login / Register', 'kutetheme' ) ?>"><?php _e('Login / Register', 'kutetheme'); ?></a></li>
                        <?php else: 
                            $url = wp_login_url();
                            $url_register = wp_registration_url(); ?>
                            <li><a href="<?php echo esc_url( $url ); ?>" title="<?php _e( 'Login', 'kutetheme' ) ?>"><?php _e( 'Login', 'kutetheme' ) ?></a></li>
                            <li><a href="<?php echo esc_url( $url_register ); ?>" title="<?php _e( 'Register', 'kutetheme' ); ?>"><?php _e( 'Register', 'kutetheme' ); ?></a></li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li><a href="<?php echo esc_url( wp_logout_url() ); ?>"><?php _e( 'Logout', 'kutetheme' ) ?></a></li>
                        <?php if( function_exists( 'YITH_WCWL' ) ):
                            $wishlist_url = YITH_WCWL()->get_wishlist_url(); ?>
                            <li><a href="<?php echo esc_url( $wishlist_url ); ?>"><?php _e( 'Wishlists', 'kutetheme' ) ?></a></li>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if(defined( 'YITH_WOOCOMPARE' )): 
                            global $yith_woocompare; 
                            $count = count($yith_woocompare->obj->products_list); ?>
                        <li><a href="#" class="yith-woocompare-open"><?php _e( "Compare", 'kutetheme') ?><span>(<?php echo esc_attr( $count ); ?>)</span></a></li>
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
            echo esc_url( get_page_link( $kt_page_service ) );
        }
    }
}

if( ! function_exists( 'kt_support_link' ) ){
    function kt_support_link(){
        $kt_page_support = kt_option( 'kt_page_support', false );
        if( $kt_page_support ){
            echo esc_url( get_page_link( $kt_page_support ) );
        }
    }
}

if( ! function_exists('kt_about_us_link')){
    function kt_about_us_link(){
        $kt_page_about_us = kt_option( 'kt_page_about_us', false );
        if( $kt_page_about_us ){
            echo esc_url( get_page_link( $kt_page_about_us ) );
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

if( ! function_exists('get_wishlist_url') ){
    function get_wishlist_url(){
        if( function_exists( 'YITH_WCWL' ) ):
            $wishlist_url = YITH_WCWL()->get_wishlist_url();
            return esc_url( $wishlist_url );
        endif;
    }
}

if( ! function_exists('kt_get_all_attributes') ){
    function kt_get_all_attributes( $tag, $text ) {
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
        'prev_text'          => sprintf( '<i class="fa fa-angle-double-left"></i> %1$s', __( 'Previous', 'kutetheme' ) ),
        'next_text'          => sprintf( '%1$s <i class="fa fa-angle-double-right"></i>', __( 'Next', 'kutetheme' ) ),
        'screen_reader_text' => '&nbsp;',
        'before_page_number' => '',
    ) );
    
}
endif;

if ( ! function_exists( 'kt_comment_nav' ) ) :
    /**
     * Display navigation to next/previous comments when applicable.
     *
     * @since KuteTheme 1.0
     */
    function kt_comment_nav() {
        // Are there comments to navigate through?
        if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
            ?>
            <nav class="navigation comment-navigation" role="navigation">
                <h2 class="screen-reader-text"><?php _e( 'Comment navigation', 'kutetheme' ); ?></h2>
                <div class="nav-links">
                    <?php
                    if ( $prev_link = get_previous_comments_link( __( 'Older Comments', 'kutetheme' ) ) ) :
                        printf( '<div class="nav-previous">%s</div>', esc_url( $prev_link ) );
                    endif;

                    if ( $next_link = get_next_comments_link( __( 'Newer Comments',  'kutetheme' ) ) ) :
                        printf( '<div class="nav-next">%s</div>', esc_url( $next_link ) );
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
function kt_comments( $comment, $args, $depth ) {
    $GLOBALS[ 'comment' ] = $comment; ?>

<li <?php comment_class('comment'); ?> id="li-comment-<?php comment_ID() ?>">
    <div  id="comment-<?php comment_ID(); ?>" class="comment-item">

        <div class="comment-avatar">
            <?php echo get_avatar( $comment->comment_author_email, $size = '90', $default = '' ); ?>
        </div>
        <div class="comment-content">
            <div class="comment-meta">
                <a class="comment-author" href="#"><?php printf( '<b class="author_name">%s </b>', get_comment_author_link()) ?></a>
                <span class="comment-date"><?php printf( '%1$s' , get_comment_date( 'F j, Y \a\t g:i a' )); ?></span>
            </div>
            <div class="comment-entry entry-content">
                <?php comment_text() ?>
                <?php if ( $comment->comment_approved == '0' ) : ?>
                    <em><?php _e( 'Your comment is awaiting moderation.', 'kutetheme' ) ?></em>
                <?php endif; ?>
            </div>
            <div class="comment-actions clear">
                <?php edit_comment_link( __( '(Edit)', 'kutetheme'),'  ','' ) ?>
                <?php comment_reply_link( array_merge( $args,
                    array(
                        'depth'      => $depth,
                        'max_depth'  => $args['max_depth'],
                        'reply_text' =>'<i class="fa fa-share"></i> '.__( 'Reply', 'kutetheme' )
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

if ( ! function_exists( 'kt_sidebars' ) ){
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
        if( ! isset( $setting["walker"] ) ) {
            $setting[ "walker" ] = new KTMegaWalker();
        }
        wp_nav_menu( $setting );
    }
}

/**
 * Render data option for carousel
 * 
 * @param $data array. All data for carousel
 * 
 */
function _data_carousel( $data ){
    $output = "";
    foreach($data as $key => $val){
        if($val){
            $output .= ' data-'.$key.'="'.esc_attr( $val ).'"';
        }
    }
    return $output;
}

if( ! function_exists( 'kt_get_post_meta' ) ) {
    function kt_get_post_meta( $post_id, $key, $default = "" ){
        $meta = get_post_meta( $post_id, $key, true );
        if($meta){
            return $meta;
        }
        return $default;
    }
}