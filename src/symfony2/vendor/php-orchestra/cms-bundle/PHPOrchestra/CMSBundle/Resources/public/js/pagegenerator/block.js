$('body').on('change', '.refresh', function(){
	$(this).refreshForm();
});

(function($){
	$.fn.refreshForm = function(params){
		var target = $(this).parents('form');
		if(!params){
			params = target.serializeArray();
		}
		params = params.concat({'name': 'refresh', 'value': true});
	    $.ajax({
	        'type': 'POST',
	        'url': target.attr('action'),
	        'success': function(response){
	    		$(response.data).each(function(){
	    			if($(this).prop("tagName") == target.prop("tagName")){
	    				target.html($(this).html());
	    			}
	    		});
	        },
	        'data': params,
	        'dataType': 'json',
	        'async': false
	    });
	}
})(jQuery);
