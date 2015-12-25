<?php

function sgPopupDelete()
{
	$id = (int)@$_POST['popup_id'];
	if (!$id) {
		return;
	}
	require_once(SG_APP_POPUP_CLASSES.'/SGPopup.php');
	SGPopup::delete($id);
}

add_action('wp_ajax_delete_popup', 'sgPopupDelete');
