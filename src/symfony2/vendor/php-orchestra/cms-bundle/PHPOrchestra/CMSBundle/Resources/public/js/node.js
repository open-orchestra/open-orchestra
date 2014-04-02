function init(parameter){
	$(document).ready(function() {
	    $("#dialog-" + parameter.name + " select#" + parameter.name + "_templateId").change(function(){
	    	if($(this).val()){
	            $.ajax({
	                'type': 'POST',
	                'url': parameter.urlTemplate,
	                'success': function(response){
	            		var data = $('#dialog-' + parameter.name).data();
	            		data.this_values.areas = eval(response.data);
	            	},
	            	'data': {'templateId' : $(this).val()},
		            'dataType': 'json',
		            'async': false
		        });
	    	}
	    });
	});
}
