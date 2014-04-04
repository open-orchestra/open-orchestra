function init(parameter){
	$(document).ready(function() {
	    $("#dialog-" + parameter.name + " select#" + parameter.name + "_method").change(function(){
            var container = $('#dialog-' + parameter.name).addSpan('start-' + parameter.name);
	        if($(this).val() == 'create'){
	            var select = container.createSelect("Choose a block", parameter.name + "_component", parameter.blocks, "action", "alias");
	            select.addClass("used-as-label");
	            select.change(function(){
	                subcontainer = container.addSpan('start-' + parameter.name);
	                if($(this).val()){
	                    for(var i in parameter.blocks){
	                        if($(this).val() == parameter.blocks[i].action){
	                            $(parameter.blocks[i].form).appendTo(subcontainer);
	                        }
	                    }
	                }
	            });
	        }
	        else if($(this).val() == 'load'){
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
	        }
	    });
	});
}