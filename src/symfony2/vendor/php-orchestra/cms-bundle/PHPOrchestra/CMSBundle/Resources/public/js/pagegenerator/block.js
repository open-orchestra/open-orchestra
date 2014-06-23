if(target.length){
	target.on('change', '.reload', function(){
		var values = target.serializeArray();
        $.ajax({
            'type': 'POST',
            'url': target.attr('action'),
            'success': function(response){
        		$(response.data).each(function(){
        			if($(this).prop("tagName") == target.prop("tagName")){
        				target.html($(this).html());
        			}
        		})
            },
            'data': target.serialize(),
            'dataType': 'json',
            'async': false
        });
	});
}
