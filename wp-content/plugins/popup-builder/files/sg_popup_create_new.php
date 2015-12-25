<?php
	$popupType = @$_GET['type'];
	if (!$popupType) {
		$popupType = 'html';
	}
	$popupName = "SG".ucfirst(strtolower($popupType));
	$popupClassName = $popupName."Popup";
	require_once(SG_APP_POPUP_PATH ."/classes/".$popupClassName.".php");
	$obj = new $popupClassName();
	if (isset($_GET['id'])) {
		$id = (int)$_GET['id'];
	 	$result = call_user_func(array($popupClassName, 'findById'), $id);
	 	if (!$result) {
	 		wp_redirect(SG_APP_POPUP_ADMIN_URL."page=edit-popup&type=".$popupType."");
	 	}

		switch ($popupType) {
			case 'iframe':
				$sgPopupDataIframe = $result->getUrl();
				break;
			case 'video':
				$sgPopupDataVideo = $result->getRealUrl();
				break;
			case 'image':
				$sgPopupDataImage = $result->getUrl();
				break;
			case 'html':
				$sgPopupDataHtml = $result->getContent();
				break;
			case 'fblike':
				$sgPopupDataFblike = $result->getContent();
				$sgFlikeOptions = $result->getFblikeOptions();
				break;
			case 'shortcode':
				$sgPopupDataShortcode = $result->getShortcode();
				break;
			case 'ageRestriction':
				$sgPopupAgeRestriction = ($result->getContent());
				$sgYesButton = sgSafeStr($result->getYesButton());
				$sgNoButton = sgSafeStr($result->getNoButton());
				$sgRestrictionUrl = sgSafeStr($result->getRestrictionUrl());
				break;
			case 'countdown':
				$sgCoundownContent = $result->getCountdownContent();
				$countdownOptions = json_decode(sgSafeStr($result->getCountdownOptions()),true);
				$sgCountdownNumbersBgColor = $countdownOptions['countdownNumbersBgColor'];
				$sgCountdownNumbersTextColor = $countdownOptions['countdownNumbersTextColor'];
				$sgDueData = $countdownOptions['sg-due-date'];
				@$sgGetCountdownType = $countdownOptions['sg-countdown-type'];
				$sgCountdownLang = $countdownOptions['counts-language'];
				$sgCountdownPosition = $countdownOptions['coundown-position'];
				@$sgSelectedTimeZone = $countdownOptions['sg-time-zone'];
				break;
			case 'social':
				$sgSocialContent = ($result->getSocialContent());
				$sgSocialButtons  = sgSafeStr($result->getButtons());
				$sgSocialOptions = sgSafeStr($result->getSocialOptions());
				break;
		}

		$title = $result->getTitle();
		$jsonData = json_decode($result->getOptions(), true);
		$sgEscKey = @$jsonData['escKey'];
		$sgScrolling = @$jsonData['scrolling'];
		$sgCloseButton = @$jsonData['closeButton'];
		$sgReposition = @$jsonData['reposition'];
		$sgOverlayClose = @$jsonData['overlayClose'];
		$sgOverlayColor = @$jsonData['sgOverlayColor'];
		$sgContentClick = @$jsonData['contentClick'];
		$sgOpacity = @$jsonData['opacity'];
		$sgPopupFixed = @$jsonData['popupFixed'];
		$sgFixedPostion = @$jsonData['fixedPostion'];
		$sgOnScrolling = @$jsonData['onScrolling'];
		$beforeScrolingPrsent = @$jsonData['beforeScrolingPrsent'];
		$duration = @$jsonData['duration'];
		$delay = @$jsonData['delay'];
		$effect =@$jsonData['effect'];
		$sgInitialWidth = @$jsonData['initialWidth'];
		$sgInitialHeight = @$jsonData['initialHeight'];
		$sgWidth = @$jsonData['width'];
		$sgHeight = @$jsonData['height'];
		$sgMaxWidth = @$jsonData['maxWidth'];
		$sgMaxHeight = @$jsonData['maxHeight'];
		$sgForMobile = @$jsonData['forMobile'];
		$sgAllPages = @$jsonData['allPages'];
		$sgRepeatPopup = @$jsonData['repeatPopup'];
		$sgDisablePopup = @$jsonData['disablePopup'];
		$sgPopupClosingTimer = @$jsonData['popupClosingTimer'];
		$sgAutoClosePopup = @$jsonData['autoClosePopup'];
		$sgColorboxTheme = @$jsonData['theme'];
		$sgRestrictionAction = @$jsonData['restrictionAction'];
		$yesButtonBackgroundColor = @sgSafeStr($jsonData['yesButtonBackgroundColor']);
		$noButtonBackgroundColor = @sgSafeStr($jsonData['noButtonBackgroundColor']);
		$yesButtonTextColor = @sgSafeStr($jsonData['yesButtonTextColor']);
		$noButtonTextColor = @sgSafeStr($jsonData['noButtonTextColor']);
		$yesButtonRadius = @sgSafeStr($jsonData['yesButtonRadius']);
		$noButtonRadius = @sgSafeStr($jsonData['noButtonRadius']);
		$sgSocialOptions = json_decode(@$sgSocialOptions,true);
		$sgShareUrl = $sgSocialOptions['sgShareUrl'];
		$shareUrlType = @sgSafeStr($sgSocialOptions['shareUrlType']);
		$fbShareLabel = @sgSafeStr($sgSocialOptions['fbShareLabel']);
		$lindkinLabel = @sgSafeStr($sgSocialOptions['lindkinLabel']);
		$googLelabel = @sgSafeStr($sgSocialOptions['googLelabel']);
		$twitterLabel = @sgSafeStr($sgSocialOptions['twitterLabel']);
		$pinterestLabel = @sgSafeStr($sgSocialOptions['pinterestLabel']);
		$sgMailSubject = @sgSafeStr($sgSocialOptions['sgMailSubject']);
		$sgMailLable = @sgSafeStr($sgSocialOptions['sgMailLable']);
		$sgSocialButtons = json_decode(@$sgSocialButtons,true);
		$sgTwitterStatus = @sgSafeStr($sgSocialButtons['sgTwitterStatus']);
		$sgFbStatus = @sgSafeStr($sgSocialButtons['sgFbStatus']);
		$sgEmailStatus = @sgSafeStr($sgSocialButtons['sgEmailStatus']);
		$sgLinkedinStatus = @sgSafeStr($sgSocialButtons['sgLinkedinStatus']);
		$sgGoogleStatus = @sgSafeStr($sgSocialButtons['sgGoogleStatus']);
		$sgPinterestStatus = @sgSafeStr($sgSocialButtons['sgPinterestStatus']);
		$sgSocialTheme = @sgSafeStr($sgSocialOptions['sgSocialTheme']);
		$sgSocialButtonsSize = @sgSafeStr($sgSocialOptions['sgSocialButtonsSize']);
		$sgSocialLabel = @sgSafeStr($sgSocialOptions['sgSocialLabel']);
		$sgSocialShareCount = @sgSafeStr($sgSocialOptions['sgSocialShareCount']);
		$sgRoundButton = @sgSafeStr($sgSocialOptions['sgRoundButton']);
		$sgPushToBottom = @sgSafeStr($jsonData['pushToBottom']);
		$sgFlikeOptions = json_decode(@$sgFlikeOptions, true);
		$sgFblikeurl = @$sgFlikeOptions['fblike-like-url'];
		$sgFbLikeLayout = @$sgFlikeOptions['fblike-layout'];
	}


	$sgPopup = array(
		'escKey'=> true,
		'closeButton' => true,
		'scrolling'=> true,
		'opacity'=>0.8,
		'reposition' => true,
		'width' => false,
		'height' => false,
		'initialWidth' => '300',
		'initialHeight' => '100',
		'maxWidth' => false,
		'maxHeight' => false,
		'overlayClose' => true,
		'contentClick'=>false,
		'fixed' => false,
		'top' => false,
		'right' => false,
		'bottom' => false,
		'left' => false,
		'duration' => 1,
		'delay' => 0,
	);

	$popupProDefaultValues = array(
		'closeType' => false,
		'onScrolling' => false,
		'forMobile' => false,
		'repetPopup' => false,
		'disablePopup' => false,
		'autoClosePopup' => false,
		'fbStatus' => true,
		'twitterStatus' => true,
		'emailStatus' => true,
		'linkedinStatus' => true,
		'googleStatus' => true,
		'pinterestStatus' => true,
		'sgSocialLabel'=>true,
		'roundButtons'=>false,
		'sgShareUrl' => 'http//',
		'pushToBottom' => true,
		'allPages' => false,
		'countdownNumbersTextColor' => '',
		'countdownNumbersBgColor' => '',
		'countDownLang' => 'English',
		'countdown-position' => true,
		'time-zone' => 'Etc/GMT',
		'due-date' => date('Y-m-d', strtotime(' +1 day'))
	);

	$escKey = sgBoolToChecked($sgPopup['escKey']);
	$closeButton = sgBoolToChecked($sgPopup['closeButton']);
	$scrolling = sgBoolToChecked($sgPopup['scrolling']);
	$reposition	= sgBoolToChecked($sgPopup['reposition']);
	$overlayClose = sgBoolToChecked($sgPopup['overlayClose']);
	$contentClick = sgBoolToChecked($sgPopup['contentClick']);

	$closeType = sgBoolToChecked($popupProDefaultValues['closeType']);
	$onScrolling = sgBoolToChecked($popupProDefaultValues['onScrolling']);
	$forMobile = sgBoolToChecked($popupProDefaultValues['forMobile']);
	$repetPopup = sgBoolToChecked($popupProDefaultValues['repetPopup']);
	$disablePopup = sgBoolToChecked($popupProDefaultValues['disablePopup']);
	$autoClosePopup = sgBoolToChecked($popupProDefaultValues['autoClosePopup']);
	$fbStatus = sgBoolToChecked($popupProDefaultValues['fbStatus']);
	$twitterStatus = sgBoolToChecked($popupProDefaultValues['twitterStatus']);
	$emailStatus = sgBoolToChecked($popupProDefaultValues['emailStatus']);
	$linkedinStatus = sgBoolToChecked($popupProDefaultValues['linkedinStatus']);
	$googleStatus = sgBoolToChecked($popupProDefaultValues['googleStatus']);
	$pinterestStatus = sgBoolToChecked($popupProDefaultValues['pinterestStatus']);
	$socialLabel = sgBoolToChecked($popupProDefaultValues['sgSocialLabel']);
	$roundButtons = sgBoolToChecked($popupProDefaultValues['roundButtons']);
	$shareUrl = $popupProDefaultValues['sgShareUrl'];
	$pushToBottom = sgBoolToChecked($popupProDefaultValues['pushToBottom']);
	$allPages = sgBoolToChecked($popupProDefaultValues['allPages']);
	$countdownNumbersTextColor = $popupProDefaultValues['countdownNumbersTextColor'];
	$countdownNumbersBgColor = $popupProDefaultValues['countdownNumbersBgColor'];
	$countdownLang = $popupProDefaultValues['countDownLang'];
	$countdownPosition = $popupProDefaultValues['countdown-position'];
	$timeZone = $popupProDefaultValues['time-zone'];
	$dueDate = $popupProDefaultValues['due-date'];

	function sgBoolToChecked($var)
	{
		return ($var?'checked':'');
	}

	$width = $sgPopup['width'];
	$height = $sgPopup['height'];
	$opacityValue = $sgPopup['opacity'];
	$top = $sgPopup['top'];
	$right = $sgPopup['right'];
	$bottom = $sgPopup['bottom'];
	$left = $sgPopup['left'];
	$initialWidth = $sgPopup['initialWidth'];
	$initialHeight = $sgPopup['initialHeight'];
	$maxWidth = $sgPopup['maxWidth'];
	$maxHeight = $sgPopup['maxHeight'];
	$deafultFixed = $sgPopup['fixed'];
	$defaultDuration = $sgPopup['duration'];
	$defaultDelay = $sgPopup['delay'];

	$sgCloseButton = @sgSetChecked($sgCloseButton, $closeButton);
	$sgEscKey = @sgSetChecked($sgEscKey, $escKey);
	$sgContentClick = @sgSetChecked($sgContentClick, $contentClick);
	$sgOverlayClose = @sgSetChecked($sgOverlayClose, $overlayClose);
	$sgReposition = @sgSetChecked($sgReposition, $reposition);
	$sgScrolling = @sgSetChecked($sgScrolling, $scrolling);

	$sgCloseType = @sgSetChecked($sgCloseType, $closeType);
	$sgOnScrolling = @sgSetChecked($sgOnScrolling, $onScrolling);
	$sgForMobile = @sgSetChecked($sgForMobile, $forMobile);
	$sgRepeatPopup = @sgSetChecked($sgRepeatPopup, $repetPopup);
	$sgDisablePopup = @sgSetChecked($sgDisablePopup, $disablePopup);
	$sgAutoClosePopup = @sgSetChecked($sgAutoClosePopup, $autoClosePopup);
	$sgFbStatus = @sgSetChecked($sgFbStatus, $fbStatus);
	$sgTwitterStatus = @sgSetChecked($sgTwitterStatus, $twitterStatus);
	$sgEmailStatus = @sgSetChecked($sgEmailStatus, $emailStatus);
	$sgLinkedinStatus = @sgSetChecked($sgLinkedinStatus, $linkedinStatus);
	$sgGoogleStatus = @sgSetChecked($sgGoogleStatus, $googleStatus);
	$sgPinterestStatus = @sgSetChecked($sgPinterestStatus, $pinterestStatus);
	$sgRoundButtons = @sgSetChecked($sgRoundButton, $roundButtons);
	$sgSocialLabel = @sgSetChecked($sgSocialLabel, $socialLabel);
	$sgPopupFixed = @sgSetChecked($sgPopupFixed, $deafultFixed);
	$sgPushToBottom = @sgSetChecked($sgPushToBottom, $pushToBottom);
	@$sgAllPages = (get_option('SG_POPUP_ONLOAD_ID') && get_option('SG_POPUP_ONLOAD_ID') == $id)? true: false;
	$sgAllPages = @sgSetChecked($sgAllPages, $allPages);
	$sgCountdownPosition = @sgSetChecked($sgCountdownPosition, $countdownPosition);

	function sgSetChecked($optionsParam,$defaultOption)
	{
		if (isset($optionsParam)) {
			if ($optionsParam == '') {
				return '';
			}
			else {
				return 'checked';
			}
		}
		else {
			return $defaultOption;
		}
	}

	$sgOpacity = @sgGetValue($sgOpacity, $opacityValue);
	$sgWidth = @sgGetValue($sgWidth, $width);
	$sgHeight = @sgGetValue($sgHeight, $height);
	$sgInitialWidth = @sgGetValue($sgInitialWidth, $initialWidth);
	$sgInitialHeight = @sgGetValue($sgInitialHeight, $initialHeight);
	$sgMaxWidth = @sgGetValue($sgMaxWidth, $maxWidth);
	$sgMaxHeight = @sgGetValue($sgMaxHeight, $maxHeight);
	$duration = @sgGetValue($duration, $defaultDuration);
	$delay = @sgGetValue($delay, $defaultDelay);
	$sgPopupDataIframe = @sgGetValue($sgPopupDataIframe, 'http://');
	$sgShareUrl = @sgGetValue($sgShareUrl, $shareUrl);
	$sgPopupDataHtml = @sgGetValue($sgPopupDataHtml, '');
	$sgPopupDataImage = @sgGetValue($sgPopupDataImage, '');
	$sgCountdownNumbersTextColor = @sgGetValue($sgCountdownNumbersTextColor, $countdownNumbersTextColor);
	$sgCountdownNumbersBgColor = @sgGetValue($sgCountdownNumbersBgColor, $countdownNumbersBgColor);
	$sgCountdownLang = @sgGetValue($sgCountdownLang, $countdownLang);
	$sgSelectedTimeZone  = @sgGetValue($sgSelectedTimeZone, $timeZone);
	$sgDueData = @sgGetValue($sgDueData, $dueDate);

	function sgGetValue($getedVal,$defValue)
	{
		if (!isset($getedVal)) {
			return $defValue;
		}
		else {
			return $getedVal;
		}
	}

	$radioElements = array(
		array(
			'name'=>'shareUrlType',
			'value'=>'activeUrl',
			'additionalHtml'=>''.'<span>'.'Use active URL'.'</span></span>
							<span class="span-width-static"></span><span class="dashicons dashicons-info scrollingImg sameImageStyle sg-active-url"></span><span class="info-active-url samefontStyle">If this option is active Share URL will be current page URL.</span>'
		),
		array(
			'name'=>'shareUrlType',
			'value'=>'shareUrl',
			'additionalHtml'=>''.'<span>'.'Share url'.'</span></span>'.' <input class="input-width-static sg-active-url" type="text" name="sgShareUrl" value="'.@$sgShareUrl.'">'
		)
	);

	function sgCreateRadioElements($radioElements,$checkedValue)
	{
		$content = '';
		for ($i = 0; $i < count($radioElements); $i++) {
			$checked = '';
			$radioElement = @$radioElements[$i];
			$name = @$radioElement['name'];
			$label = @$radioElement['label'];
			$value = @$radioElement['value'];
			$additionalHtml = @$radioElement['additionalHtml'];
			if ($checkedValue == $value) {
				$checked = 'checked';
			}
			$content .= '<span  class="liquid-width"><input class="radio-btn-fix" type="radio" name="'.$name.'" value="'.$value.'" '.$checked.'>';
			$content .= $additionalHtml."<br>";
		}
		return $content;
	}

	$sgPopupEffects = array(
		'No effect' => 'No Effect',
		'flip' => 'flip',
		'shake' => 'shake',
		'wobble' => 'wobble',
		'swing' => 'swing',
		'flash' => 'flash',
		'bounce' => 'bounce',
		'pulse' => 'pulse',
		'rubberBand' => 'rubberBand',
		'tada' => 'tada',
		'jello' => 'jello',
		'rotateIn' => 'rotateIn',
		'fadeIn' => 'fadeIn'
	);

	$sgPopupTheme = array(
		'colorbox1.css',
		'colorbox2.css',
		'colorbox3.css',
		'colorbox4.css',
		'colorbox5.css'
	);

	$sgFbLikeButtons = array(
		'button' => 'Button',
		'standard' => 'Standard',
		'box_count' => 'Box with count',
		'button_count' => 'Button with count'
	);

	$sgTheme = array(
		'flat' => 'flat',
		'classic' => 'classic',
		'minima' => 'minima',
		'plain' => 'plain'
	);

	$sgThemeSize = array(
		'8' => '8',
		'10' => '10',
		'12' => '12',
		'14' => '14',
		'16' => '16',
		'18' => '18',
		'20' => '20',
		'24' => '24'
	);

	$sgSocialCount = array(
		'true' => 'True',
		'false' => 'False',
		'inside' => 'Inside'
	);

	$sgCountdownType = array(
		1 => 'DD:HH:MM:SS',
		2 => 'DD:HH:MM'
	);

	$sgCountdownlang = array(
		'English' => 'English',
		'German' => 'German',
		'Spanish' => 'Spanish',
		'Arabic' => 'Arabic',
		'Italian' => 'Italian',
		'Italian' => 'Italian',
		'Dutch' => 'Dutch',
		'Norwegian' => 'Norwegian',
		'Portuguese' => 'Portuguese',
		'Russian' => 'Russian',
		'Swedish' => 'Swedish',
		'Chinese' => 'Chinese'
	);
	if(SG_POPUP_PRO) {
		require_once(SG_APP_POPUP_FILES ."/sg_params_arrays.php");
	}

	function sgCreateSelect($options,$name,$selecteOption)
	{
		$selected ='';
		$str = "";
		$checked = "";
		if ($name == 'theme' || $name == 'restrictionAction') {

				$popup_style_name = 'popup_theme_name';
				$firstOption = array_shift($options);
				$i = 1;
				foreach ($options as $key) {
					$checked ='';

					if ($key == $selecteOption) {
						$checked = "checked";
					}
					$i++;
					$str .= "<input type='radio' name=\"$name\" value=\"$key\" $checked class='popup_theme_name' sgPoupNumber=".$i.">";

				}
				if ($checked == ''){
					$checked = "checked";
				}
				$str = "<input type='radio' name=\"$name\" value=\"".$firstOption."\" $checked class='popup_theme_name' sgPoupNumber='1'>".$str;
				return $str;
		}
		else {
			@$popup_style_name = ($popup_style_name) ? $popup_style_name : '';
			$str .= "<select name=$name class=$popup_style_name input-width-static >";
			foreach ($options as $key=>$option) {
				if ($key == $selecteOption) {
					$selected = "selected";
				}
				else {
					$selected ='';
				}
				$str .= "<option value='".$key."' ".$selected."  >$option</potion>";
			}

			$str .="</select>" ;
			return $str;

		}

	}
	if (isset($_GET['saved']) && $_GET['saved']==1) {
		echo '<div id="default-message" class="updated notice notice-success is-dismissible" ><p>Popup updated.</p></div>';
	}
	if (isset($_GET["titleError"])): ?>
		<div class="error notice" id="title-error-message">
			<p>Invalid Title</p>
		</div>
	<?php endif; ?>
<form method="POST" action="<?php echo SG_APP_POPUP_ADMIN_URL;?>admin-post.php" id="add-form">
<input type="hidden" name="action" value="save_popup">
	<div class="crud-wrapper">
		<div class="cereate-title-wrapper">
			<div class="sg-title-crud">
				<?php if (isset($id)): ?>
					<h2>Edit popup</h2>
				<?php else: ?>
					<h2>Create new popup</h2>
				<?php endif; ?>
			</div>
			<div class="button-wrapper">
				<p class="submit">
					<?php if (!SG_POPUP_PRO): ?>
						<input class="crud-to-pro" type="button" value="Upgrade to PRO version" onclick="window.open('<?php echo SG_POPUP_PRO_URL;?>')"><div class="clear"></div>
					<?php endif; ?>
					<input type="submit" id="sg-save-button" class="button-primary" value="<?php echo 'Save Changes'; ?>">
				</p>
			</div>
		</div>
		<div class="clear"></div>
		<div class="general-wrapper">
		<div id="titlediv">
			<div id="titlewrap">
				<input  id="title" class="sg-js-popup-title" type="text" name="title" size="30" value="<?php echo esc_attr(@$title)?>" spellcheck="true" autocomplete="off" required = "required"  placeholder='Enter title here'>
			</div>
		</div>
			<div id="left-main-div">
				<div id="sg-general">
					<div id="post-body" class="metabox-holder columns-2">
						<div id="postbox-container-2" class="postbox-container">
							<div id="normal-sortables" class="meta-box-sortables ui-sortable">
								<div class="postbox popupBuilder_general_postbox sgSameWidthPostBox" style="display: block;">
									<div class="handlediv generalTitle" title="Click to toggle"><br></div>
									<h3 class="hndle ui-sortable-handle generalTitle" style="cursor: pointer"><span>General</span></h3>
									<div class="generalContent sgSameWidthPostBox">
										<?php require_once("main_section/".$popupType.".php");?>
										<input type="hidden" name="type" value="<?php echo $popupType;?>">
										<span class="liquid-width" id="theme-span">Popup theme:</span>
										<?php echo  sgCreateSelect($sgPopupTheme,'theme',esc_html(@$sgColorboxTheme));?>
										<div class="theme1 sg-hide"></div>
										<div class="theme2 sg-hide"></div>
										<div class="theme3 sg-hide"></div>
										<div class="theme4 sg-hide"></div>
										<div class="theme5 sg-hide"></div>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
				<div id="effect">
					<div id="post-body" class="metabox-holder columns-2">
						<div id="postbox-container-2" class="postbox-container">
							<div id="normal-sortables" class="meta-box-sortables ui-sortable">
								<div class="postbox popupBuilder_effect_postbox sgSameWidthPostBox" style="display: block;">
									<div class="handlediv effectTitle" title="Click to toggle"><br></div>
									<h3 class="hndle ui-sortable-handle effectTitle" style="cursor: pointer"><span>Effects</span></h3>
									<div class="effectsContent">
										<span class="liquid-width">Effect type:</span>
										<?php echo  sgCreateSelect($sgPopupEffects,'effect',esc_html(@$effect));?>
										<span class="js-preview-effect"></span>
										<div class="effectWrapper"><div id="effectShow" ></div></div>

										<span  class="liquid-width">Effect duration:</span>
										<input class="input-width-static" type="text" name="duration" value="<?php echo esc_attr($duration); ?>" pattern = "\d+" title="It must be number" /><span class="dashicons dashicons-info contentClick infoImageDuration sameImageStyle"></span><span class="infoDuration samefontStyle">Specify how long the popup appearance animation should take (in sec).</span></br>

										<span  class="liquid-width">Initial delay:</span>
										<input class="input-width-static" type="text" name="delay" value="<?php echo esc_attr($delay);?>"  pattern = "\d+" title="It must be number"/><span class="dashicons dashicons-info contentClick infoImageDelay sameImageStyle"></span><span class="infoDelay samefontStyle">Specify how long the popup appearance should be delayed after loading the page (in sec).</span></br>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>
			<?php require_once("options_section/".$popupType.".php");?>
			</div>
			<div id="right-main-div">
				<div id="right-main">
					<div id="dimentions">
						<div id="post-body" class="metabox-holder columns-2">
							<div id="postbox-container-2" class="postbox-container">
								<div id="normal-sortables" class="meta-box-sortables ui-sortable">
									<div class="postbox popupBuilder_dimention_postbox sgSameWidthPostBox" style="display: block;">
										<div class="handlediv dimentionsTitle" title="Click to toggle"><br></div>
										<h3 class="hndle ui-sortable-handle dimentionsTitle" style="cursor: pointer"><span>Dimensions</span></h3>
										<div class="dimensionsContent">
											<span class="liquid-width">Width:</span>
											<input class="input-width-static" type="text" name="width" value="<?php echo esc_attr($sgWidth); ?>"  pattern = "\d+(([px]+|\%)|)" title="It must be number  + px or %" /><img class='errorInfo' src="<?php echo plugins_url('img/info-error.png', dirname(__FILE__).'../') ?>"><span class="validateError">It must be a number + px or %</span><br>
											<span class="liquid-width">Height:</span>
											<input class="input-width-static" type="text" name="height" value="<?php echo esc_attr($sgHeight);?>" pattern = "\d+(([px]+|\%)|)" title="It must be number  + px or %" /><img class='errorInfo' src="<?php echo plugins_url('img/info-error.png', dirname(__FILE__).'../') ?>"><span class="validateError">It must be a number + px or %</span><br>
											<span class="liquid-width">Max width:</span>
											<input class="input-width-static" type="text" name="maxWidth" value="<?php echo esc_attr($sgMaxWidth);?>"  pattern = "\d+(([px]+|\%)|)" title="It must be number  + px or %" /><img class='errorInfo' src="<?php echo plugins_url('img/info-error.png', dirname(__FILE__).'../') ?>"><span class="validateError">It must be a number + px or %</span><br>
											<span class="liquid-width">Max height:</span>
											<input class="input-width-static" type="text" name="maxHeight" value="<?php echo esc_attr(@$sgMaxHeight);?>"   pattern = "\d+(([px]+|\%)|)" title="It must be number  + px or %" /><img class='errorInfo' src="<?php echo plugins_url('img/info-error.png', dirname(__FILE__).'../') ?>"><span class="validateError">It must be a number + px or %</span><br>
											<span class="liquid-width">Initial width:</span>
											<input class="input-width-static" type="text" name="initialWidth" value="<?php echo esc_attr($sgInitialWidth);?>"  pattern = "\d+(([px]+|\%)|)" title="It must be number  + px or %" /><img class='errorInfo' src="<?php echo plugins_url('img/info-error.png', dirname(__FILE__).'../') ?>"><span class="validateError">It must be a number + px or %</span><br>
											<span class="liquid-width">Initial height:</span>
											<input class="input-width-static" type="text" name="initialHeight" value="<?php echo esc_attr($sgInitialHeight);?>"  pattern = "\d+(([px]+|\%)|)" title="It must be number  + px or %" /><img class='errorInfo' src="<?php echo plugins_url('img/info-error.png', dirname(__FILE__).'../') ?>"><span class="validateError">It must be a number + px or %</span><br>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
					<div id="options">
						<div id="post-body" class="metabox-holder columns-2">
							<div id="postbox-container-2" class="postbox-container">
								<div id="normal-sortables" class="meta-box-sortables ui-sortable">
									<div class="postbox popupBuilder_options_postbox sgSameWidthPostBox" style="display: block;">
										<div class="handlediv optionsTitle" title="Click to toggle"><br></div>
										<h3 class="hndle ui-sortable-handle optionsTitle" style="cursor: pointer"><span>Options</span></h3>
										<div class="optionsContent">
											<span class="liquid-width">Dismiss on &quot;esc&quot; key:</span><input class="input-width-static" type="checkbox" name="escKey"  <?php echo $sgEscKey;?>/>
											<span class="dashicons dashicons-info escKeyImg sameImageStyle"></span><span class="infoEscKey samefontStyle">The popup will be dismissed when user presses on 'esc' key.</span></br>

											<span class="liquid-width" id="createDescribeClose">Show &quot;close&quot; button:</span><input class="input-width-static" type="checkbox" name="closeButton" <?php echo $sgCloseButton;?> />
											<span class="dashicons dashicons-info CloseImg sameImageStyle"></span><span class="infoCloseButton samefontStyle">The popup will contain 'close' button.</span><br>

											<span class="liquid-width">Enable content scrolling:</span><input class="input-width-static" type="checkbox" name="scrolling" <?php echo $sgScrolling;?> />
											<span class="dashicons dashicons-info scrollingImg sameImageStyle"></span><span class="infoScrolling samefontStyle">If the containt is larger then the specified dimentions, then the content will be scrollable.</span><br>

											<span class="liquid-width">Enable responsiveness:</span><input class="input-width-static" type="checkbox" name="reposition" <?php echo $sgReposition;?> />
											<span class="dashicons dashicons-info repositionImg sameImageStyle"></span><span class="infoReposition samefontStyle">The popup will be resized/repositioned automatically when window is being resized.</span><br>

											<span class="liquid-width">Dismiss on overlay click:</span><input class="input-width-static" type="checkbox" name="overlayClose" <?php echo $sgOverlayClose;?> />
											<span class="dashicons dashicons-info overlayImg sameImageStyle"></span><span class="infoOverlayClose samefontStyle">The popup will be dismissed when user clicks beyond of the popup area.</span><br>

											<span class="liquid-width">Dismiss on content click:</span><input class="input-width-static" type="checkbox" name="contentClick" <?php echo $sgContentClick;?> />
											<span class="dashicons dashicons-info contentClick sameImageStyle"></span><span class="infoContentClick samefontStyle">The popup will be dismissed when user clicks inside popup area.</span><br>

											<span class="liquid-width">Change overlay color:</span><div id="color-picker"><input  class="sgOverlayColor" id="sgOverlayColor" type="text" name="sgOverlayColor" value="<?php echo esc_attr(@$sgOverlayColor); ?>" /></div><br>

											<span class="liquid-width" id="createDescribeOpacitcy">Background overlay opacity:</span><div class="slider-wrapper">
												<input type="text" class="js-decimal" value="<?php echo esc_attr($sgOpacity);?>" rel="<?php echo esc_attr($sgOpacity);?>" name="opacity"/>
												<div id="js-display-decimal" class="display-box"></div>
											</div><br>
											<span  class="liquid-width" id="createDescribeFixed">Popup location:</span><input class="input-width-static" type="checkbox" name="popupFixed" id="js-popup-fixed" <?php echo $sgPopupFixed;?> /><br>
											<div class="js-popop-fixeds">
												<span class="fix-wrapper-style" >&nbsp;</span>
												<div class="fixed-wrapper">
													<div class="js-fixed-position-style" id="fixed-position1" data-sgvalue="1"></div>
													<div class="js-fixed-position-style" id="fixed-position2"data-sgvalue="2"></div>
													<div class="js-fixed-position-style" id="fixed-position3" data-sgvalue="3"></div>
													<div class="js-fixed-position-style" id="fixed-position4" data-sgvalue="4"></div>
													<div class="js-fixed-position-style" id="fixed-position5" data-sgvalue="5"></div>
													<div class="js-fixed-position-style" id="fixed-position6" data-sgvalue="6"></div>
													<div class="js-fixed-position-style" id="fixed-position7" data-sgvalue="7"></div>
													<div class="js-fixed-position-style" id="fixed-position8" data-sgvalue="8"></div>
													<div class="js-fixed-position-style" id="fixed-position9" data-sgvalue="9"></div>
												</div>
											</div>
											<input type="hidden" name="fixedPostion" class="js-fixed-postion" value="<?php echo esc_attr(@$sgFixedPostion);?>">
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
					<?php
						if (SG_POPUP_PRO) {
							require_once("options_section/pro.php");
						}
					?>
				</div>
				</div>
				<div class="clear"></div>
				<input type="hidden" class="button-primary" value="<?php echo esc_attr(@$id);?>" name="hidden_popup_number" />
			</div>
		</div>
</form>
