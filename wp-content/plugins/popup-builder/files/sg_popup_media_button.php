<?php
function sgPopupMediaButton()
{
	global $pagenow, $typenow;

	$buttonTitle = 'Insert popup';
	$output = '';

	$pages = array(
		'post.php',
		'page.php',
		'post-new.php',
		'post-edit.php'
	);

	$checkPage = in_array(
		$pagenow,
		$pages
	);

	if ($checkPage && $typenow != 'download') {
		$img = '<span class="dashicons dashicons-welcome-widgets-menus" id="sg-popup-media-button" style="padding: 3px 2px 0px 0px"></span>';
		$output = '<a href="#TB_inline?width=600&height=550&inlineId=sg-popup-thickbox" class="thickbox button" title="'.$buttonTitle.'" style="padding-left: .4em;">'. $img.$buttonTitle.'</a>';
	}
	echo $output;
}

add_action('media_buttons', 'sgPopupMediaButton', 11);

function sgPopupMediaButtonThickboxs()
{
	global $pagenow, $typenow;

	$pages = array(
		'post.php',
		'page.php',
		'post-new.php',
		'post-edit.php'
	);

	$checkPage = in_array(
		$pagenow,
		$pages
	);

	if ($checkPage && $typenow != 'download') : ?>
		<script type="text/javascript">
			jQuery(document).ready(function ($) {
				$('#sg-ptp-popup-insert').on('click', function () {
					var id = $('#sg-insert-popup-id').val();
					if ('' === id) {
						alert('Select your popup');
						return;
					}
					selectionText = '';
					if (typeof(tinyMCE.editors.content) != "undefined") {
						selectionText = (tinyMCE.activeEditor.selection.getContent()) ? tinyMCE.activeEditor.selection.getContent() : '';
					}
					window.send_to_editor('[sg_popup id="' + id + '"]'+selectionText+"[/sg_popup]");
				});
			});
		</script>

		<div id="sg-popup-thickbox" style="display: none;">
			<div class="wrap">
				<p>Insert the shortcode for showing a Popup.</p>
				<div>
					<select id="sg-insert-popup-id">
						<option value="">Please select...</option>
						<?php
							global $wpdb;
							$proposedTypes = array();
							$orderBy = 'id DESC';
							$allPopups = SGPopup::findAll($orderBy);
							foreach ($allPopups as $allPopup) : ?>
								<option value="<?=$allPopup->getId()?>"><?php echo $allPopup->getTitle();?><?php echo " - ".$allPopup->getType();?></option>;
							<?php endforeach; ?>
					</select>
				</div>
				<p class="submit">
					<input type="button" id="sg-ptp-popup-insert" class="button-primary dashicons-welcome-widgets-menus" value="Insert"/>
					<a id="sg_popup_cancel" class="button-secondary" onclick="tb_remove();" title="Cancel">Cancel</a>
				</p>
			</div>
		</div>
	<?php endif;
}

add_action('admin_footer', 'sgPopupMediaButtonThickboxs');