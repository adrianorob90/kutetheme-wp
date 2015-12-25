<?php
class SGFunctions
{
	public static function showInfo()
	{
		$sgInfo = '';
		$divisor = "<span class=\"info-vertical-divisor\">|</span>";
		$sgInfo .= "<span>If you like the plugin, please <a href=\"https://wordpress.org/support/view/plugin-reviews/popup-builder?filter=5\" target=\"_blank\">rate it 5 stars</a></span>".$divisor;
		$sgInfo .= "<a href=\"https://wordpress.org/support/plugin/popup-builder\" target=\"_blank\">Support</a>".$divisor;
		$sgInfo .= "<a href=\"https://www.youtube.com/watch?v=3ZwRKPhHMzY\" target=\"_blank\">How to create a popup</a>";
		echo $sgInfo;
	}
}
