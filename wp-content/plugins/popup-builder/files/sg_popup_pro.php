<?php
class SgPopupPro
{
	public static function sgPopupDataSanitize($sgPopupData) {
		$allowedHtmltags = wp_kses_allowed_html('post');
		$allowedHtmltags['input'] = array('name'=>true, 'class'=>true, 'id'=>true, 'placeholder'=>true, 'title'=>true, 'value'=>true, 'type'=>true);
		$allowedHtmltags['iframe'] = array('name'=>true, 'class'=>true, 'id'=>true, 'title'=>true, 'src'=>true, 'height'=>true, 'width'=>true);
		return wp_kses($sgPopupData, $allowedHtmltags);
	}
}
