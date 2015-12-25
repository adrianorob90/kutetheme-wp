function SgPickers() {

}

SgPickers.prototype.init = function() {
	jQuery(".sg-calndar").addClass("input-width-static");

	jQuery('.sg-calndar').bind("click",function() {
		jQuery("#ui-datepicker-div").css({'z-index': 9999});
	});
}

SgPickers.prototype.colorPicekr = function() {
	sgColorPicker = jQuery('.sgOverlayColor').wpColorPicker({
	});
	jQuery(".wp-picker-holder").bind('click',function() {
		var selectedInput = jQuery(this).prev().find('.sgOverlayColor');
		if(selectedInput.attr("name") == 'countdownNumbersTextColor') {
			var textColor = selectedInput.val();
			jQuery("#sg-counts-text").remove();
		 	jQuery("body").append("<style id=\"sg-counts-text\">.flip-clock-wrapper ul li a div div.inn { color: "+textColor+"; }</style>");
		}
		if(selectedInput.attr("name") == 'countdownNumbersBgColor') {
			var bgColor = selectedInput.val();
			jQuery("#sg-counts-style").remove();
		 	jQuery("body").append("<style id=\"sg-counts-style\">.flip-clock-wrapper ul li a div div.inn { background-color: "+bgColor+"; }</style>");
		}
	});
}

SgPickers.prototype.datepicker = function() {
	jQuery('.sg-calndar').datepicker({
		dateFormat : 'yy-mm-dd',
		minDate: 0,
		onSelect: function() {
		}
	});
}

jQuery(document).ready(function($){

	pickersObj = new SgPickers();
	pickersObj.init();
	pickersObj.colorPicekr();
	pickersObj.datepicker();
});