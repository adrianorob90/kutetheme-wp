<?php
/**
 * Include the TGM_Plugin_Activation class.
 */
require_once THEME_DIR. 'inc/hooks/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'kt_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
if( ! function_exists( 'kt_register_required_plugins' ) ):
    function kt_register_required_plugins() {
    	/*
    	 * Array of plugin arrays. Required keys are name and slug.
    	 * If the source is NOT from the .org repo, then source is also required.
    	 */
    	$plugins = array(
    		// This is an example of how to include a plugin pre-packaged with a theme
    		array(
    			'name'     				=> 'Kutetheme toolkit', // The plugin name
    			'slug'     				=> 'kutetheme-toolkit', // The plugin slug (typically the folder name)
    			'source'   				=> get_stylesheet_directory() . '/recommend-plugins/kutetheme-toolkit.zip', // The plugin source
    			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
    			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
    			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
    			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
    			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
    		),
    		array(
    			'name'     				=> 'Revolution Slider', // The plugin name
    			'slug'     				=> 'revslider', // The plugin slug (typically the folder name)
    			'source'   				=> get_stylesheet_directory() . '/recommend-plugins/revslider.zip', // The plugin source
    			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
    			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
    			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
    			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
    			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
    		),
            array(
    			'name'     				=> 'WPBakery Visual Composer', // The plugin name
    			'slug'     				=> 'js_composer', // The plugin slug (typically the folder name)
    			'source'   				=> get_stylesheet_directory() . '/recommend-plugins/js_composer.zip', // The plugin source
    			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
    			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
    			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
    			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
    			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
    		),
            array(
    			'name'     				=> 'Variation Swatches and Photos', // The plugin name
    			'slug'     				=> 'woocommerce-variation-swatches-and-photos', // The plugin slug (typically the folder name)
    			'source'   				=> get_stylesheet_directory() . '/recommend-plugins/woocommerce-variation-swatches-and-photos.zip', // The plugin source
    			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
    			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
    			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
    			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
    			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
    		),
    		array(
                'name'      => 'WooCommerce',
                'slug'      => 'woocommerce',
                'required'  => false,
            ),
    		array(
                'name'      => 'YITH WooCommerce Compare',
                'slug'      => 'yith-woocommerce-compare',
                'required'  => false,
            ),
            array(
                'name' => 'YITH WooCommerce Wishlist', // The plugin name
                'slug' => 'yith-woocommerce-wishlist', // The plugin slug (typically the folder name)
                'required' => false, // If false, the plugin is only 'recommended' instead of required
            ),
            array(
                'name' => 'YITH WooCommerce Ajax Product Filter', // The plugin name
                'slug' => 'yith-woocommerce-ajax-navigation', // The plugin slug (typically the folder name)
                'required' => false, // If false, the plugin is only 'recommended' instead of required
            ),
            array(
                'name' => 'YITH WooCommerce Quick View', // The plugin name
                'slug' => 'yith-woocommerce-quick-view', // The plugin slug (typically the folder name)
                'required' => false, // If false, the plugin is only 'recommended' instead of required
            ),
    	);
    
    	/*
    	 * Array of configuration settings. Amend each line as needed.
    	 *
    	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
    	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
    	 * sending in a pull-request with .po file(s) with the translations.
    	 *
    	 * Only uncomment the strings in the config array if you want to customize the strings.
    	 */
    	$config = array(
    		'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
    		'default_path' => '',                      // Default absolute path to bundled plugins.
    		'menu'         => 'tgmpa-install-plugins', // Menu slug.
    		'parent_slug'  => 'themes.php',            // Parent menu slug.
    		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
    		'has_notices'  => true,                    // Show admin notices or not.
    		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
    		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
    		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
    		'message'      => '',                      // Message to output right before the plugins table.
    	);
    
    	tgmpa( $plugins, $config );
    }
endif;

if( ! function_exists( 'kt_init_session_start' ) ){
    function kt_init_session_start(){
        if(!session_id()) {
            session_start();
        }
    }
}

add_action('init', 'kt_init_session_start', 1);

if( ! function_exists( 'kt_custom_inline_style' ) ){
    function kt_custom_inline_style(){
        $color_scheme_css = kt_get_inline_css();
        wp_add_inline_style( 'kutetheme-style', $color_scheme_css );
    }
}
add_action( 'wp_enqueue_scripts', 'kt_custom_inline_style' );

if( ! function_exists( 'kt_custom_js' ) ){
    function kt_custom_js(){
        $js = kt_get_customize_js();
        if( $js ) :
        ?>
        <script type="text/javascript" id="custom-js">
    		<?php echo esc_textarea( $js ) ; ?>
    	</script>
        <?php
        endif;
    }
}
add_action( 'wp_footer', 'kt_custom_js' );

if( ! function_exists( 'kt_setting_vertical_menu' ) ){
    function kt_setting_vertical_menu(){
        wp_nav_menu( array(
            'menu'              => 'vertical',
            'theme_location'    => 'vertical',
            'depth'             => 2,
            'container'         => '',
            'container_class'   => '',
            'container_id'      => '',
            'menu_class'        => 'vertical-menu-list',
            'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
            'walker'            => new wp_bootstrap_navwalker())
        );
    }
}

if( ! function_exists( 'kt_setting_mega_menu' ) ){
    function kt_setting_mega_menu(){
        wp_nav_menu( array(
            'menu'              => 'primary',
            'theme_location'    => 'primary',
            'depth'             => 2,
            'container'         => 'div',
            'container_class'   => 'collapse navbar-collapse',
            'container_id'      => 'navbar',
            'menu_class'        => 'nav navbar-nav',
            'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
            'walker'            => new wp_bootstrap_navwalker())
        );
    }
}
if( ! function_exists( 'kt_show_menu_option_1' ) ){
    function kt_show_menu_option_1(){ 
        global $kt_enable_vertical_menu;
        $kt_click_open_vertical_menu = kt_option('kt_click_open_vertical_menu','disable');
        $kt_vertical_item_visible = kt_option('kt_vertical_item_visible',11);
        ?>
        <div class="row">
            <?php if( $kt_enable_vertical_menu == 'enable' ): ?>
            <div class="col-xs-6 col-sm-3" id="box-vertical-megamenus">
                <div data-items="<?php echo esc_attr( $kt_vertical_item_visible );?>" class="box-vertical-megamenus <?php if( $kt_click_open_vertical_menu =="enable") echo esc_attr( 'hiden_content' );?>">
                    <h4 class="title">
                        <span class="title-menu"><?php esc_html_e( 'Categories', 'kutetheme' ) ?></span>
                        <span class="btn-open-mobile pull-right home-page"><i class="fa fa-bars"></i></span>
                    </h4>
                    <div class="vertical-menu-content">
                        <?php kt_setting_vertical_menu(); ?>
                        <div class="all-category"><span class="open-cate"><?php esc_html_e( 'All Categories', 'kutetheme' ) ?></span></div>
                    </div>
                </div>
            </div>
            <div id="main-menu" class="col-xs-6 col-sm-9 main-menu enable_vm">
            <?php else: ?>
            <div id="main-menu" class="col-sm-12 main-menu">
            <?php endif; ?>
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <i class="fa fa-bars"></i>
                            </button>
                            <a class="navbar-brand" href="#"><?php esc_html_e( 'Menu', 'kutetheme' ) ?></a>
                        </div>
                        <?php kt_setting_mega_menu(); ?>
                    </div>
                </nav>
            </div>
        </div>
        <?php
    }
}
add_action( 'kt_show_menu_option_1', 'kt_show_menu_option_1' );

if( ! function_exists( 'kt_show_menu_option_2' ) ){
    function kt_show_menu_option_2(){
        global $kt_enable_vertical_menu;
        $kt_click_open_vertical_menu = kt_option('kt_click_open_vertical_menu','disable');
        $kt_vertical_item_visible = kt_option('kt_vertical_item_visible',11);
        ?>
        <div class="row">
            <?php if ( $kt_enable_vertical_menu == 'enable' ) : ?>
            <div class="col-xs-6 col-sm-3" id="box-vertical-megamenus">
                <div data-items="<?php echo esc_attr( $kt_vertical_item_visible );?>" class="box-vertical-megamenus style2 <?php if( $kt_click_open_vertical_menu =="enable") echo esc_attr( 'hiden_content' );?>">
                    <h4 class="title">
                        <span class="title-menu"><?php esc_html_e( 'Categories', 'kutetheme' ) ?></span>
                        <span class="btn-open-mobile pull-right home-page"><i class="fa fa-bars"></i></span>
                    </h4>
                    <div class="vertical-menu-content is-home">
                        <?php kt_setting_vertical_menu(); ?><!--/.nav-collapse -->
                        <div class="all-category"><span class="open-cate"><?php esc_html_e( 'All Categories', 'kutetheme' ) ?></span></div>
                    </div>
                </div>
            </div>
            <div id="main-menu" class="col-xs-6 col-sm-9 main-menu enable_vm">
            <?php else: ?>
            <div id="main-menu" class="col-sm-12 main-menu">
            <?php endif; ?>
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <i class="fa fa-bars"></i>
                            </button>
                            <a class="navbar-brand" href="#"><?php esc_html_e( 'Menu', 'kutetheme' ) ?></a>
                        </div>
                        <?php kt_setting_mega_menu(); ?><!--/.nav-collapse -->
                    </div>
                </nav>
            </div>
        </div>
    <?php }
}
add_action( 'kt_show_menu_option_2', 'kt_show_menu_option_2' );

if( ! function_exists( 'kt_show_menu_option_3' ) ){
    function kt_show_menu_option_3(){
        global $kt_enable_vertical_menu;
        $kt_click_open_vertical_menu = kt_option('kt_click_open_vertical_menu','disable');
        $kt_vertical_item_visible = kt_option('kt_vertical_item_visible',11);
        ?>
        <div class="row main-header-menu">
            <?php if( $kt_enable_vertical_menu == 'enable' ): ?>
            <div class="col-xs-6 col-sm-3" id="box-vertical-megamenus">
                <div data-items="<?php echo esc_attr( $kt_vertical_item_visible );?>" class="box-vertical-megamenus style2 <?php if( $kt_click_open_vertical_menu =="enable") echo esc_attr( 'hiden_content' );?>">
                    <h4 class="title">
                        <span class="title-menu"><?php esc_html_e( 'Categories', 'kutetheme' ) ?></span>
                        <span class="btn-open-mobile pull-right home-page"><i class="fa fa-bars"></i></span>
                    </h4>
                    <div class="vertical-menu-content is-home">
                        <?php kt_setting_vertical_menu(); ?><!--/.nav-collapse -->
                        <div class="all-category"><span class="open-cate"><?php esc_html_e( 'All Categories', 'kutetheme' ) ?></span></div>
                    </div>
                </div>
            </div>
            <div id="main-menu" class="col-xs-6  col-sm-12 col-md-9 main-menu enable_vm">
            <?php else: ?>
            <div id="main-menu" class="col-sm-12 main-menu">
            <?php endif; ?>
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <i class="fa fa-bars"></i>
                            </button>
                            <a class="navbar-brand" href="#"><?php esc_html_e( 'Menu', 'kutetheme' ) ?></a>
                        </div>
                        <?php kt_setting_mega_menu(); ?><!--/.nav-collapse -->
                    </div>
                </nav>
            </div>
        </div>
    <?php }
}
add_action( 'kt_show_menu_option_3', 'kt_show_menu_option_3' );

if( ! function_exists( 'kt_show_vertical_menu_option_4' ) ){
    function kt_show_vertical_menu_option_4(){
        global $kt_enable_vertical_menu;
        $kt_click_open_vertical_menu = kt_option('kt_click_open_vertical_menu','disable');
        $kt_vertical_item_visible = kt_option('kt_vertical_item_visible',11);
    ?>
    <?php if( $kt_enable_vertical_menu == 'enable' ) : ?>
    <div class="row enable_vm">
        <div class="col-sm-3" id="box-vertical-megamenus">
            <div data-items="<?php echo esc_attr( $kt_vertical_item_visible );?>" class="box-vertical-megamenus <?php if( $kt_click_open_vertical_menu =="enable") echo esc_attr( 'hiden_content' );?>">
                <h4 class="title">
                    <span class="title-menu">Categories</span>
                    <span class="btn-open-mobile pull-right home-page"><i class="fa fa-bars"></i></span>
                </h4>
                <div class="vertical-menu-content is-home">
                    <?php kt_setting_vertical_menu(); ?><!--/.nav-collapse -->
                    <div class="all-category"><span class="open-cate"><?php esc_html_e( 'All Categories', 'kutetheme' ) ?></span></div>
                </div>
            </div>
        </div>
    <?php else:  ?>
        <div class="row">
    <?php endif; ?>
    <?php if( kt_is_wpml() ): ?>
            <?php if( $kt_enable_vertical_menu == 'enable' ) : ?>
                <div class="col-sm-5 col-md-7 formsearch-option4 kt-wpml">
                    <?php kt_search_form();  ?>
                </div>
                <div class="col-sm-4 col-md-2 group-link-main-menu">
                    <?php echo kt_get_wpml(); ?>
                </div>
            <?php else: ?>
                <div class="col-sm-7 col-md-10 formsearch-option4 kt-wpml">
                    <?php kt_search_form();  ?>
                </div>
                <div class="col-sm-5 col-md-2 group-link-main-menu">
                    <?php echo kt_get_wpml(); ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <?php if( $kt_enable_vertical_menu == 'enable' ) : ?>
                <div class="col-sm-9 formsearch-option4">
                    <?php kt_search_form();  ?>
                </div>
            <?php else: ?>
                <div class="col-sm-12 formsearch-option4">
                    <?php kt_search_form();  ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <?php }
}
add_action( 'kt_show_vertical_menu_option_4', 'kt_show_vertical_menu_option_4' );

if( ! function_exists( 'kt_show_menu_option_5' ) ){
    function kt_show_menu_option_5(){
        global $kt_enable_vertical_menu;
        $kt_click_open_vertical_menu = kt_option('kt_click_open_vertical_menu','disable');
        $kt_vertical_item_visible = kt_option('kt_vertical_item_visible',11);
        ?>
        <div class="row">
            <?php if( $kt_enable_vertical_menu == 'enable' ): ?>
            <div class="col-xs-2 col-sm-3" id="box-vertical-megamenus">
                <div data-items="<?php echo esc_attr( $kt_vertical_item_visible );?>" class="box-vertical-megamenus <?php if( $kt_click_open_vertical_menu =="enable") echo esc_attr( 'hiden_content' );?>">
                    <h4 class="title">
                        <span class="btn-open-mobile"><i class="fa fa-bars"></i></span>
                    </h4>
                    <div class="vertical-menu-content is-home">
                        <?php kt_setting_vertical_menu(); ?><!--/.nav-collapse -->
                        <div class="all-category"><span class="open-cate"><?php esc_html_e( 'All Categories', 'kutetheme' ) ?></span></div>
                    </div>
                </div>
            </div>
            <div id="main-menu" class="col-xs-10 col-sm-9 main-menu enable_vm">
            <?php else: ?>
            <div id="main-menu" class="col-sm-12 main-menu">
            <?php endif; ?>
                <nav class="navbar navbar-default">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <i class="fa fa-bars"></i>
                            </button>
                            <a class="navbar-brand" href="#"><?php esc_html_e( 'Menu', 'kutetheme' ) ?></a>
                        </div>
                        <div id="navbar" class="navbar-collapse collapse">
                            <?php kt_setting_mega_menu(); ?><!--/.nav-collapse -->
                        </div><!--/.nav-collapse -->
                    </div>
                </nav>
            </div>
        </div>
     <?php }
}
add_action( 'kt_show_menu_option_5', 'kt_show_menu_option_5' );


if( ! function_exists( 'kt_show_menu_option_6' ) ){
    function kt_show_menu_option_6(){
        global $kt_enable_vertical_menu;
        $kt_click_open_vertical_menu = kt_option('kt_click_open_vertical_menu','disable');
        $kt_vertical_item_visible = kt_option('kt_vertical_item_visible',11);
        ?>
        <div class="row">
            <?php if( $kt_enable_vertical_menu == 'enable' ): ?>
                <div class="col-sm-3" id="box-vertical-megamenus">
                    <div data-items="<?php echo esc_attr( $kt_vertical_item_visible );?>" class="box-vertical-megamenus <?php if( $kt_click_open_vertical_menu =="enable") echo esc_attr( 'hiden_content' );?>">
                        <h4 class="title">
                            <span class="btn-open-mobile"><i class="fa fa-bars"></i></span>
                            <span class="title-menu"><?php esc_html_e( 'Categories', 'kutetheme' );?></span>
                        </h4>
                        <div class="vertical-menu-content is-home">
                            <?php kt_setting_vertical_menu(); ?><!--/.nav-collapse -->
                            <div class="all-category"><span class="open-cate"><?php esc_html_e( 'All Categories', 'kutetheme' ) ?></span></div>
                        </div>
                    </div>
                </div>
                <div id="main-menu" class="col-sm-9 main-menu enable_vm">
            <?php else: ?>
                <div id="main-menu" class="col-sm-12 main-menu">
            <?php endif; ?>
                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                    <i class="fa fa-bars"></i>
                                </button>
                                <a class="navbar-brand" href="#"><?php esc_html_e( 'Menu', 'kutetheme' ) ?></a>
                            </div>
                            <?php kt_setting_mega_menu(); ?><!--/.nav-collapse -->
                        </div>
                    </nav>
                </div>
        </div>
     <?php }
}
add_action( 'kt_show_menu_option_6', 'kt_show_menu_option_6' );


if( ! function_exists( 'kt_show_vertical_menu_option_7' ) ){
    function kt_show_vertical_menu_option_7(){ 
    global $kt_enable_vertical_menu;
    $kt_click_open_vertical_menu = kt_option('kt_click_open_vertical_menu','disable');
    $kt_vertical_item_visible = kt_option('kt_vertical_item_visible',11);

    if( $kt_enable_vertical_menu == 'enable' ) : ?>
        <div class="nav-top-menu enable_vm">
            <div class="container">
                <div class="row">
                    <div class="col-sm-3" id="box-vertical-megamenus">
                        <div data-items="<?php echo esc_attr( $kt_vertical_item_visible );?>" class="box-vertical-megamenus <?php if( $kt_click_open_vertical_menu =="enable") echo esc_attr( 'hiden_content' );?>">
                            <h4 class="title">
                                <span class="btn-open-mobile home-page"><i class="fa fa-bars"></i></span>
                                <span class="title-menu"><?php _e( 'Categories', 'kutetheme' ) ?></span>
                            </h4>
                            <div class="vertical-menu-content is-home">
                                <?php kt_setting_vertical_menu(); ?>
                                <div class="all-category"><span class="open-cate"><?php esc_html_e( 'All Categories', 'kutetheme' ) ?></span></div>
                            </div>
                        </div>
                    </div>
                    <?php if( kt_is_wpml() ): ?>
                        <div class="col-sm-5 col-md-6 col-lg-7 formsearch-option4">
                            <?php kt_search_form();  ?>
                        </div>
                        <div class="col-sm-4 col-md-3 col-lg-2 group-link-main-menu">
                            <?php echo kt_get_wpml(); ?>
                        </div>
                    <?php else: ?>
                        <div class="col-sm-5 col-md-9 col-lg-9 formsearch-option4">
                            <?php kt_search_form();  ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="nav-top-menu disable_vm">
            <div class="container">
                <div class="row">
                    <?php if( kt_is_wpml() ): ?>
                        <div class="col-sm-8 col-md-9 col-lg-9 formsearch-option4">
                            <?php kt_search_form();  ?>
                        </div>
                        <div class="col-sm-4 col-md-3 col-lg-3 group-link-main-menu">
                            <?php echo kt_get_wpml(); ?>
                        </div>
                    <?php else: ?>
                        <div class="col-sm-12 formsearch-option4">
                            <?php kt_search_form();  ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endif;
    }
}
add_action( 'kt_show_menu_option_7', 'kt_show_vertical_menu_option_7' );
    

