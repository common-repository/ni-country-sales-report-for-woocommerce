var CountryJSON = {};
// JavaScript Document
jQuery(function($){
	

	$( "#frm_country_report" ).submit(function( event ) {
		
		event.preventDefault();
		$.ajax({
			url:nicsrfwoo_ajax_object.nicsrfwoo_ajaxurl,
			data: $(this).serialize(),
			success:function(response) {
				
				//alert(JSON.stringify(response));
				$("._ajax_content").html(response);
				
			
			},
			error: function(errorThrown){
				console.log(errorThrown);
				//alert("e");
			}
		
		});
		
	});
	$("#frm_country_report").trigger("submit");
	
});


