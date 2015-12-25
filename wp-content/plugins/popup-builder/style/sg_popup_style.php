<?php
function sg_popup_admin_style($hook) {
	if ('toplevel_page_PopupBuilder' != $hook && 'popup-builder_page_create-popup' != $hook && 'popup-builder_page_edit-popup' != $hook && 'popup-builder_page_sgPopupMenu' != $hook) {
        return;
    }
	wp_register_style('sg_popup_style', SG_APP_POPUP_URL . '/style/sg_popup_style.css', false, '1.0.0');
	wp_enqueue_style('sg_popup_style');
	wp_register_style('sg_popup_animate', SG_APP_POPUP_URL . '/style/animate.css');
	wp_enqueue_style('sg_popup_animate');
	if (SG_POPUP_PRO) {
		wp_register_style('font_awesome', SG_APP_POPUP_URL . "/style/jssocial/font-awesome.min.css");
		wp_enqueue_style('font_awesome');
		wp_register_style('jssocials_main_css', SG_APP_POPUP_URL . "/style/jssocial/jssocials.css");
		wp_enqueue_style('jssocials_main_css');
		wp_register_style('jssocials_theme_tm', SG_APP_POPUP_URL . "/style/jssocial/jssocials-theme-classic.css");
		wp_enqueue_style('jssocials_theme_tm');
		wp_register_style('sg_flipclock_css', SG_APP_POPUP_URL . "/style/sg_flipclock.css");
		wp_enqueue_style('sg_flipclock_css');
		wp_register_style('sg_jqueryUi_css', SG_APP_POPUP_URL . "/style/jquery-ui.min.css");
		wp_enqueue_style('sg_jqueryUi_css');
	}
}
add_action('admin_enqueue_scripts', 'sg_popup_admin_style');

function sg_popup_style($hook) {
	if ('admin.php' != $hook) {
		return;
	}
	wp_register_style('sg_popup_animate', SG_APP_POPUP_URL . '/style/animate.css');
	wp_enqueue_style('sg_popup_animate');

	wp_register_style('sg_popup_style', SG_APP_POPUP_URL . '/style/sg_popup_style.css', false, '1.0.0');
	wp_enqueue_style('sg_popup_style');
}

add_action('admin_enqueue_scripts', 'sg_popup_style');
add_action( 'admin_enqueue_scripts', 'mw_enqueue_color_picker' );
function mw_enqueue_color_picker( $hook_suffix ) {
	if('popup-builder_page_edit-popup' != $hook_suffix)  {
		return;
	}
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'sg_libs_handle', plugins_url('javascript/sg_datapickers.js',dirname(__FILE__)), array( 'wp-color-picker' ));
}