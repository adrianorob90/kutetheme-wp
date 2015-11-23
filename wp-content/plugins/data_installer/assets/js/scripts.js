jQuery(function ($)
{
    $.fn.extend({
        _method: function(){
            $this = jQuery(this);
            $packet = $this.data( 'packet' );
            $method = $this.data( 'method' );
            var request_data = {
                action: 'kt_ajax_demo_install',
                kt_demo_action: $method,
                kt_packet : $packet,
            };
            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                cache:false,
                data: request_data,
                dataType: 'json',
                success: function(data, textStatus, XMLHttpRequest){
                    $this.text("Uninstall");
                    $this.data('method', 'uninstall')
                },
                error: function(MLHttpRequest, textStatus, errorThrown){
                    
                }
            });
        }
    });
    jQuery( '.box-item .item-button button' ).click(function(){
        jQuery(this)._method();
    });
    jQuery(document).ready(function($){
 		var form = $('#kt_data_installer_page'),
		filters = form.find('.export-filters');
 		filters.hide();
        
 		form.find('input:radio').change(function() {
			filters.slideUp('fast');
			switch ( $(this).val() ) {
				case 'posts': $('#post-filters').slideDown(); break;
				case 'pages': $('#page-filters').slideDown(); break;
			}
 		});
	});
    
});