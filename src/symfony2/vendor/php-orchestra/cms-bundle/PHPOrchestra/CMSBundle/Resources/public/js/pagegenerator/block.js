$('body').on('change', '.refresh', function(){
	$(this).refreshForm();
});

(function($){
	$.fn.refreshForm = function(params){
		var target = $(this).parents('form');
		params = target.serializeArray().concat({'name': 'refresh', 'value': true}, params || {});
	    $.ajax({
	        'type': 'GET',
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
