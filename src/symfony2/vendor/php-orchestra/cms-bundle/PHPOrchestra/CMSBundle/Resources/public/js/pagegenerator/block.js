$('form').on('change', '.reload', function(){
	var target = $(this).parents('form');
	var data = target.serializeArray();
	data.push({'name': 'refresh', 'value': true});
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
        'data': data,
        'dataType': 'json',
        'async': false
    });
});