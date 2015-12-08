<?php
/**
* Function to get options in front-end
* @param int $option The option we need from the DB
* @param string $default If $option doesn't exist in DB return $default value
* @return string
*/
$kt_used_header = 1;

$kt_enable_vertical_menu = 'enable';

if( ! function_exists( 'kt_get_header' )){
    function kt_get_header(){
        global $kt_used_header;
        
        if( isset( $kt_used_header ) && $kt_used_header ){
            $setting = kt_option('kt_used_header', '1');
            $kt_used_header = intval($setting);
        }
        
        get_template_part( 'templates/headers/header',  $kt_used_header);
    }
}

if(!function_exists( 'kt_get_footer' )){
    function kt_get_footer(){
        $footer = kt_option('kt_footer_style', '1');
        get_template_part( 'templates/footers/footer',  $footer);
    }
}
if( ! function_exists( 'kt_get_favicon' ) ){
    function kt_get_favicon(){
        $default = kt_option("kt_favicon" , THEME_URL . '/images/favicon.ico');
        echo '<link rel="shortcut icon" href="' . $default . '" />';
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
                    <a class="hotline" title="<?php echo esc_attr( $hotline ); ?>">
                        <span><i class="fa fa-phone"></i> <?php echo esc_attr( $hotline );?></span>
                    </a>
                <?php endif; ?>
                <?php if( $email && is_email( $email ) ) : ?>
                    <a class="email" href="<?php echo esc_attr( 'mailto:'. $email );?>" title="<?php echo esc_attr( $email );?>">
                        <span><i class="fa fa-envelope"></i> <?php esc_html_e( 'Contact us today !', 'kutetheme' ) ?></span>
                    </a>
                <?php endif; ?>
            </div>
        <?php
        $result = ob_get_contents();
        ob_end_clean();
        $allowed_html = array(
            'a' => array(
                'href' => array (),
                'title' => array ()
            ),
            'i' => array(
                'class' => array()
            ),
            'div' => array(
                'class' => array()
            ),
            'span' => array()
        );
        echo wp_kses( $result, $allowed_html );
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
        
        $html = '<a href="'.esc_url( get_home_url() ).'"><img alt="'.esc_attr( get_bloginfo('name') ).'" src="'.esc_url($default).'" class="_rw" /></a>';
        
        $allowed_html = array(
            'a' => array(
                'href' => array (),
                'title' => array (),
                'class' => array()
            ),
            'img' => array(
                'alt' => array (),
                'src' => array(),
                'class' => array()
            ),
        );
        echo wp_kses( $html, $allowed_html );
    }
}

if( ! function_exists( "kt_get_logo_footer" ) ){
    function kt_get_logo_footer(){
        $default = kt_option("kt_logo_footer" , THEME_URL . 'images/logo.png');
        
        $html = '<a href="' . esc_url( get_home_url('/') ) . '"><img alt="' . esc_attr( get_bloginfo('name')) . '" src="' . esc_url($default) . '" /></a>';
        
        $allowed_html = array(
            'a' => array(
                'href' => array (),
                'title' => array ()
            ),
            'img' => array(
                'alt' => array (),
                'src' => array()
            ),
        );
        echo wp_kses( $html, $allowed_html );
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

if( ! function_exists( 'kt_get_setting_menu' ) ){
    function kt_get_setting_menu(){
        global $kt_enable_vertical_menu;
        $kt_enable_vertical_menu = kt_option( 'kt_enable_vertical_menu', 'enable' );
    }
}
if( ! function_exists( 'kt_get_setting_service_category' ) ){
    function kt_get_setting_service_category(){
        return kt_option( 'kt_service_cate' );
    }
}
kt_get_setting_menu();
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
                    <span><?php esc_html_e( 'My Account', 'kutetheme' ) ?></span>
                </a>
                <ul class="dropdown-menu mega_dropdown" role="menu">
                    <?php if ( ! is_user_logged_in() ):  ?>
                        <?php if( kt_is_wc() ): 
                            $url = get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>
                            <li><a href="<?php echo esc_url( $url ); ?>" title="<?php esc_html_e( 'Login / Register', 'kutetheme' ) ?>"><?php esc_html_e('Login / Register', 'kutetheme'); ?></a></li>
                        <?php else: 
                            $url = wp_login_url();
                            $url_register = wp_registration_url(); ?>
                            <li><a href="<?php echo esc_url( $url ); ?>" title="<?php esc_html_e( 'Login', 'kutetheme' ) ?>"><?php esc_html_e( 'Login', 'kutetheme' ) ?></a></li>
                            <li><a href="<?php echo esc_url( $url_register ); ?>" title="<?php esc_html_e( 'Register', 'kutetheme' ); ?>"><?php esc_html_e( 'Register', 'kutetheme' ); ?></a></li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li><a href="<?php echo esc_url( wp_logout_url() ); ?>"><?php esc_html_e( 'Logout', 'kutetheme' ) ?></a></li>
                        <?php if( function_exists( 'YITH_WCWL' ) ):
                            $wishlist_url = YITH_WCWL()->get_wishlist_url(); ?>
                            <li><a href="<?php echo esc_url( $wishlist_url ); ?>"><?php esc_html_e( 'Wishlists', 'kutetheme' ) ?></a></li>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if(defined( 'YITH_WOOCOMPARE' )): 
                            global $yith_woocompare; 
                            $count = count($yith_woocompare->obj->products_list); ?>
                        <li><a href="#" class="yith-woocompare-open"><?php esc_html_e( "Compare", 'kutetheme') ?><span>(<?php echo esc_attr( $count ); ?>)</span></a></li>
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
        global $kt_used_header;
        
        if( isset( $kt_used_header ) && $kt_used_header ){
            $setting = kt_option('kt_used_header', '1');
            $kt_used_header = intval($setting);
        }
        
        if( kt_is_wc() && $kt_used_header != 5 ){
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
        'prev_text'          => sprintf( '<i class="fa fa-angle-double-left"></i> %1$s', esc_attr__( 'Previous', 'kutetheme' ) ),
        'next_text'          => sprintf( '%1$s <i class="fa fa-angle-double-right"></i>', esc_attr__( 'Next', 'kutetheme' ) ),
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
                <h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'kutetheme' ); ?></h2>
                <div class="nav-links">
                    <?php
                    if ( $prev_link = get_previous_comments_link( esc_html__( 'Older Comments', 'kutetheme' ) ) ) :
                        printf( '<div class="nav-previous">%s</div>', esc_url( $prev_link ) );
                    endif;

                    if ( $next_link = get_next_comments_link( esc_html__( 'Newer Comments',  'kutetheme' ) ) ) :
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
                    <em><?php esc_html_e( 'Your comment is awaiting moderation.', 'kutetheme' ) ?></em>
                <?php endif; ?>
            </div>
            <div class="comment-actions clear">
                <?php edit_comment_link( esc_html__( '(Edit)', 'kutetheme'),'  ','' ) ?>
                <?php comment_reply_link( array_merge( $args,
                    array(
                        'depth'      => $depth,
                        'max_depth'  => $args['max_depth'],
                        'reply_text' =>'<i class="fa fa-share"></i> ' . esc_html__( 'Reply', 'kutetheme' )
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
if( ! function_exists( '_data_carousel' ) ){
    function _data_carousel( $data ){
        $output = "";
        foreach($data as $key => $val){
            if($val){
                $output .= ' data-'.$key.'="'.esc_attr( $val ).'"';
            }
        }
        return $output;
    }
}

/**
 * Convert HEX to RGB.
 *
 * @since Kute Theme 1.0
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */
if( ! function_exists( 'kt_hex2rgb' ) ){
    function kt_hex2rgb( $color ) {
    	$color = trim( $color, '#' );
    
    	if ( strlen( $color ) == 3 ) {
    		$r = hexdec( substr( $color, 0, 1 ).substr( $color, 0, 1 ) );
    		$g = hexdec( substr( $color, 1, 1 ).substr( $color, 1, 1 ) );
    		$b = hexdec( substr( $color, 2, 1 ).substr( $color, 2, 1 ) );
    	} else if ( strlen( $color ) == 6 ) {
    		$r = hexdec( substr( $color, 0, 2 ) );
    		$g = hexdec( substr( $color, 2, 2 ) );
    		$b = hexdec( substr( $color, 4, 2 ) );
    	} else {
    		return array();
    	}
    
    	return array( 'red' => $r, 'green' => $g, 'blue' => $b );
    }
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
if( ! function_exists( 'kt_get_html' ) ){
    function kt_get_html( $html ){
        return balanceTags( $html );
    }
}
if( ! function_exists( 'kt_get_js' ) ) {
    function kt_get_js( $js ){
        return $js;
    }
}
if( ! function_exists( 'kt_get_css' ) ) {
    function kt_get_css( $css ){
        return $css;
    }
}
if( ! function_exists( 'kt_get_str' ) ) {
    function kt_get_str( $str ){
        return $str;
    }
}


// Create custom templates for homopage
add_action( 'vc_load_default_templates_action','kt_add_custom_template_for_vc' ); // Hook in
 
function kt_add_custom_template_for_vc() {
    $data               = array(); // Create new array
    $data['name']       = __( '01 KT Home Style 1', 'kutetheme' ); // Assign name for your custom template
    $data['weight']     = 0; // Weight of your template in the template list
    //$data['image_path'] = get_template_directory_uri()."/images/vc_templates_preview/home1.png"; // Always use preg replace to be sure that "space" will not break logic. Thumbnail should have this dimensions: 114x154px
    $data['custom_class'] = 'custom_template_for_vc_custom_template'; // CSS class name
    $data['content']    = <<<CONTENT
        [vc_row css=".vc_custom_1447052201051{margin-right: 0px !important;margin-left: 0px !important;}"][vc_column css=".vc_custom_1447055532117{padding-right: 0px !important;padding-left: 0px !important;}" offset="vc_col-lg-3 vc_col-md-3 vc_hidden-md vc_hidden-sm vc_hidden-xs"][vc_column_text]
[/vc_column_text][/vc_column][vc_column css=".vc_custom_1447055111712{margin-left: 0px !important;padding-right: 0px !important;padding-left: 0px !important;}" el_class="home1-slider" offset="vc_col-lg-7 vc_col-md-9"][/vc_column][vc_column width="1/4" css=".vc_custom_1447055125365{padding-right: 0px !important;padding-left: 0px !important;}" offset="vc_col-lg-2 vc_col-md-3 vc_hidden-sm vc_hidden-xs"][vc_single_image source="external_link" onclick="custom_link" link="#" el_class="banner-opacity" custom_src="http://kutethemes.net/demo-images/kuteshop/P11.jpg"][/vc_column][/vc_row][vc_row css=".vc_custom_1440040640375{margin-top: -15px !important;}"][vc_column][service title="FREE SHIPPING" subtitle="On order over $200" icon="537" href="#"][/vc_column][/vc_row][vc_row][vc_column width="2/3" offset="vc_col-lg-9 vc_col-md-9"][tab_producs per_page="5" columns="4" use_responsive="1"][/vc_column][vc_column width="1/3" offset="vc_col-lg-3 vc_col-md-3"][lastest_deals_sidebar number="3" orderby="name" title="Latest deals"][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1440045151377{margin-bottom: 30px !important;padding-bottom: 30px !important;background-color: #eaeaea !important;}"][vc_column][categories_tab per_page="5" number_column="4" featured="yes" loop="true" use_responsive="1" items_tablet="3" category="-1" icon="348" banner_top="349,350" banner_left="351" title="Fashion"][tab_section header="Best Sellers"][tab_section section_type="custom" orderby="rand" header="Specials"][tab_section section_type="most-review"][tab_section section_type="new-arrival" header="New Arrivals"][tab_section section_type="category" orderby="name" header="Women" section_cate="97"][/categories_tab][categories_tab per_page="5" number_column="4" featured="yes" loop="true" use_responsive="1" items_tablet="3" category="110" main_color="#339966" icon="471" banner_top="470,469" banner_left="472" title="SPORTS"][tab_section header="Best Sellers"][tab_section section_type="most-review"][tab_section section_type="category" section_cate="141" header="Tennis"][tab_section section_type="category" orderby="rand" section_cate="127" header="Football"][tab_section section_type="category" orderby="author" section_cate="140" header="Swimming"][tab_section section_type="category" orderby="ID" section_cate="124" header="Climbing"][/categories_tab][categories_tab per_page="5" number_column="4" featured="yes" loop="true" use_responsive="1" items_tablet="3" category="87" main_color="#ff6633" icon="476" banner_top="477,478" banner_left="479" title="ELECTRONIC"][tab_section header="Best Sellers"][tab_section section_type="most-review"][tab_section section_type="category" section_cate="76" header="Television"][tab_section section_type="category" orderby="author" section_cate="117" header="Air Conditional"][tab_section section_type="category" orderby="name" section_cate="118" header="ARM"][tab_section section_type="category" orderby="rand" section_cate="142" header="Theater"][/categories_tab][categories_tab per_page="5" number_column="4" featured="yes" loop="true" use_responsive="1" items_tablet="3" title="DIGITAL" category="82" main_color="#3366cc" icon="482" banner_top="483,484" banner_left="485"][tab_section header="Best Sellers"][tab_section section_type="most-review"][tab_section section_type="category" section_cate="134" header="Mobile"][tab_section section_type="category" section_cate="121" header="Camera"][tab_section section_type="category" orderby="rand" section_cate="132" header="Laptop"][tab_section section_type="category" orderby="name" section_cate="136" header="Notebook"][/categories_tab][categories_tab per_page="5" number_column="4" featured="yes" loop="true" use_responsive="1" items_tablet="3" title="FURNITURE" category="99" main_color="#669900" icon="489" banner_top="490,491" banner_left="492"][tab_section header="Best Sellers"][tab_section section_type="most-review"][tab_section section_type="category" section_cate="120" header="Bedding"][tab_section section_type="category" orderby="name" section_cate="137" header="Office Funiture"][tab_section section_type="category" orderby="ID" section_cate="123" header="Chair &amp; Recliners"][tab_section section_type="category" section_cate="133" header="Loveseats"][/categories_tab][categories_tab per_page="5" number_column="4" featured="yes" loop="true" use_responsive="1" items_tablet="3" title="Jewelry" category="109" main_color="#6c6856" icon="498" banner_top="499,500" banner_left="501"][tab_section header="Best Sellers"][tab_section section_type="most-review"][tab_section section_type="category" section_cate="139" header="Pearl Jewelry"][tab_section section_type="category" orderby="name" section_cate="128" header="Gold Jewelry"][tab_section section_type="category" orderby="ID" section_cate="125" header="Diamond Jewelry"][tab_section section_type="category" orderby="rand" section_cate="116" header="Accessories"][/categories_tab][vc_row_inner css=".vc_custom_1440044343592{margin-top: 30px !important;}"][vc_column_inner width="1/2"][vc_single_image image="503" img_size="full" onclick="custom_link" link="#" el_class="banner-boder-zoom"][/vc_column_inner][vc_column_inner width="1/2"][vc_single_image image="504" img_size="full" onclick="custom_link" link="#" el_class="banner-boder-zoom"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row css=".vc_custom_1440053507110{margin-bottom: 0px !important;}"][vc_column][brand margin="1" use_responsive="1" title="BRAND SHOWCASE"][/vc_column][/vc_row][vc_row css=".vc_custom_1441943542187{margin-bottom: 0px !important;}"][vc_column][vc_column_text]
[/vc_column_text][categories taxonomy="" number="4" title="Hot category" css=".vc_custom_1447148949511{margin-top: 30px !important;}"][/vc_column][/vc_row]
CONTENT;
  
    vc_add_default_templates( $data );

    $data               = array(); // Create new array
    $data['name']       = __( '02 KT Home Style 2', 'kutetheme' ); // Assign name for your custom template
    $data['weight']     = 0; // Weight of your template in the template list
    //$data['image_path'] = get_template_directory_uri()."/images/vc_templates_preview/home2.png"; // Always use preg replace to be sure that "space" will not break logic. Thumbnail should have this dimensions: 114x154px
    $data['custom_class'] = 'custom_template_for_vc_custom_template'; // CSS class name
    $data['content']    = <<<CONTENT
        [vc_row][vc_column css=".vc_custom_1442392234420{padding-right: 0px !important;}" offset="vc_col-lg-3 vc_col-md-3 vc_hidden-xs"][vc_column_text]
[/vc_column_text][/vc_column][vc_column css=".vc_custom_1442392224357{margin-left: -15px !important;padding-right: 0px !important;padding-left: 0px !important;}" offset="vc_col-lg-9 vc_col-md-9" el_class="home1-slider"][rev_slider_vc alias="slider2"][/vc_column][/vc_row][vc_row][vc_column][lastest_deal_products taxonomy="134" number="6" product_column="5" order="ASC" navigation="true" loop="true" margin="10" use_responsive="1" items_destop="5" items_tablet="3" title="LATEST DEALS"][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1440045151377{margin-bottom: 30px !important;padding-bottom: 30px !important;background-color: #eaeaea !important;}"][vc_column][categories_tab per_page="6" number_column="4" tabs_type="tab-2" category="70" icon="1035" banner_left="1036" title="Fashion" main_color="#ff3366"][tab_section section_type="by-ids" header="Best Sellers" ids="109,119,202,142,186,268"][tab_section section_type="custom" orderby="author" header="Specials"][tab_section section_type="new-arrival" header="New Arrivals"][tab_section section_type="most-review" header="Most Reviews"][/categories_tab][categories_tab per_page="6" number_column="4" tabs_type="tab-3" title="SPORTS" category="116" main_color="#00a360" icon="1476" banner_left="1041,1072"][tab_section header="Best Sellers"][tab_section section_type="custom" orderby="name" header="Specials"][tab_section section_type="new-arrival" header="New Arrivals"][tab_section section_type="most-review" header="Most Reviews"][/categories_tab][categories_tab per_page="6" number_column="4" tabs_type="tab-2" category="68" main_color="#0090c9" icon="1043" banner_left="1044" title="ELECTRONIC"][tab_section section_type="by-ids" header="Best Sellers" ids="310,1069,304,298,300,311"][tab_section section_type="custom" orderby="author" header="Specials"][tab_section section_type="new-arrival" header="New Arrivals"][tab_section section_type="most-review" header="Most Reviews"][/categories_tab][categories_tab per_page="8" number_column="4" tabs_type="tab-4" title="DIGITAL" category="67" main_color="#3f5eca" icon="1046" banner_left="1049,1051,1052,1053,1054,1055,1048,1056"][tab_section section_type="by-ids" header="Best Sellers" ids="1091,320,324,327,987,312,323,1088"][tab_section section_type="custom" orderby="ID" header="Specials"][tab_section section_type="new-arrival" header="New Arrivals"][tab_section section_type="most-review" header="Most Reviews"][/categories_tab][categories_tab per_page="10" number_column="4" tabs_type="tab-2" title="FURNITURE" category="73" main_color="#669900" icon="1057" banner_left="1058"][tab_section section_type="by-ids" header="Best Sellers" ids="360,336,1096,1094,331,341"][tab_section section_type="custom" orderby="author" header="Specials"][tab_section section_type="new-arrival" header="New Arrivals"][tab_section section_type="most-review" header="Most Reviews"][/categories_tab][categories_tab per_page="8" number_column="4" tabs_type="tab-5" title="Jewelry" category="81" main_color="#6d6855" icon="1071" banner_left="1072,1073"][tab_section section_type="by-ids" header="Best Sellers" ids="1083,342,354,1076,1078,1080,1455,355"][tab_section section_type="custom" orderby="author" header="Specials"][tab_section section_type="new-arrival" header="New Arrivals"][tab_section section_type="most-review" header="Most Review"][/categories_tab][/vc_column][/vc_row][vc_row css=".vc_custom_1441276262174{margin-bottom: 0px !important;}"][vc_column width="1/2" css=".vc_custom_1442391401686{padding-right: 0px !important;}" offset="vc_hidden-sm vc_hidden-xs"][vc_single_image image="1117" img_size="full" onclick="custom_link" el_class="banner-boder-zoom" css=".vc_custom_1444300223355{padding-right: 0px !important;}" link="#"][/vc_column][vc_column width="1/2" css=".vc_custom_1442391392743{padding-left: 0px !important;}" offset="vc_hidden-sm vc_hidden-xs"][vc_single_image image="1108" img_size="full" onclick="custom_link" el_class="banner-boder-zoom" css=".vc_custom_1444300237691{padding-left: 0px !important;}" link="#"][/vc_column][/vc_row][vc_row css=".vc_custom_1441276296472{margin-top: 0px !important;}"][vc_column][blog_carousel per_page="08" autoplay="true" margin="30" title="FROM THE BLOG"][/vc_column][/vc_row][vc_row css=".vc_custom_1441276287576{margin-bottom: 30px !important;}"][vc_column][service items="6" style="2"][/vc_column][/vc_row]
CONTENT;
  
    vc_add_default_templates( $data );


    $data               = array(); // Create new array
    $data['name']       = __( '03 KT Home Style 3', 'kutetheme' ); // Assign name for your custom template
    $data['weight']     = 0; // Weight of your template in the template list
    //$data['image_path'] = get_template_directory_uri()."/images/vc_templates_preview/home2.png"; // Always use preg replace to be sure that "space" will not break logic. Thumbnail should have this dimensions: 114x154px
    $data['custom_class'] = 'custom_template_for_vc_custom_template'; // CSS class name
    $data['content']    = <<<CONTENT
        [vc_row full_width="stretch_row" css=".vc_custom_1445419716713{margin-top: 0px !important;margin-right: 0px !important;margin-bottom: 0px !important;margin-left: 0px !important;background-color: #eeeeee !important;}"][vc_column css=".vc_custom_1445415331602{padding-right: 0px !important;padding-left: 0px !important;}" offset="vc_col-lg-3 vc_col-md-12 vc_hidden-md vc_hidden-sm vc_hidden-xs"][/vc_column][vc_column css=".vc_custom_1445415360072{padding-right: 0px !important;padding-left: 0px !important;}" offset="vc_col-lg-7 vc_col-md-9"][rev_slider_vc alias="kute-opt3"][/vc_column][vc_column css=".vc_custom_1445415565423{padding-right: 0px !important;padding-left: 0px !important;background-color: #ffffff !important;}" offset="vc_col-lg-2 vc_col-md-3 vc_hidden-sm vc_hidden-xs"][kt_featured_products title="Trending"][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1445419744266{margin-bottom: 0px !important;border-top-width: 0px !important;border-right-width: 0px !important;border-bottom-width: 1px !important;border-left-width: 0px !important;background-color: #f6f6f6 !important;border-left-color: #eaeaea !important;border-left-style: solid !important;border-right-color: #eaeaea !important;border-right-style: solid !important;border-top-color: #eaeaea !important;border-top-style: solid !important;border-bottom-color: #eaeaea !important;border-bottom-style: solid !important;}"][vc_column][service items="4" style="1" hide_border="yes"][/vc_column][/vc_row][vc_row css=".vc_custom_1445307278259{margin-top: 0px !important;margin-bottom: 0px !important;}"][vc_column][hot_deal per_page="8" taxonomy="204,199" orderby="ID" loop="true" use_responsive="1" title="Hot deals"][tab_sections reduction_from="31" reduction_to="70" header="Up to 40% off"][tab_sections reduction_from="29" reduction_to="21" header="Up to 30% off"][tab_sections reduction_from="11" reduction_to="19" header="Up to 20% off"][tab_sections reduction_from="9" reduction_to="1" header="Up to 10% off"][tab_sections reduction_from="1" reduction_to="5" header="Up to 5% off"][/hot_deal][/vc_column][/vc_row][vc_row css=".vc_custom_1445388472049{margin-top: 0px !important;margin-bottom: 0px !important;}"][vc_column][box_products type="most-review" taxonomy="203,90,89" per_page="4" autoplay="false" use_responsive="1" title="NEW ARRIVALS IN" banner="2223,2295" main_color="#ff3300"][box_products taxonomy="203,90,89" per_page="4" autoplay="false" use_responsive="1" title="TOP SELLERS IN" banner="2295,2223" css=".vc_custom_1445419945930{margin-bottom: 0px !important;}" main_color="#ffcc00"][/vc_column][/vc_row][vc_row css=".vc_custom_1445388657109{margin-right: -5px !important;margin-bottom: 0px !important;margin-left: -5px !important;}"][vc_column][vc_row_inner][vc_column_inner width="1/2" css=".vc_custom_1445388715759{margin-top: 30px !important;padding-right: 5px !important;padding-left: 5px !important;}"][vc_single_image image="2232" img_size="full" onclick="custom_link" link="#" el_class="banner-opacity"][/vc_column_inner][vc_column_inner width="1/2" css=".vc_custom_1445388724615{margin-top: 30px !important;padding-right: 5px !important;padding-left: 5px !important;}"][vc_single_image image="2233" img_size="full" onclick="custom_link" link="#" el_class="banner-opacity"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row css=".vc_custom_1445261355462{margin-top: 0px !important;margin-bottom: 0px !important;}"][vc_column][box_products type="recent-product" taxonomy="204,205,199" per_page="4" autoplay="false" use_responsive="1" title="SPECIAL PRODUCTS" banner="2234,2223" main_color="#009966"][/vc_column][/vc_row][vc_row css=".vc_custom_1445261764943{margin-top: 0px !important;margin-bottom: 0px !important;}"][vc_column css=".vc_custom_1445261556192{margin-top: 0px !important;margin-bottom: 0px !important;}"][box_products type="recent-product" taxonomy="204,201,199" per_page="5" autoplay="false" use_responsive="1" title="RECOMMENDATION FOR YOU" banner="2299,2295" main_color="#ff66cc"][/vc_column][/vc_row][vc_row css=".vc_custom_1445328453978{margin-top: -15px !important;margin-bottom: -15px !important;}"][vc_column css=".vc_custom_1445261530379{margin-top: 0px !important;}"][blog_carousel per_page="10" margin="30" use_responsive="1" title="FROM THE BLOG"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );


    $data               = array(); // Create new array
    $data['name']       = __( '04 KT Home Style 4', 'kutetheme' ); // Assign name for your custom template
    $data['weight']     = 0; // Weight of your template in the template list
    //$data['image_path'] = get_template_directory_uri()."/images/vc_templates_preview/home2.png"; // Always use preg replace to be sure that "space" will not break logic. Thumbnail should have this dimensions: 114x154px
    $data['custom_class'] = 'custom_template_for_vc_custom_template'; // CSS class name
    $data['content']    = <<<CONTENT
        [vc_row css=".vc_custom_1447057565254{margin-right: 0px !important;margin-bottom: 0px !important;margin-left: 0px !important;}"][vc_column css=".vc_custom_1447057575763{padding-right: 0px !important;padding-left: 0px !important;}" offset="vc_col-lg-3 vc_col-md-3 vc_hidden-xs"][vc_column_text]
[/vc_column_text][/vc_column][vc_column css=".vc_custom_1447057596307{padding-top: 10px !important;padding-right: 0px !important;padding-left: 10px !important;}" el_class="home1-slider" offset="vc_col-lg-9 vc_col-md-9"][rev_slider_vc alias="kute-opt4"][/vc_column][/vc_row][vc_row css=".vc_custom_1446620667454{margin-right: -5px !important;margin-bottom: 25px !important;margin-left: -5px !important;}"][vc_column width="1/2" css=".vc_custom_1446620677547{margin-top: 30px !important;padding-right: 5px !important;padding-left: 5px !important;}"][vc_single_image image="2469" img_size="full"][/vc_column][vc_column width="1/2" css=".vc_custom_1446620687693{margin-top: 30px !important;padding-right: 5px !important;padding-left: 5px !important;}"][vc_single_image image="2470" img_size="full"][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1445401650330{margin-bottom: 0px !important;background-color: #eaeaea !important;}"][vc_column][hot_deal per_page="5" style="style-2" taxonomy="102" orderby="ID" loop="true" use_responsive="1" title="Hot deal"][tab_sections reduction_from="31" reduction_to="70" header="Up to 40% off"][tab_sections reduction_from="21" reduction_to="29" header="Up to 30% off"][tab_sections reduction_from="11" reduction_to="19" header="Up to 20% off"][tab_sections reduction_from="1" reduction_to="9" header="Up to 10% off"][tab_sections reduction_from="1" reduction_to="5" header="Up to 5% off"][/hot_deal][box_products type="recent-product" style="style-2" taxonomy="189,80,190" per_page="4" use_responsive="1" title="NEW ARRIVALS IN" banner="2435,2436" main_color="#ff3300"][vc_row_inner css=".vc_custom_1445389582947{margin-bottom: 0px !important;background-color: #eaeaea !important;}"][vc_column_inner][box_products type="most-review" style="style-2" taxonomy="189,80,190" per_page="4" use_responsive="1" title="TOP SELLERS IN" banner="2436,2435" main_color="#ffcc00"][/vc_column_inner][/vc_row_inner][vc_row_inner css=".vc_custom_1445389480958{margin-right: -5px !important;margin-bottom: 0px !important;margin-left: -5px !important;background-color: #eaeaea !important;}"][vc_column_inner width="1/2" css=".vc_custom_1445389496816{margin-top: 30px !important;padding-right: 5px !important;padding-left: 5px !important;}"][vc_single_image image="2439" img_size="full"][/vc_column_inner][vc_column_inner width="1/2" css=".vc_custom_1445389511895{margin-top: 30px !important;padding-right: 5px !important;padding-left: 5px !important;}"][vc_single_image image="2440" img_size="full"][/vc_column_inner][/vc_row_inner][vc_row_inner css=".vc_custom_1445311890780{margin-top: 0px !important;margin-bottom: 0px !important;}"][vc_column_inner][box_products type="most-review" style="style-2" taxonomy="191,192,102" per_page="4" use_responsive="1" title="SPECIAL PRODUCTS" banner="2437,2436" main_color="#009966"][/vc_column_inner][/vc_row_inner][vc_row_inner css=".vc_custom_1445312172457{margin-top: 0px !important;margin-bottom: 0px !important;padding-bottom: 30px !important;}"][vc_column_inner][box_products type="recent-product" style="style-2" taxonomy="191,188,102" per_page="5" use_responsive="1" title="RECOMMENDATION FOR YOU" banner="2438,2435" main_color="#ff66cc"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row css=".vc_custom_1445388045223{margin-top: 15px !important;margin-bottom: -5px !important;}"][vc_column css=".vc_custom_1445312243121{margin-top: -15px !important;margin-bottom: -15px !important;}"][blog_carousel per_page="10" margin="30" use_responsive="1" title="FROM THE BLOG"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

        $data               = array(); // Create new array
    $data['name']       = __( '05 KT Home Style 5', 'kutetheme' ); // Assign name for your custom template
    $data['weight']     = 0; // Weight of your template in the template list
    //$data['image_path'] = get_template_directory_uri()."/images/vc_templates_preview/home2.png"; // Always use preg replace to be sure that "space" will not break logic. Thumbnail should have this dimensions: 114x154px
    $data['custom_class'] = 'custom_template_for_vc_custom_template'; // CSS class name
    $data['content']    = <<<CONTENT
        [vc_row][vc_column][rev_slider_vc alias="kute-opt5"][/vc_column][/vc_row][vc_row css=".vc_custom_1444187679593{margin-bottom: 0px !important;}"][vc_column][lastest_deal_products taxonomy="281" number="12" product_column="3" autoplay="true" loop="true" use_responsive="1" items_destop="5" items_tablet="3" title="Latest Deals"][/vc_column][/vc_row][vc_row css=".vc_custom_1444187630969{margin-top: 0px !important;}"][vc_column width="1/2" css=".vc_custom_1441359903327{margin-top: 30px !important;padding-right: 0px !important;}" el_class="banner-custom"][vc_single_image image="1525" img_size="full" onclick="custom_link" el_class=" banner-boder-zoom2" link="#"][/vc_column][vc_column width="1/2" css=".vc_custom_1441359896071{margin-top: 30px !important;padding-left: 0px !important;}" el_class="banner-custom"][vc_single_image image="1526" img_size="full" onclick="custom_link" el_class=" banner-boder-zoom2" link="#"][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1440045151377{margin-bottom: 30px !important;padding-bottom: 30px !important;background-color: #eaeaea !important;}"][vc_column][categories_tab per_page="6" number_column="4" tabs_type="tab-2" category="90" icon="1035" banner_left="1471" title="Fashion" main_color="#ff3366"][tab_section section_type="by-ids" header="Best Sellers" ids="130,119,202,227,208,142"][tab_section section_type="custom" orderby="author" header="Specials"][tab_section section_type="new-arrival" header="New Arrivals"][tab_section section_type="most-review" header="Most Reviews"][/categories_tab][categories_tab per_page="6" number_column="4" tabs_type="tab-2" title="SPORTS" category="135" main_color="#00a360" icon="1515" banner_left="1473"][tab_section header="Best Sellers"][tab_section section_type="custom" orderby="name" header="Specials"][tab_section section_type="new-arrival" header="New Arrivals"][tab_section section_type="most-review" header="Most Reviews"][/categories_tab][categories_tab per_page="6" number_column="4" tabs_type="tab-2" category="89" main_color="#0090c9" icon="1043" banner_left="1474" title="Electronic" bg_cate="1475"][tab_section section_type="by-ids" header="Best Sellers" ids="310,1069,304,298,300,311"][tab_section section_type="custom" orderby="author" header="Specials"][tab_section section_type="new-arrival" header="New Arrivals"][tab_section section_type="most-review" header="Most Reviews"][/categories_tab][categories_tab per_page="6" number_column="4" tabs_type="tab-2" title="DIGITAL" category="88" main_color="#3f5eca" icon="1046" banner_left="1477" bg_cate="1476"][tab_section section_type="by-ids" header="Best Sellers" ids="987,323,312,324,320,1091"][tab_section section_type="custom" orderby="ID" header="Specials"][tab_section section_type="new-arrival" header="New Arrivals"][tab_section section_type="most-review" header="Most Reviews"][/categories_tab][categories_tab per_page="6" number_column="4" tabs_type="tab-2" title="FURNITURE" category="93" main_color="#669900" icon="1057" banner_left="1479" bg_cate="1478"][tab_section section_type="by-ids" header="Best Sellers" ids="360,336,1096,341,1094,331"][tab_section section_type="custom" orderby="author" header="Specials"][tab_section section_type="new-arrival" header="New Arrivals"][tab_section section_type="most-review" header="Most Reviews"][/categories_tab][categories_tab per_page="6" number_column="4" tabs_type="tab-2" title="Jewelry" category="101" main_color="#6d6855" icon="1071" banner_left="1480"][tab_section section_type="by-ids" header="Best Sellers" ids="342,354,1080,1083,1078,1076"][tab_section section_type="custom" orderby="author" header="Specials"][tab_section section_type="new-arrival" header="New Arrivals"][tab_section section_type="most-review" header="Most Review"][/categories_tab][/vc_column][/vc_row][vc_row css=".vc_custom_1444188342432{margin-top: 0px !important;margin-bottom: 0px !important;}"][vc_column][brand show_product="" autoplay="true" margin="1.5" items_tablet="5" items_mobile="2"][blog_carousel per_page="07" autoplay="true" margin="30" use_responsive="1" items_tablet="3" title="FROM THE BLOG" css=".vc_custom_1444188324832{margin-bottom: 0px !important;}"][/vc_column][/vc_row][vc_row css=".vc_custom_1444188354991{margin-top: 0px !important;}"][vc_column][service items="6" style="2"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

        $data               = array(); // Create new array
    $data['name']       = __( '06 KT Home Style 6', 'kutetheme' ); // Assign name for your custom template
    $data['weight']     = 0; // Weight of your template in the template list
    //$data['image_path'] = get_template_directory_uri()."/images/vc_templates_preview/home2.png"; // Always use preg replace to be sure that "space" will not break logic. Thumbnail should have this dimensions: 114x154px
    $data['custom_class'] = 'custom_template_for_vc_custom_template'; // CSS class name
    $data['content']    = <<<CONTENT
        [vc_row css=".vc_custom_1441275179726{margin-bottom: 0px !important;}"][vc_column width="2/3" el_class="home-slider-6"][rev_slider_vc alias="slider6"][/vc_column][vc_column width="1/6" el_class="group-banner-slider1"][vc_single_image image="1530" img_size="full" onclick="custom_link" el_class="banner-opacity" link="#"][vc_single_image image="1531" img_size="full" onclick="custom_link" el_class="banner-opacity" link="#"][vc_single_image image="1532" img_size="full" onclick="custom_link" el_class="banner-opacity" link="#"][/vc_column][vc_column width="1/6" el_class="group-banner-slider2 banner-opacity"][vc_single_image image="1590" img_size="full" onclick="custom_link" el_class="banner-opacity" link="#"][vc_single_image image="1533" img_size="full" onclick="custom_link" el_class="banner-opacity" link="#"][vc_single_image image="1565" img_size="full" onclick="custom_link" el_class="banner-opacity" link="#"][/vc_column][/vc_row][vc_row css=".vc_custom_1441273301771{margin-bottom: 0px !important;}"][vc_column width="1/3" css=".vc_custom_1441273277654{margin-top: 30px !important;}"][popular_category taxonomy="76" per_page="5" title="HEALTH &amp; BEAUTY"][/vc_column][vc_column width="1/3" css=".vc_custom_1441275290173{margin-top: 30px !important;}"][popular_category taxonomy="109" per_page="5" title="SHOES &amp; ACCESSORIES"][/vc_column][vc_column width="1/3" css=".vc_custom_1441273293342{margin-top: 30px !important;}"][popular_category taxonomy="82" per_page="5" title="JEWELLRY &amp; WATCHES"][/vc_column][/vc_row][vc_row][vc_column width="1/2" css=".vc_custom_1441359903327{margin-top: 30px !important;padding-right: 0px !important;}" el_class="banner-custom"][vc_single_image image="1525" img_size="full" onclick="custom_link" el_class="banner-boder-zoom2" link="#"][/vc_column][vc_column width="1/2" css=".vc_custom_1441359896071{margin-top: 30px !important;padding-left: 0px !important;}" el_class="banner-custom"][vc_single_image image="1526" img_size="full" onclick="custom_link" el_class=" banner-boder-zoom2" link="#"][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1440045151377{margin-bottom: 30px !important;padding-bottom: 30px !important;background-color: #eaeaea !important;}"][vc_column][categories_tab per_page="6" number_column="4" tabs_type="tab-2" category="70" icon="1035" banner_left="1471" title="Fashion" main_color="#ff3366"][tab_section section_type="by-ids" header="Best Sellers" ids="109,119,130,202,142,208"][tab_section section_type="custom" orderby="author" header="Specials"][tab_section section_type="new-arrival" header="New Arrivals"][tab_section section_type="most-review" header="Our Picked"][/categories_tab][categories_tab per_page="6" number_column="4" tabs_type="tab-2" title="SPORTS" category="116" main_color="#00a360" icon="1515" banner_left="1473"][tab_section header="Best Sellers"][tab_section section_type="custom" orderby="name" header="Specials"][tab_section section_type="new-arrival" header="New Arrivals"][tab_section section_type="most-review" header="Most Reviews"][/categories_tab][categories_tab per_page="6" number_column="4" tabs_type="tab-2" category="68" main_color="#0090c9" icon="1043" banner_left="1474" title="ELECTronic" bg_cate="1475"][tab_section section_type="by-ids" header="Best Sellers" ids="310,1069,304,298,300,311"][tab_section section_type="custom" orderby="author" header="Specials"][tab_section section_type="new-arrival" header="New Arrivals"][tab_section section_type="most-review" header="Most Reviews"][/categories_tab][categories_tab per_page="6" number_column="4" tabs_type="tab-2" title="DIGITAL" category="67" main_color="#3f5eca" icon="1046" banner_left="1477" bg_cate="1476"][tab_section section_type="by-ids" header="Best Sellers" ids="987,323,312,1091,320,324"][tab_section section_type="custom" orderby="ID" header="Specials"][tab_section section_type="new-arrival" header="New Arrivals"][tab_section section_type="most-review" header="Most Reviews"][/categories_tab][categories_tab per_page="6" number_column="4" tabs_type="tab-2" title="FURNITURE" category="73" main_color="#669900" icon="1057" banner_left="1479" bg_cate="1478"][tab_section section_type="by-ids" header="Best Sellers" ids="360,336,1096,1094,341,331"][tab_section section_type="custom" orderby="author" header="Specials"][tab_section section_type="new-arrival" header="New Arrivals"][tab_section section_type="most-review" header="Most Reviews"][/categories_tab][categories_tab per_page="6" number_column="4" tabs_type="tab-2" title="Jewelry" category="81" main_color="#6d6855" icon="1071" banner_left="1480"][tab_section section_type="by-ids" header="Best Sellers" ids="342,354,1080,1083,1078,1076"][tab_section section_type="custom" orderby="author" header="Specials"][tab_section section_type="new-arrival" header="New Arrivals"][tab_section section_type="most-review" header="Most Review"][/categories_tab][/vc_column][/vc_row][vc_row css=".vc_custom_1441245562261{margin-top: 0px !important;}"][vc_column][brand show_product="" autoplay="true" margin="1.5" items_tablet="5" items_mobile="2"][blog_carousel per_page="07" autoplay="true" margin="30" items_tablet="3" title="FROM THE BLOG"][/vc_column][/vc_row][vc_row][vc_column][service items="6" style="2"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    $data               = array(); // Create new array
    $data['name']       = __( '07 KT Home Style 7', 'kutetheme' ); // Assign name for your custom template
    $data['weight']     = 0; // Weight of your template in the template list
    //$data['image_path'] = get_template_directory_uri()."/images/vc_templates_preview/home2.png"; // Always use preg replace to be sure that "space" will not break logic. Thumbnail should have this dimensions: 114x154px
    $data['custom_class'] = 'custom_template_for_vc_custom_template'; // CSS class name
    $data['content']    = <<<CONTENT
        [vc_row css=".vc_custom_1447058709986{margin-top: 10px !important;margin-right: 0px !important;margin-bottom: 30px !important;margin-left: 0px !important;}"][vc_column width="1/4" css=".vc_custom_1447058723346{padding-right: 0px !important;padding-left: 0px !important;}"][/vc_column][vc_column width="3/4" css=".vc_custom_1447058782465{margin-left: 0px !important;padding-right: 0px !important;padding-left: 10px !important;}"][rev_slider_vc alias="kute-opt71"][/vc_column][/vc_row][vc_row css=".vc_custom_1446025042015{margin-right: 0px !important;margin-bottom: 0px !important;margin-left: 0px !important;}"][vc_column width="1/2" css=".vc_custom_1446001391524{padding-right: 0px !important;padding-left: 0px !important;}"][vc_single_image image="2405" img_size="full" onclick="custom_link" el_class="banner-opacity" link="#" css=".vc_custom_1446024644250{margin-bottom: 10px !important;}"][/vc_column][vc_column width="1/2" css=".vc_custom_1446001412652{padding-right: 0px !important;padding-left: 0px !important;}"][vc_single_image image="2406" img_size="full" onclick="custom_link" el_class="banner-opacity" link="#" css=".vc_custom_1446024657354{margin-bottom: 30px !important;}"][/vc_column][/vc_row][vc_row css=".vc_custom_1446025118106{margin-bottom: 30px !important;}"][vc_column][box_hot_deal per_page="5" taxonomy="189" orderby="name" order="ASC" use_responsive="1" title="Hot Deals"][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1446018020222{margin-bottom: 0px !important;padding-bottom: 30px !important;background-color: #eaeaea !important;}"][vc_column][categories_tab per_page="8" number_column="4" tabs_type="tab-6" category="48" banner_left="2380" title="Fashion" main_color="#f7a61b" icon="2394"][tab_section header="Best Sellers"][tab_section section_type="custom" orderby="author" header="Specials"][tab_section section_type="new-arrival" header="New Arrivals"][tab_section section_type="most-review" header="Most Reviews"][/categories_tab][categories_tab per_page="8" number_column="4" tabs_type="tab-6" align="right" title="SPORTS" category="73" main_color="#7cbf42" icon="2393" banner_left="2382"][tab_section header="Best Sellers"][tab_section section_type="custom" orderby="name" header="Specials"][tab_section section_type="new-arrival" header="New Arrivals"][tab_section section_type="most-review" header="Most Reviews"][/categories_tab][categories_tab per_page="8" number_column="4" tabs_type="tab-6" category="47" main_color="#eb4a24" icon="2392" banner_left="2385" title="ELECTRONIC"][tab_section header="Best Sellers"][tab_section section_type="custom" orderby="author" header="Specials"][tab_section section_type="new-arrival" header="New Arrivals"][tab_section section_type="most-review" header="Most Reviews"][/categories_tab][categories_tab per_page="8" number_column="4" tabs_type="tab-6" align="right" title="DIGITAL" category="46" main_color="#34a8c8" icon="2391" banner_left="2386"][tab_section header="Best Sellers"][tab_section section_type="custom" orderby="ID" header="Specials"][tab_section section_type="new-arrival" header="New Arrivals"][tab_section section_type="most-review" header="Most Reviews"][/categories_tab][categories_tab per_page="8" number_column="4" tabs_type="tab-6" title="FURNITURE" category="51" main_color="#30a443" icon="2390" banner_left="2387"][tab_section header="Best Sellers"][tab_section section_type="custom" orderby="author" header="Specials"][tab_section section_type="new-arrival" header="New Arrivals"][tab_section section_type="most-review" header="Most Reviews"][/categories_tab][categories_tab per_page="8" number_column="4" tabs_type="tab-6" align="right" title="Jewelry" category="55" main_color="#afc387" icon="2388" banner_left="2389"][tab_section header="Best Sellers"][tab_section section_type="custom" orderby="author" header="Specials"][tab_section section_type="new-arrival" header="New Arrivals"][tab_section section_type="most-review" header="Most Review"][/categories_tab][/vc_column][/vc_row][vc_row css=".vc_custom_1446025948438{margin-top: 0px !important;margin-bottom: 30px !important;}"][vc_column css=".vc_custom_1444123750998{margin-bottom: 0px !important;}"][blog_carousel style="style-2" per_page="08" autoplay="true" margin="30" use_responsive="1" title="FROM THE BLOG" css=".vc_custom_1446026233942{padding-bottom: 0px !important;}"][/vc_column][/vc_row][vc_row css=".vc_custom_1446605142594{margin-top: 0px !important;margin-bottom: 45px !important;}"][vc_column][brand show_product="false" line_brand="2-line" order="ASC" margin="1.2" use_responsive="1" title="BRAND SHOWCASE" css=".vc_custom_1446083384472{margin-top: 0px !important;}"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    // Option 8
    $data               = array(); // Create new array
    $data['name']       = __( '08 KT Home Style 8', 'kutetheme' ); // Assign name for your custom template
    $data['weight']     = 0; // Weight of your template in the template list
    //$data['image_path'] = get_template_directory_uri()."/images/vc_templates_preview/home2.png"; // Always use preg replace to be sure that "space" will not break logic. Thumbnail should have this dimensions: 114x154px
    $data['custom_class'] = 'custom_template_for_vc_custom_template'; // CSS class name
    $data['content']    = <<<CONTENT
        [vc_row css=".vc_custom_1447729866431{margin-bottom: 0px !important;}"][vc_column][rev_slider_vc alias="slide-8"][/vc_column][/vc_row][vc_row css=".vc_custom_1447809127034{margin-bottom: 0px !important;}"][vc_column width="1/3"][vc_single_image image="2048" img_size="full" css=".vc_custom_1448264739093{margin-top: 30px !important;}"][/vc_column][vc_column width="1/3"][kt_banner_text title="For women" sub_title="Deals Shop Always Open" button_text="Shop now" link="#" el_class="xxxxxx" img="2050" css=".vc_custom_1448264752941{margin-top: 30px !important;}"][/vc_column][vc_column width="1/3"][kt_banner_text title="For women" sub_title="Deals Shop Always Open" button_text="Shop now" link="#" el_class="xxxxxx" img="2049" css=".vc_custom_1448264765288{margin-top: 30px !important;}"][/vc_column][/vc_row][vc_row css=".vc_custom_1447809175260{margin-top: 70px !important;}"][vc_column][tab_producs style="2" per_page="8" columns="4" use_responsive="1"][/vc_column][/vc_row][vc_row full_width="stretch_row_content" parallax="content-moving" parallax_image="2018" css=".vc_custom_1448271936513{margin-bottom: 0px !important;background-position: center;background-repeat: no-repeat !important;background-size: cover !important;}"][vc_column][kt_look_books columns="10" overlay_opacity="0.7" use_responsive="1" title="Look Books" sub_title="" img="" button_text="" link="" css=".vc_custom_1448272792643{padding-top: 42px !important;padding-bottom: 60px !important;}" overlay_color="#000000"][/vc_column][/vc_row][vc_row css=".vc_custom_1447984351797{margin-top: 70px !important;margin-bottom: 0px !important;}"][vc_column][kt_featured_products display_type="2" number="5" use_responsive="1" title="TRENDING NOW"][/vc_column][/vc_row][vc_row css=".vc_custom_1448012073658{margin-bottom: 0px !important;padding-top: 70px !important;}"][vc_column][kt_colection margin="14" use_responsive="1" items_destop="3" title="Colections"][/vc_column][/vc_row][vc_row full_width="stretch_row_content" parallax="content-moving" parallax_image="2025" css=".vc_custom_1448269103732{margin-top: 70px !important;margin-bottom: 0px !important;}"][vc_column][kt_testimonial overlay_opacity="0.7" title="Testimonials" css=".vc_custom_1448015938544{padding-top: 60px !important;padding-bottom: 60px !important;}"][/vc_column][/vc_row][vc_row css=".vc_custom_1448269093463{margin-top: 70px !important;margin-bottom: 0px !important;}"][vc_column][blog_carousel style="style-3" per_page="10" margin="30" use_responsive="1" title="LASTEST POSTS"][/vc_column][/vc_row][vc_row css=".vc_custom_1448269213113{margin-top: 50px !important;margin-bottom: 5px !important;}"][vc_column][brand show_product="false" line_brand="show-logo" margin="30" use_responsive="1" items_destop="6" items_tablet="4" items_mobile="3"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    // Option 9
    $data               = array(); // Create new array
    $data['name']       = __( '09 KT Home Style 9', 'kutetheme' ); // Assign name for your custom template
    $data['weight']     = 0; // Weight of your template in the template list
    //$data['image_path'] = get_template_directory_uri()."/images/vc_templates_preview/home2.png"; // Always use preg replace to be sure that "space" will not break logic. Thumbnail should have this dimensions: 114x154px
    $data['custom_class'] = 'custom_template_for_vc_custom_template'; // CSS class name
    $data['content']    = <<<CONTENT
        [vc_row css=".vc_custom_1449246496905{margin-bottom: 0px !important;}"][vc_column][rev_slider_vc alias="kute-opt9"][/vc_column][/vc_row][vc_row css=".vc_custom_1449244532741{margin-right: 0px !important;margin-bottom: 0px !important;margin-left: 0px !important;}"][vc_column width="1/2" css=".vc_custom_1449243622225{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner enable_countdown="on" banner_image="843" link="#" time="12/31/2015 10:44" countdown_text="Hot deal"][/vc_column][vc_column width="1/2" css=".vc_custom_1449243632803{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_image="844" link="#"][vc_row_inner css=".vc_custom_1449245190728{margin-right: 0px !important;margin-bottom: 0px !important;margin-left: 0px !important;border-bottom-width: 0px !important;}"][vc_column_inner width="1/2" css=".vc_custom_1449243911529{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-2" title="START
TO RUN" sub_title="sale 25% off" banner_image="845"][/vc_column_inner][vc_column_inner width="1/2" css=".vc_custom_1449244349363{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-2" hide_bg="style2" title="START
TO RUN" sub_title="sale 25% off" banner_image="854"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row css=".vc_custom_1449245919682{margin-right: 0px !important;margin-bottom: 0px !important;margin-left: 0px !important;border-bottom-width: 0px !important;}"][vc_column width="1/2" css=".vc_custom_1449243622225{padding-right: 0px !important;padding-left: 0px !important;}"][vc_row_inner css=".vc_custom_1449245166952{margin-right: 0px !important;margin-bottom: 0px !important;margin-left: 0px !important;border-bottom-width: 0px !important;}"][vc_column_inner width="1/2" css=".vc_custom_1449243911529{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-3" hide_bg="style2" banner_image="846" product_id="101"][/vc_column_inner][vc_column_inner width="1/2" css=".vc_custom_1449244349363{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-2" title="THE SPORT
WATCHES
" sub_title="sale 25% off" banner_image="846"][/vc_column_inner][/vc_row_inner][vc_row_inner css=".vc_custom_1449245908121{margin-right: 0px !important;margin-bottom: 0px !important;margin-left: 0px !important;}"][vc_column_inner width="1/2" css=".vc_custom_1449243911529{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-3" banner_image="847" product_id="103"][/vc_column_inner][vc_column_inner width="1/2" css=".vc_custom_1449244349363{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-2" hide_bg="style2" title="THE NEW
IPOD" sub_title="sale 25% off" banner_image="847"][/vc_column_inner][/vc_row_inner][/vc_column][vc_column width="1/2" css=".vc_custom_1449243632803{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-2" banner_image="848" link="#" title="SPORTWEAR
CLOTHES

450" sub_title="Products"][/vc_column][/vc_row][vc_row css=".vc_custom_1449246057514{margin-bottom: 0px !important;}"][vc_column][category_carousel taxonomy="47,48,49" loop="true" margin="27" use_responsive="1" banner_image="947" title="HOT CATEGORIES" subtitle="The hotest categories for customer"][/vc_column][/vc_row][vc_row css=".vc_custom_1449245919682{margin-right: 0px !important;margin-bottom: 0px !important;margin-left: 0px !important;border-bottom-width: 0px !important;}"][vc_column width="1/2" css=".vc_custom_1449243632803{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-2" banner_image="849" link="#" title="SPORTWEAR
PANTS TROUSERS

480" sub_title="Products"][/vc_column][vc_column width="1/2" css=".vc_custom_1449243622225{padding-right: 0px !important;padding-left: 0px !important;}"][vc_row_inner css=".vc_custom_1449245166952{margin-right: 0px !important;margin-bottom: 0px !important;margin-left: 0px !important;border-bottom-width: 0px !important;}"][vc_column_inner width="1/2" css=".vc_custom_1449243911529{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-3" hide_bg="style2" banner_image="846" product_id="103"][/vc_column_inner][vc_column_inner width="1/2" css=".vc_custom_1449244349363{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-2" title="SPORTWEAR
PANTS TROUSERS
" sub_title="sale 25% off" banner_image="851"][/vc_column_inner][/vc_row_inner][vc_row_inner css=".vc_custom_1449245908121{margin-right: 0px !important;margin-bottom: 0px !important;margin-left: 0px !important;}"][vc_column_inner width="1/2" css=".vc_custom_1449243911529{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-3" banner_image="852" product_id="104"][/vc_column_inner][vc_column_inner width="1/2" css=".vc_custom_1449244349363{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-2" hide_bg="style2" sub_title="sale 25% off" banner_image="852" title="New
Fashion"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row css=".vc_custom_1449245919682{margin-right: 0px !important;margin-bottom: 0px !important;margin-left: 0px !important;border-bottom-width: 0px !important;}"][vc_column width="1/2" css=".vc_custom_1449243622225{padding-right: 0px !important;padding-left: 0px !important;}"][vc_row_inner css=".vc_custom_1449245166952{margin-right: 0px !important;margin-bottom: 0px !important;margin-left: 0px !important;border-bottom-width: 0px !important;}"][vc_column_inner width="1/2" css=".vc_custom_1449243911529{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-3" hide_bg="style2" banner_image="854" product_id="104"][/vc_column_inner][vc_column_inner width="1/2" css=".vc_custom_1449244349363{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-2" title="WORKOUT
CLOTHE" sub_title="Only $300" banner_image="853"][/vc_column_inner][/vc_row_inner][vc_row_inner css=".vc_custom_1449245908121{margin-right: 0px !important;margin-bottom: 0px !important;margin-left: 0px !important;}"][vc_column_inner width="1/2" css=".vc_custom_1449243911529{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-3" banner_image="854" product_id="105"][/vc_column_inner][vc_column_inner width="1/2" css=".vc_custom_1449244349363{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-2" hide_bg="style2" title="THE NEW
IPOD" sub_title="ONLY $100" banner_image="847"][/vc_column_inner][/vc_row_inner][/vc_column][vc_column width="1/2" css=".vc_custom_1449243632803{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-2" banner_image="850" link="#" title="SPORTWEAR
CLOTHES

450" sub_title="Products"][/vc_column][/vc_row][vc_row css=".vc_custom_1449246213127{margin-top: 50px !important;}"][vc_column][blog_carousel style="style-5" per_page="10" use_responsive="1" title="Recent blog posts" subtitle="The lastest news from your blog"][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1449104262996{margin-bottom: 0px !important;padding-top: 45px !important;padding-bottom: 45px !important;background-color: #ebebeb !important;}"][vc_column][brand show_product="false" line_brand="show-logo2" autoplay="true" navigation="true" loop="true" margin="29" use_responsive="1" items_destop="7"][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1449246386776{margin-bottom: 0px !important;background-color: #191919 !important;}"][vc_column][service items="3" style="3" css=".vc_custom_1449109933925{border-top-width: 0px !important;border-right-width: 0px !important;border-bottom-width: 1px !important;border-left-width: 0px !important;padding-bottom: 30px !important;border-left-color: #505050 !important;border-left-style: solid !important;border-right-color: #505050 !important;border-right-style: solid !important;border-top-color: #505050 !important;border-top-style: solid !important;border-bottom-color: #505050 !important;border-bottom-style: solid !important;}"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    // Option 11
    $data               = array(); // Create new array
    $data['name']       = __( '11 KT Home Style 11', 'kutetheme' ); // Assign name for your custom template
    $data['weight']     = 0; // Weight of your template in the template list
    //$data['image_path'] = get_template_directory_uri()."/images/vc_templates_preview/home2.png"; // Always use preg replace to be sure that "space" will not break logic. Thumbnail should have this dimensions: 114x154px
    $data['custom_class'] = 'custom_template_for_vc_custom_template'; // CSS class name
    $data['content']    = <<<CONTENT
        [vc_row css=".vc_custom_1449246496905{margin-bottom: 0px !important;}"][vc_column][rev_slider_vc alias="kute-opt11"][/vc_column][/vc_row][vc_row css=".vc_custom_1449244532741{margin-right: 0px !important;margin-bottom: 0px !important;margin-left: 0px !important;}"][vc_column width="1/2" css=".vc_custom_1449243622225{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner enable_countdown="on" banner_image="843" link="#" time="12/31/2015 10:44" countdown_text="Hot deal"][/vc_column][vc_column width="1/2" css=".vc_custom_1449243632803{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_image="844" link="#"][vc_row_inner css=".vc_custom_1449245190728{margin-right: 0px !important;margin-bottom: 0px !important;margin-left: 0px !important;border-bottom-width: 0px !important;}"][vc_column_inner width="1/2" css=".vc_custom_1449243911529{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-2" title="START
TO RUN" sub_title="sale 25% off" banner_image="845"][/vc_column_inner][vc_column_inner width="1/2" css=".vc_custom_1449244349363{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-2" hide_bg="style2" title="START
TO RUN" sub_title="sale 25% off" banner_image="854"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row css=".vc_custom_1449245919682{margin-right: 0px !important;margin-bottom: 0px !important;margin-left: 0px !important;border-bottom-width: 0px !important;}"][vc_column width="1/2" css=".vc_custom_1449243622225{padding-right: 0px !important;padding-left: 0px !important;}"][vc_row_inner css=".vc_custom_1449245166952{margin-right: 0px !important;margin-bottom: 0px !important;margin-left: 0px !important;border-bottom-width: 0px !important;}"][vc_column_inner width="1/2" css=".vc_custom_1449243911529{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-3" hide_bg="style2" banner_image="846" product_id="101"][/vc_column_inner][vc_column_inner width="1/2" css=".vc_custom_1449244349363{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-2" title="THE SPORT
WATCHES
" sub_title="sale 25% off" banner_image="846"][/vc_column_inner][/vc_row_inner][vc_row_inner css=".vc_custom_1449245908121{margin-right: 0px !important;margin-bottom: 0px !important;margin-left: 0px !important;}"][vc_column_inner width="1/2" css=".vc_custom_1449243911529{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-3" banner_image="847" product_id="103"][/vc_column_inner][vc_column_inner width="1/2" css=".vc_custom_1449244349363{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-2" hide_bg="style2" title="THE NEW
IPOD" sub_title="sale 25% off" banner_image="847"][/vc_column_inner][/vc_row_inner][/vc_column][vc_column width="1/2" css=".vc_custom_1449243632803{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-2" banner_image="848" link="#" title="SPORTWEAR
CLOTHES

450" sub_title="Products"][/vc_column][/vc_row][vc_row css=".vc_custom_1449246057514{margin-bottom: 0px !important;}"][vc_column][category_carousel taxonomy="51,53,52" loop="true" margin="27" use_responsive="1" banner_image="861"][/vc_column][/vc_row][vc_row css=".vc_custom_1449245919682{margin-right: 0px !important;margin-bottom: 0px !important;margin-left: 0px !important;border-bottom-width: 0px !important;}"][vc_column width="1/2" css=".vc_custom_1449243632803{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-2" banner_image="849" link="#" title="SPORTWEAR
PANTS TROUSERS

480" sub_title="Products"][/vc_column][vc_column width="1/2" css=".vc_custom_1449243622225{padding-right: 0px !important;padding-left: 0px !important;}"][vc_row_inner css=".vc_custom_1449245166952{margin-right: 0px !important;margin-bottom: 0px !important;margin-left: 0px !important;border-bottom-width: 0px !important;}"][vc_column_inner width="1/2" css=".vc_custom_1449243911529{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-3" hide_bg="style2" banner_image="846" product_id="103"][/vc_column_inner][vc_column_inner width="1/2" css=".vc_custom_1449244349363{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-2" title="SPORTWEAR
PANTS TROUSERS
" sub_title="sale 25% off" banner_image="851"][/vc_column_inner][/vc_row_inner][vc_row_inner css=".vc_custom_1449245908121{margin-right: 0px !important;margin-bottom: 0px !important;margin-left: 0px !important;}"][vc_column_inner width="1/2" css=".vc_custom_1449243911529{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-3" banner_image="852" product_id="104"][/vc_column_inner][vc_column_inner width="1/2" css=".vc_custom_1449244349363{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-2" hide_bg="style2" sub_title="sale 25% off" banner_image="852" title="New
Fashion"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row css=".vc_custom_1449245919682{margin-right: 0px !important;margin-bottom: 0px !important;margin-left: 0px !important;border-bottom-width: 0px !important;}"][vc_column width="1/2" css=".vc_custom_1449243622225{padding-right: 0px !important;padding-left: 0px !important;}"][vc_row_inner css=".vc_custom_1449245166952{margin-right: 0px !important;margin-bottom: 0px !important;margin-left: 0px !important;border-bottom-width: 0px !important;}"][vc_column_inner width="1/2" css=".vc_custom_1449243911529{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-3" hide_bg="style2" banner_image="854" product_id="104"][/vc_column_inner][vc_column_inner width="1/2" css=".vc_custom_1449244349363{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-2" title="WORKOUT
CLOTHE" sub_title="Only $300" banner_image="853"][/vc_column_inner][/vc_row_inner][vc_row_inner css=".vc_custom_1449245908121{margin-right: 0px !important;margin-bottom: 0px !important;margin-left: 0px !important;}"][vc_column_inner width="1/2" css=".vc_custom_1449243911529{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-3" banner_image="854" product_id="105"][/vc_column_inner][vc_column_inner width="1/2" css=".vc_custom_1449244349363{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-2" hide_bg="style2" title="THE NEW
IPOD" sub_title="ONLY $100" banner_image="847"][/vc_column_inner][/vc_row_inner][/vc_column][vc_column width="1/2" css=".vc_custom_1449243632803{padding-right: 0px !important;padding-left: 0px !important;}"][kt_banner banner_style="style-2" banner_image="850" link="#" title="SPORTWEAR
CLOTHES

450" sub_title="Products"][/vc_column][/vc_row][vc_row css=".vc_custom_1449246213127{margin-top: 50px !important;}"][vc_column][blog_carousel style="style-5" per_page="10" use_responsive="1" title="Recent blog posts" subtitle="The lastest news from your blog"][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1449104262996{margin-bottom: 0px !important;padding-top: 45px !important;padding-bottom: 45px !important;background-color: #ebebeb !important;}"][vc_column][brand show_product="false" line_brand="show-logo2" autoplay="true" navigation="true" loop="true" margin="29" use_responsive="1" items_destop="7"][/vc_column][/vc_row][vc_row full_width="stretch_row" css=".vc_custom_1449246386776{margin-bottom: 0px !important;background-color: #191919 !important;}"][vc_column][service items="3" style="3" css=".vc_custom_1449109933925{border-top-width: 0px !important;border-right-width: 0px !important;border-bottom-width: 1px !important;border-left-width: 0px !important;padding-bottom: 30px !important;border-left-color: #505050 !important;border-left-style: solid !important;border-right-color: #505050 !important;border-right-style: solid !important;border-top-color: #505050 !important;border-top-style: solid !important;border-bottom-color: #505050 !important;border-bottom-style: solid !important;}"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

    // Option 12
    $data               = array(); // Create new array
    $data['name']       = __( '12 KT Home Style 12', 'kutetheme' ); // Assign name for your custom template
    $data['weight']     = 0; // Weight of your template in the template list
    //$data['image_path'] = get_template_directory_uri()."/images/vc_templates_preview/home2.png"; // Always use preg replace to be sure that "space" will not break logic. Thumbnail should have this dimensions: 114x154px
    $data['custom_class'] = 'custom_template_for_vc_custom_template'; // CSS class name
    $data['content']    = <<<CONTENT
        [vc_row css=".vc_custom_1448856734147{margin-right: 0px !important;margin-bottom: 30px !important;margin-left: -10px !important;padding-top: 10px !important;}"][vc_column width="1/4" css=".vc_custom_1448877576919{padding-right: 0px !important;padding-left: 10px !important;}" offset="vc_hidden-md vc_hidden-sm vc_hidden-xs"][/vc_column][vc_column css=".vc_custom_1448857670966{padding-right: 0px !important;padding-left: 10px !important;}" offset="vc_col-lg-7 vc_col-md-9"][rev_slider_vc alias="kute-opt12"][/vc_column][vc_column css=".vc_custom_1448862237953{padding-right: 0px !important;padding-left: 0px !important;}" offset="vc_col-lg-2 vc_col-md-3 vc_hidden-sm vc_hidden-xs"][vc_single_image image="2192" img_size="full" onclick="custom_link" link="#" el_class="banner-opacity" css=".vc_custom_1448941266556{margin-bottom: 0px !important;}"][/vc_column][/vc_row][vc_row css=".vc_custom_1448848062093{margin-right: 0px !important;margin-bottom: 0px !important;margin-left: 0px !important;}"][vc_column width="1/3" css=".vc_custom_1448847861227{padding-right: 0px !important;padding-left: 0px !important;}"][vc_single_image image="2062" img_size="full" onclick="custom_link" link="#" el_class="banner-boder-zoom2" css=".vc_custom_1448872866975{margin-bottom: 30px !important;}"][/vc_column][vc_column width="1/3" css=".vc_custom_1448847926339{padding-right: 0px !important;padding-left: 0px !important;}"][vc_single_image image="2063" img_size="full" onclick="custom_link" link="#" el_class="banner-boder-zoom2" css=".vc_custom_1448872890095{margin-bottom: 30px !important;}"][/vc_column][vc_column width="1/3" css=".vc_custom_1448847870907{margin-bottom: 30px !important;padding-right: 0px !important;padding-left: 0px !important;}"][vc_single_image image="2060" img_size="full" onclick="custom_link" link="#" el_class="banner-boder-zoom2" css=".vc_custom_1448872906125{margin-bottom: 0px !important;}"][/vc_column][/vc_row][vc_row css=".vc_custom_1448865791640{margin-bottom: 0px !important;}"][vc_column width="2/3" offset="vc_col-lg-9 vc_col-md-9" css=".vc_custom_1448879584526{margin-bottom: 0px !important;}"][categories_tab per_page="6" number_column="3" tabs_type="tab-7" title="WOMEN'S FASHION" category="187" main_color="#ff3366" banner_left="2064" css=".vc_custom_1448876331318{margin-bottom: 30px !important;}"][tab_section][tab_section section_type="most-review"][tab_section section_type="new-arrival"][/categories_tab][categories_tab per_page="6" number_column="3" tabs_type="tab-7" title="MEN'S FASHION" category="186" main_color="#11a8ab" banner_left="2065" css=".vc_custom_1448876351948{margin-bottom: 30px !important;}"][tab_section][tab_section section_type="most-review"][tab_section section_type="new-arrival"][/categories_tab][categories_tab per_page="6" number_column="3" tabs_type="tab-7" title="ACCESSORIES" category="188" main_color="#0066cc" banner_left="2066" css=".vc_custom_1448876372516{margin-bottom: 30px !important;}"][tab_section][tab_section section_type="most-review"][tab_section section_type="new-arrival"][/categories_tab][/vc_column][vc_column width="1/3" offset="vc_col-lg-3 vc_col-md-3"][vc_row_inner][vc_column_inner offset="vc_col-lg-12 vc_col-md-12 vc_col-xs-12"][lastest_deals_sidebar type="style-2" taxonomy="188" number="2" navigation="true" title="HOT DEAL OF THIS WEEK" css=".vc_custom_1448933018169{margin-bottom: 30px !important;}"][/vc_column_inner][vc_column_inner offset="vc_col-lg-12 vc_col-md-12 vc_col-xs-12"][kt_testimonial type="style-2" columns="3" css=".vc_custom_1448874910448{margin-bottom: 30px !important;}"][/vc_column_inner][vc_column_inner offset="vc_col-lg-12 vc_col-md-12 vc_col-xs-12"][product_sidebar target="new-arrival" taxonomy="189" number_product="10" per_page="5" navigation="true" title="New product" css=".vc_custom_1448934258560{margin-bottom: 30px !important;}"][vc_single_image image="2180" img_size="full" onclick="custom_link" link="#" el_class="banner-boder-zoom2" css=".vc_custom_1448879922812{margin-bottom: 30px !important;}"][/vc_column_inner][/vc_row_inner][/vc_column][/vc_row][vc_row css=".vc_custom_1448848257434{margin-bottom: 0px !important;}"][vc_column width="1/2"][vc_single_image image="2068" img_size="full" onclick="custom_link" link="#" el_class="banner-boder-zoom2" css=".vc_custom_1448873287010{margin-bottom: 30px !important;}"][/vc_column][vc_column width="1/2"][vc_single_image image="2069" img_size="full" onclick="custom_link" link="#" el_class="banner-boder-zoom2" css=".vc_custom_1448873306246{margin-bottom: 30px !important;}"][/vc_column][/vc_row][vc_row css=".vc_custom_1448854024073{margin-bottom: 30px !important;}"][vc_column][blog_carousel style="style-4" per_page="10" navigation="true" loop="true" margin="30" use_responsive="1" items_destop="2" items_tablet="1" title="RECENT BLOG POSTS" subtitle="The lastest news from your blog"][/vc_column][/vc_row][vc_row css=".vc_custom_1448865993640{margin-bottom: 0px !important;}"][vc_column offset="vc_col-lg-4 vc_col-md-4"][popular_category type="style-2" taxonomy="187" per_page="7" title="Category Women" icon="2427" box_background="2165" css=".vc_custom_1448877766211{margin-bottom: 30px !important;}"][/vc_column][vc_column offset="vc_col-lg-4 vc_col-md-4"][popular_category type="style-2" taxonomy="186" per_page="7" title="Category Men" icon="2427" box_background="2166" css=".vc_custom_1448877789083{margin-bottom: 30px !important;}"][/vc_column][vc_column offset="vc_col-lg-4 vc_col-md-4"][popular_category type="style-2" taxonomy="188" per_page="7" title="Category Women" icon="2427" box_background="2167" css=".vc_custom_1448877808282{margin-bottom: 30px !important;}"][/vc_column][/vc_row][vc_row css=".vc_custom_1448932304640{margin-bottom: 0px !important;}"][vc_column css=".vc_custom_1448932818609{margin-bottom: 25px !important;}"][brand show_product="false" line_brand="show-logo2" navigation="true" loop="true" margin="29.5" use_responsive="1" items_destop="7"][/vc_column][/vc_row]
CONTENT;
    vc_add_default_templates( $data );

}

function kt_topbar_menu(){
    $menuleft = array(
        'theme_location'  => 'topbar_menuleft',
        'menu'            => 'topbar_menuleft',
        'container'       => '',
        'container_class' => '',
        'container_id'    => '',
        'menu_class'      => 'navigation top-bar-menu left',
        'menu_id'         => '',
        'echo'            => true,
        'fallback_cb'     => '',
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        'depth'           => 0,
        'walker'          => ''
    );
    $menuright = array(
        'theme_location'  => 'topbar_menuright',
        'menu'            => 'topbar_menuright',
        'container'       => '',
        'container_class' => '',
        'container_id'    => '',
        'menu_class'      => 'navigation top-bar-menu right',
        'menu_id'         => '',
        'echo'            => true,
        'fallback_cb'     => '',
        'before'          => '',
        'after'           => '',
        'link_before'     => '',
        'link_after'      => '',
        'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
        'depth'           => 0,
        'walker'          => ''
    );
    $kt_used_header = kt_option('kt_used_header',1);
    if( $kt_used_header == 11 || $kt_used_header == 14){
        wp_nav_menu( $menuright );
    }else{
         wp_nav_menu( $menuleft );
         wp_nav_menu( $menuright );
    }
}