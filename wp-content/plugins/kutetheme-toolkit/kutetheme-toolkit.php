<?php
/*
  Plugin Name: Kutetheme toolkit
  Plugin URI: http://kutethemes.com/demo/kuteshop/
  Description: A Toolkit for Kute theme
  Author: AngelsIT
  Version: 1.0.0
  Author URI: http://kutethemes.com/demo/kuteshop/
 */
define("KUTETHEME_PLUGIN_PATH", trailingslashit( plugin_dir_path(__FILE__) ) );
define("KUTETHEME_PLUGIN_URL", trailingslashit( plugin_dir_url(__FILE__) ) );


//Mailchimp
require_once KUTETHEME_PLUGIN_PATH.'mailchimp/mailchimp.php';

//CMB2
require_once KUTETHEME_PLUGIN_PATH .'cmb2/init.php';
require_once KUTETHEME_PLUGIN_PATH .'cmb2/kt_header_field_type.php';
require_once KUTETHEME_PLUGIN_PATH .'cmb2/kt_page_field_type.php';
require_once KUTETHEME_PLUGIN_PATH.'option_post_type.php';
require_once KUTETHEME_PLUGIN_PATH .'cmb2/admin.php';

// Woocommerce products filter
//require_once KUTETHEME_PLUGIN_PATH.'woocommerce-products-filter/index.php';

// Post types
require_once KUTETHEME_PLUGIN_PATH.'post-types/post-types.php';

/**
 * Initialising Visual Composer
 * 
 */ 
if ( class_exists( 'Vc_Manager', false ) ) {
    
    if ( ! function_exists( 'js_composer_bridge_admin' ) ) {
		function js_composer_bridge_admin( $hook ) {
			wp_enqueue_style( 'js_composer_bridge', KUTETHEME_PLUGIN_URL . 'js_composer/css/style.css', array() );
		}
	}
    add_action( 'admin_enqueue_scripts', 'js_composer_bridge_admin', 15 );


    require_once KUTETHEME_PLUGIN_PATH.'js_composer/custom-fields.php';
}

//Shortcodes
require_once KUTETHEME_PLUGIN_PATH.'shortcodes.php';

//Product brand
require_once KUTETHEME_PLUGIN_PATH.'brands/product_brand.php';

//Tax Metabox
require_once KUTETHEME_PLUGIN_PATH.'kt_tax_metabox.php';

