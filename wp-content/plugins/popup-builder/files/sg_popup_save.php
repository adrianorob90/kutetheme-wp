<?php
add_action('admin_post_save_popup', 'sgPopupSave');

function sgSanitize($optionsKey)
{
	if (isset($_POST[$optionsKey])) {
		if ($optionsKey == "sg_popup_html"||
			$optionsKey == 'sg_ageRestriction'||
			$optionsKey =='sg_countdown'||
			$optionsKey =='iframe'||
			$optionsKey =='sg_social' ||
			$optionsKey =="sg-exit-intent" ||
			$optionsKey =="sg_popup_fblike"
			) {
			if(SG_POPUP_PRO) {
				$sgPopupData = $_POST[$optionsKey];
				require_once(SG_APP_POPUP_FILES ."/sg_popup_pro.php");
				return SgPopupPro::sgPopupDataSanitize($sgPopupData);
			}
			return wp_kses_post($_POST[$optionsKey]);
		}
		return sanitize_text_field($_POST[$optionsKey]);
	}
	else {
		return "";
	}
}

function sgPopupSave()
{
	global $wpdb;
	$socialButtons = array();
	$socialOptions = array();
	$countdownOptions = array();
	$fblikeOptions = array();
	$options = array();
	$showAllPages = sgSanitize('allPages');

	$socialOptions = array(
		'sgSocialTheme' => sgSanitize('sgSocialTheme'),
		'sgSocialButtonsSize' => sgSanitize('sgSocialButtonsSize'),
		'sgSocialLabel' => sgSanitize('sgSocialLabel'),
		'sgSocialShareCount' => sgSanitize('sgSocialShareCount'),
		'sgRoundButton' => sgSanitize('sgRoundButton'),
		'fbShareLabel' => sgSanitize('fbShareLabel'),
		'lindkinLabel' => sgSanitize('lindkinLabel'),
		'sgShareUrl' => sgSanitize('sgShareUrl'),
		'shareUrlType' => sgSanitize('shareUrlType'),
		'googLelabel' => sgSanitize('googLelabel'),
		'twitterLabel' => sgSanitize('twitterLabel'),
		'pinterestLabel' => sgSanitize('pinterestLabel'),
		'sgMailSubject' => sgSanitize('sgMailSubject'),
		'sgMailLable' => sgSanitize('sgMailLable')
	);

	$socialButtons = array(
		'sgTwitterStatus' => sgSanitize('sgTwitterStatus'),
		'sgFbStatus' => sgSanitize('sgFbStatus'),
		'sgEmailStatus' => sgSanitize('sgEmailStatus'),
		'sgLinkedinStatus' => sgSanitize('sgLinkedinStatus'),
		'sgGoogleStatus' => sgSanitize('sgGoogleStatus'),
		'sgPinterestStatus' => sgSanitize('sgPinterestStatus'),
		'pushToBottom' => sgSanitize('pushToBottom')
	);

	$countdownOptions = array(
		'pushToBottom' => sgSanitize('pushToBottom'),
		'countdownNumbersBgColor' => sgSanitize('countdownNumbersBgColor'),
		'countdownNumbersTextColor' => sgSanitize('countdownNumbersTextColor'),
		'sg-due-date' => sgSanitize('sg-due-date'),
		'countdown-position' => sgSanitize('countdown-position'),
		'counts-language'=> sgSanitize('counts-language'),
		'sg-time-zone' => sgSanitize('sg-time-zone'),
		'sg-countdown-type' => sgSanitize('sg-countdown-type'),
	);

	$videoOptions = array(
		'video-autoplay' => sgSanitize('video-autoplay')
	);

	$exitIntentOptions = array(
		"exit-intent-type" => sgSanitize('exit-intent-type'),
		"exit-intent-expire-time" => sgSanitize('exit-intent-expire-time'),
		"exit-intent-alert" => sgSanitize('exit-intent-alert')
	);

	$fblikeOptions = array(
		"fblike-like-url" => sgSanitize("fblike-like-url"),
		"fblike-layout" => sgSanitize("fblike-layout")
	);

	$options = array(
		'width' => sgSanitize('width'),
		'height' => sgSanitize('height'),
		'delay' => (int)sgSanitize('delay'),
		'duration' => (int)sgSanitize('duration'),
		'effect' => sgSanitize('effect'),
		'escKey' => sgSanitize('escKey'),
		'scrolling' => sgSanitize('scrolling'),
		'reposition' => sgSanitize('reposition'),
		'overlayClose' => sgSanitize('overlayClose'),
		'contentClick' => sgSanitize('contentClick'),
		'opacity' => sgSanitize('opacity'),
		'sgOverlayColor' => sgSanitize('sgOverlayColor'),
		'popupFixed' => sgSanitize('popupFixed'),
		'fixedPostion' => sgSanitize('fixedPostion'),
		'maxWidth' => sgSanitize('maxWidth'),
		'maxHeight' => sgSanitize('maxHeight'),
		'initialWidth' => sgSanitize('initialWidth'),
		'initialHeight' => sgSanitize('initialHeight'),
		'closeButton' => sgSanitize('closeButton'),
		'theme' => sgSanitize('theme'),
		'onScrolling' => sgSanitize('onScrolling'),
		'beforeScrolingPrsent' => (int)sgSanitize('beforeScrolingPrsent'),
		'forMobile' => sgSanitize('forMobile'),
		'openMobile' => sgSanitize('openMobile'), // open only for mobile
		'repeatPopup' => sgSanitize('repeatPopup'),
		'autoClosePopup' => sgSanitize('autoClosePopup'),
		'disablePopup' => sgSanitize('disablePopup'),
		'popupClosingTimer' => sgSanitize('popupClosingTimer'),
		'yesButtonLabel' => sgSanitize('yesButtonLabel'),
		'noButtonLabel' => sgSanitize('noButtonLabel'),
		'restrictionUrl' => sgSanitize('restrictionUrl'),
		'yesButtonBackgroundColor' => sgSanitize('yesButtonBackgroundColor'),
		'noButtonBackgroundColor' => sgSanitize('noButtonBackgroundColor'),
		'yesButtonTextColor' => sgSanitize('yesButtonTextColor'),
		'noButtonTextColor' => sgSanitize('noButtonTextColor'),
		'yesButtonRadius' => (int)sgSanitize('yesButtonRadius'),
		'noButtonRadius' => (int)sgSanitize('noButtonRadius'),
		'pushToBottom' => sgSanitize('pushToBottom'),
		'socialButtons' => json_encode($socialButtons),
		'socialOptions' => json_encode($socialOptions),
		'countdownOptions' => json_encode($countdownOptions),
		'exitIntentOptions' => json_encode($exitIntentOptions),
		'videoOptions' => json_encode($videoOptions),
		'fblikeOptions' => json_encode($fblikeOptions)
	);

	$html = stripslashes(sgSanitize("sg_popup_html"));
	$fblike = stripslashes(sgSanitize("sg_popup_fblike"));
	$ageRestriction = stripslashes(sgSanitize('sg_ageRestriction'));
	$social = stripslashes(sgSanitize('sg_social'));
	$image = sgSanitize('ad_image');
	$countdown = stripslashes(sgSanitize('sg_countdown'));
	$iframe = sgSanitize('iframe');
	$video = sgSanitize('video');
	$shortCode = stripslashes(sgSanitize('shortcode'));
	$exitIntent = stripslashes(sgSanitize('sg-exit-intent'));
	$type = sgSanitize('type');
	$title = sgSanitize('title');
	$id = sgSanitize('hidden_popup_number');
	$jsonDataArray = json_encode($options);

	$data = array(
		'id' => $id,
		'title' => $title,
		'type' => $type,
		'image' => $image,
		'html' => $html,
		'fblike' => $fblike,
		'iframe' => $iframe,
		'video' => $video,
		'shortcode' => $shortCode,
		'ageRestriction' => $ageRestriction,
		'countdown' => $countdown,
		'exitIntent' => $exitIntent,
		'social' => $social,
		'options' => $jsonDataArray
	);

	function setPopupForAllPages($id, $allPages) {
		if($allPages) {
			update_option('SG_POPUP_ONLOAD_ID', $id);
		}
		else {
			delete_option('SG_POPUP_ONLOAD_ID');
		}
	}
	function setOptionPopupType($id, $type) {
		update_option("SG_POPUP_".strtoupper($type)."_".$id,$id);
	}

	if (empty($title)) {
		wp_redirect(SG_APP_POPUP_ADMIN_URL."admin.php?page=edit-popup&type=$type&titleError=1");
		exit();
	}
	$popupName = "SG".ucfirst(strtolower($_POST['type']));
	$popupClassName = $popupName."Popup";

	require_once(SG_APP_POPUP_PATH ."/classes/".$popupClassName.".php");
	if ($id == "") {
		global $wpdb;
		call_user_func(array($popupClassName, 'create'), $data);
		$lastId = $wpdb->get_var("SELECT LAST_INSERT_ID() FROM ".  $wpdb->prefix."sg_popup");
		setPopupForAllPages($lastId, $showAllPages);
		setOptionPopupType($lastId, $type);
		wp_redirect(SG_APP_POPUP_ADMIN_URL."admin.php?page=edit-popup&id=".$lastId."&type=$type&saved=1");
		exit();
	}
	else {
		$popup = SGPopup::findById($id);
		$popup->setTitle($title);
		$popup->setId($id);
		$popup->setType($type);
		$popup->setOptions($jsonDataArray);

		switch ($popupName) {
			case 'SGImage':
				$popup->setUrl($image);
				break;
			case 'SGIframe':
				$popup->setUrl($iframe);
				break;
			case 'SGVideo':
				$popup->setUrl($video);
				$popup->setRealUrl($video);
				$popup->setVideoOptions(json_encode($videoOptions));
				break;
			case 'SGHtml':
				$popup->setContent($html);
				break;
			case 'SGFblike':
				$popup->setContent($fblike);
				$popup->setFblikeOptions(json_encode($fblikeOptions));
				break;
			case 'SGShortcode':
				$popup->setShortcode($shortCode);
				break;
			case 'SGAgerestriction':
				$popup->setContent($ageRestriction);
				$popup->setYesButton($options['yesButtonLabel']);
				$popup->setNoButton($options['noButtonLabel']);
				$popup->setRestrictionUrl($options['restrictionUrl']);
				break;
			case 'SGCountdown':
				$popup->setCountdownContent($countdown);
				$popup->setCountdownOptions(json_encode($countdownOptions));
				break;
			case 'SGSocial':
				$popup->setSocialContent($social);
				$popup->setButtons(json_encode($socialButtons));
				$popup->setSocialOptions(json_encode($socialOptions));
				break;
			case 'SGExitintent':
				$popup->setContent($exitIntent);
				$popup->setExitIntentOptions(json_encode($exitIntentOptions));
				break;
		}
		setPopupForAllPages($id, $showAllPages);
		setOptionPopupType($id, $type);
		$popup->save();
		wp_redirect(SG_APP_POPUP_ADMIN_URL."admin.php?page=edit-popup&id=$id&type=$type&saved=1");
		exit();
	}
}
