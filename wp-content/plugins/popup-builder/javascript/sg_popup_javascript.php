<?php

function sg_set_admin_url($hook) {
	if ('popup-builder_page_create-popup' == $hook) {
		echo '<script type="text/javascript">SG_ADMIN_URL = "'.admin_url()."admin.php?page=create-popup".'";</script>';
	}
}

function sg_popup_admin_scripts($hook) {

    if ( 'popup-builder_page_edit-popup' == $hook  || 'popup-builder_page_create-popup' == $hook ) {

		wp_enqueue_media();
		wp_register_script('javascript', SG_APP_POPUP_URL . '/javascript/sg_popup_backend.js', array('jquery'));
		wp_enqueue_script('jquery');
		wp_enqueue_script('javascript');

    }
	else if('toplevel_page_PopupBuilder' == $hook){
		wp_register_script('javascript', SG_APP_POPUP_URL . '/javascript/sg_popup_backend.js', array('jquery'));
		wp_enqueue_script('javascript');
		wp_enqueue_script('jquery');
	}
	if('popup-builder_page_edit-popup' == $hook) {
		wp_register_script('sg_popup_rangeslider', SG_APP_POPUP_URL . '/javascript/sg_popup_rangeslider.js', array('jquery'));
		wp_enqueue_script('sg_popup_rangeslider');
		wp_enqueue_script('jquery');

		wp_enqueue_script('jquery-ui-datepicker');

	}
}

function SgFrontendScripts() {
	wp_enqueue_script('sg_popup_core', plugins_url('/sg_popup_core.js', __FILE__), '1.0.0', true);
}

add_action('admin_enqueue_scripts', 'sg_set_admin_url');
add_action('admin_enqueue_scripts', 'sg_popup_admin_scripts');
add_action('wp_enqueue_scripts', 'SgFrontendScripts');


