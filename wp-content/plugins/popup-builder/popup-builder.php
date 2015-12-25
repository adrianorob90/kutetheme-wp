<?php
/**
 * Plugin Name: Popup Builder
 * Plugin URI: http://sygnoos.com
 * Description: The most complete popup plugin. Html, image, iframe, shortcode, video and many other popup types. Manage popup dimensions, effects, themes and more.
 * Version: 2.1.3
 * Author: Sygnoos
 * Author URI: http://www.sygnoos.com
 * License: GPLv2
 */

//create some difine Pats
define("SG_APP_POPUP_PATH", dirname(__FILE__));
define('SG_APP_POPUP_URL', plugins_url('', __FILE__));
define('SG_APP_POPUP_ADMIN_URL', admin_url());
define('SG_APP_POPUP_FILE', plugin_basename(__FILE__));
define('SG_APP_POPUP_FILES', SG_APP_POPUP_PATH . '/files');
define('SG_APP_POPUP_CLASSES', SG_APP_POPUP_PATH . '/classes');
define('SG_APP_POPUP_JS', SG_APP_POPUP_PATH . '/javascript');
define('SG_APP_POPUP_TABLE_LIMIT', 15);
define('SG_POPUP_VERSION', 2.12);
define('SG_POPUP_PRO', 0);
define('SG_POPUP_PRO_URL', 'http://sygnoos.com/wordpress-popup/');

$POPUP_TITLES = array(
	'image' => 'Image',
	'html' => 'HTML',
	'fblike' => 'Facebook',
	'iframe' => 'Iframe',
	'video' => 'Video',
	'shortcode' => 'Shortcode',
	'ageRestriction' => 'Age Restriction',
	'countdown' => 'Countdown',
	'social' => 'Social',
	'exitIntent' => 'Exit Intent'
);

require_once( SG_APP_POPUP_CLASSES .'/SGPopup.php');
require_once(SG_APP_POPUP_FILES .'/sg_functions.php');
require_once( SG_APP_POPUP_CLASSES .'/PopupInstaller.php'); //cretae tables
if (SG_POPUP_PRO) {
	require_once( SG_APP_POPUP_CLASSES .'/PopupProInstaller.php'); //uninstall tables
}
require_once( SG_APP_POPUP_PATH .'/style/sg_popup_style.php' ); //include our css file
require_once( SG_APP_POPUP_JS .'/sg_popup_javascript.php' ); //include our js file
require_once( SG_APP_POPUP_FILES .'/sg_popup_page_selection.php' );  // include here in page  button for select popup every page

register_activation_hook(__FILE__, 'sgPopupActivate');
register_uninstall_hook(__FILE__, 'sgPopupDeactivate');
//register_deactivation_hook(__FILE__, 'sgPopupDeactivate');


add_action('wpmu_new_blog', 'sgNewBlogPopup', 10, 6);

function sgNewBlogPopup()
{
	PopupInstaller::install();
	if (SG_POPUP_PRO) {
		PopupProInstaller::install();
	}
}

function sgPopupActivate()
{
	update_option('SG_POPUP_VERSION', SG_POPUP_VERSION);
	PopupInstaller::install();
	if (SG_POPUP_PRO) {
		PopupProInstaller::install();
	}
}

function sgPopupDeactivate()
{
	PopupInstaller::uninstall();
	if (SG_POPUP_PRO) {
		PopupProInstaller::uninstall();
	}

}


add_action("admin_menu","sgAddMenu");
function sgAddMenu()
{
	add_menu_page("Popup Builder", "Popup Builder", "manage_options","PopupBuilder","sgPopupMenu","dashicons-welcome-widgets-menus");
	add_submenu_page("PopupBuilder", "All Popups", "All Popups", 'manage_options', "PopupBuilder", "sgPopupMenu");
	add_submenu_page("PopupBuilder", "Add New", "Add New", 'manage_options', "create-popup", "sgCreatePopup");
	add_submenu_page("PopupBuilder", "Edit Popup", "Edit Popup", 'manage_options', "edit-popup", "sgEditPopup");
}

function sgPopupMenu()
{
	require_once( SG_APP_POPUP_FILES . '/sg_popup_main.php');
}

function sgCreatePopup()
{
	require_once( SG_APP_POPUP_FILES . '/sg_popup_create.php'); // here is inculde file in the first sub menu
}

function sgEditPopup()
{
	require_once( SG_APP_POPUP_FILES . '/sg_popup_create_new.php');
}

function sgRegisterScripts()
{
	SGPopup::$registeredScripts = true;
	wp_register_style('sg_animate', SG_APP_POPUP_URL . '/style/animate.css');
	wp_enqueue_style('sg_animate');
	wp_register_script('sg_popup_frontend', SG_APP_POPUP_URL . '/javascript/sg_popup_frontend.js', array('jquery'));
	wp_enqueue_script('sg_popup_frontend');
	wp_enqueue_script('jquery');
	wp_register_script('sg_cookie', SG_APP_POPUP_URL . '/javascript/jquery.cookie.js', array('jquery'));
	wp_enqueue_script('sg_cookie');
	wp_register_script('sg_colorbox', SG_APP_POPUP_URL . '/javascript/jquery.sgcolorbox-min.js', array('jquery'), '5.0');
	wp_enqueue_script('sg_colorbox');
	if (SG_POPUP_PRO) {
		wp_register_script('sgPopupPro', SG_APP_POPUP_URL . '/javascript/sg_popup_pro.js?ver=4.2.3');
		wp_enqueue_script('sgPopupPro');
		//echo "<script type='text/javascript' src = ".SG_APP_POPUP_URL."/javascript/sg_popup_pro.js?ver=4.2.3'></script>";
	}
	echo "<script type='text/javascript'>SG_POPUP_DATA = [];SG_APP_POPUP_URL = '".SG_APP_POPUP_URL."';</script>";
}

function sgRenderPopupScript($id)
{
	if (SGPopup::$registeredScripts==false) {
		sgRegisterScripts();
	}
	wp_register_style('sg_colorbox_theme', SG_APP_POPUP_URL . "/style/sgcolorbox/colorbox1.css");
	wp_register_style('sg_colorbox_theme2', SG_APP_POPUP_URL . "/style/sgcolorbox/colorbox2.css");
	wp_register_style('sg_colorbox_theme3', SG_APP_POPUP_URL . "/style/sgcolorbox/colorbox3.css");
	wp_register_style('sg_colorbox_theme4', SG_APP_POPUP_URL . "/style/sgcolorbox/colorbox4.css");
	wp_register_style('sg_colorbox_theme5', SG_APP_POPUP_URL . "/style/sgcolorbox/colorbox5.css", array(), '5.0');
	wp_enqueue_style('sg_colorbox_theme');
	wp_enqueue_style('sg_colorbox_theme2');
	wp_enqueue_style('sg_colorbox_theme3');
	wp_enqueue_style('sg_colorbox_theme4');
	wp_enqueue_style('sg_colorbox_theme5');
	sgFindPopupData($id);
}

function sgFindPopupData($id)
{
	$obj = SGPopup::findById($id);
	if (!empty($obj)) {
		$content = $obj->render();
	}
	echo "<script type='text/javascript'>";
	echo $content;
	echo "</script>";
}

function sgShowShortCode($args, $content)
{
	ob_start();
	$obj = SGPopup::findById($args['id']);
	if (!$obj) {
		return $content;
	}
	if(!empty($content)) {
		sgRenderPopupScript($args['id']);
		echo "<a href='javascript:void(0)' class='sg-show-popup' data-sgpopupid=".$args['id'].">".$content."</a>";
	}
	else {
		echo sgRenderPopupOpen($args['id']);
	}
	$shortcodeContent = ob_get_contents();
	ob_end_clean();
	return $shortcodeContent;
}
add_shortCode('sg_popup', 'sgShowShortCode');

function sgRenderPopupOpen($popupId)
{
	sgRenderPopupScript($popupId);

	echo "<script type=\"text/javascript\">

			sgAddEvent(window, 'load',function() {
				sgOnScrolling = (SG_POPUP_DATA [$popupId]['onScrolling']) ? SG_POPUP_DATA [$popupId]['onScrolling']: ''; ;
				beforeScrolingPrsent = (SG_POPUP_DATA [$popupId]['onScrolling']) ?  SG_POPUP_DATA [$popupId]['beforeScrolingPrsent']: '';
				autoClosePopup = (SG_POPUP_DATA [$popupId]['autoClosePopup']) ?  SG_POPUP_DATA [$popupId]['autoClosePopup']: '';
				popupClosingTimer = (SG_POPUP_DATA [$popupId]['popupClosingTimer']) ?  SG_POPUP_DATA [$popupId]['popupClosingTimer']: '';
				sgPoupFrontendObj = new SGPopup();
				if(sgOnScrolling) {
					sgPoupFrontendObj.onScrolling($popupId);
				}
				else {

					sgPoupFrontendObj.showPopup($popupId,true);
				}
			});
		</script>";
}

function sgOnloadPopup()
{
	$sgOnloadPopupId = get_option('SG_POPUP_ONLOAD_ID');
	if($sgOnloadPopupId) {
		sgRenderPopupOpen($sgOnloadPopupId);
	}
	$page = get_queried_object_id ();
	$popup = "sg_promotional_popup";
	$popupId = SGPopup::getPagePopupId($page,$popup);
	if (!$popupId) {
		return;
	}
	sgRenderPopupOpen($popupId);
}

add_action('wp_head','sgOnloadPopup');
require_once( SG_APP_POPUP_FILES . '/sg_popup_media_button.php');
require_once( SG_APP_POPUP_FILES . '/sg_popup_save.php'); // saving form data
require_once( SG_APP_POPUP_FILES . '/sg_popup_ajax.php');


function sgPopupPluginLoaded()
{
	$versionPopup = get_option('SG_POPUP_VERSION');
	if (!$versionPopup || $versionPopup < SG_POPUP_VERSION ) {
		update_option('SG_POPUP_VERSION', SG_POPUP_VERSION);
		PopupInstaller::install();
	}
}

add_action('plugins_loaded', 'sgPopupPluginLoaded');
