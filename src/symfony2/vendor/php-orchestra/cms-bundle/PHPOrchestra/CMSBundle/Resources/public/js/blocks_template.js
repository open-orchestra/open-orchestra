function init(parameter){
	$(document).ready(function() {
		var container = $('#dialog-' + parameter.name);
        $.ajax({
            'type': 'POST',
            'url': parameter.urlNode,
            'success': function(response){
	        	container.append(response.data);
	        	container.find('select').change(function(){
	           		subcontainer = container.addSpan('start-' + parameter.name);
	                if($(this).val()){
	                    $.ajax({
	                        'type': 'POST',
	                        'url': parameter.urlBlock,
	                        'success': function(response){
		                    	subcontainer.append(response.data);
		                    	subcontainer.find('select').addClass("used-as-label");
	                        },
	                        'data': {'nodeId' : $(this).val()},
	                        'dataType': 'json',
	                        'async': false
	                    });
	                }
	            });
            },
            'data': {'form' : parameter.name},
            'dataType': 'json',
            'async': false
        });
	});
}