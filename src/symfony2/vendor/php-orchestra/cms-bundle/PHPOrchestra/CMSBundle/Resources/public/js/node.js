function init(parameter){
	$(document).ready(function() {
	    $("#dialog-" + parameter.name + " select#" + parameter.name + "_templateId").change(function(){
    		var data = $('#dialog-' + parameter.name).data();
    		var tempArea = $.extend(true, {}, data.this_values.areas);
	    	if($(this).val()){
	            $.ajax({
	                'type': 'POST',
	                'url': parameter.urlTemplate,
	                'success': function(response){
	            		$("#dialog-" + parameter.name +" #" + parameter.name + "_areas").val(response.data.areas);
	            		$("#dialog-" + parameter.name +" #" + parameter.name + "_blocks").val(response.data.blocks);
	            		formatForLoad(data.settings);
	            	},
	            	'data': {'templateId' : $(this).val()},
		            'dataType': 'json',
		            'async': false
		        });
	    	}
	    	else{
	    		data.this_values.areas = tempArea;
	    	}
	    	//data.settings.element.parseTemplate($.extend(data.settings, {"path": null}));
	    });
	});
}
