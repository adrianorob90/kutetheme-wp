<?php
require_once(SG_APP_POPUP_CLASSES.'/sgDataTable/SGPopupTable.php');
?>
<div class="wrap">
	<div class="headers-wrapper">
	<h2>Popups <a href="<?php echo admin_url();?>admin.php?page=create-popup" class="add-new-h2">Add New</a></h2>
		<?php if(!SG_POPUP_PRO): ?>
				<input type="button" class="main-update-to-pro" value="Upgrade to PRO version" onclick="window.open('<?php echo SG_POPUP_PRO_URL;?>')">
		<?php endif; ?>
	</div>
	<?php
		$table = new SGPB_PopupsView();
		echo $table;
		SGFunctions::showInfo();
	?>
</div>