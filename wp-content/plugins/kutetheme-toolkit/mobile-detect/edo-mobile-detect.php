<?php 

/********************************************//**
* PHP Mobile Detect class used to detect browser or device type
***********************************************/
require_once('mobile-detect.php');

$detect = new Mobile_Detect();

/********************************************//**
* Returns true when on desktops or tablets
***********************************************/
function edo_is_notphone() {
	global $detect;
	if( ! $detect->isMobile() || $detect->isTablet() ) return true;
}

/********************************************//**
* Returns true when on desktops or phones
***********************************************/
function edo_is_nottab() {
	global $detect;
	if( ! $detect->isTablet() ) return true;
}

/********************************************//**
* Returns true when on desktops only
***********************************************/
function edo_is_notdevice() {
	global $detect;
	if( ! $detect->isMobile() && ! $detect->isTablet() ) return true;
}

/********************************************//**
* Returns true when on phones ONLY
***********************************************/
function edo_is_phone() {
	global $detect;
	if( $detect->isMobile() && ! $detect->isTablet() ) return true;
}



/********************************************//**
* Returns true when on Tablets ONLY
***********************************************/
function edo_is_tablet() {
	global $detect;
	if( $detect->isTablet() ) return true;
}


/********************************************//**
* Returns true when on phones or tablets but NOT destkop
***********************************************/
function edo_is_device() {
	global $detect;
	if( $detect->isMobile() || $detect->isTablet() ) return true;
}

/********************************************//**
* Returns true when on iOS
***********************************************/
function edo_is_ios() {
	global $detect;
	if( $detect->isiOS() ) return true;
}

/********************************************//**
* Returns true when on iPhone
***********************************************/
function edo_is_iphone() {
	global $detect;
	if( $detect->isiPhone() ) return true;
}

/********************************************//**
* Returns true when on iPad
***********************************************/
function edo_is_ipad() {
	global $detect;
	if( $detect->isiPad() ) return true;
}

/********************************************//**
* Returns true when on Android OS
***********************************************/
function edo_is_android() {
	global $detect;
	if( $detect->isAndroidOS() ) return true;
}



/********************************************//**
* Returns true when on a Blackberry device
***********************************************/
function edo_is_blackberry() {
	global $detect;
	if( $detect->isBlackBerry() ) return true;
}


/********************************************//**
* Returns true when on Windows OS
***********************************************/
function edo_is_windows_mobile() {
	global $detect;
	if( $detect->isWindowsMobileOS() ) return true;
}



/********************************************//**
* Returns true when in a Chrome browser
***********************************************/
function edo_is_chrome_browser() {
	global $detect;
	if( $detect->isChrome() ) return true;
}


/********************************************//**
* Returns true when in a Opera browser
***********************************************/
function edo_is_opera_browser() {
	global $detect;
	if( $detect->isOpera() ) return true;
}


/********************************************//**
* Returns true when in a IE browser
***********************************************/
function edo_is_ie_browser() {
	global $detect;
	if( $detect->isIE() ) return true;
}

/********************************************//**
* Returns true when in a Firefox browser
***********************************************/
function edo_is_firefox_browser() {
	global $detect;
	if( $detect->isFirefox() ) return true;
}

/********************************************//**
* Returns true when in a Safari browser
***********************************************/
function edo_is_safari_browser() {
	global $detect;
	if( $detect->isSafari() ) return true;
}

