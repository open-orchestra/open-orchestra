function addButton(name, data, jThis){
	return {
        	"click" : (function (name, data, jThis){
            	return function(){
            		if(!(name in data)){
            			data[name] = [];
            		}
            		resetPercent(data[name]);
                    data[name].push({'ui-model' : {}});
                    jThis.dialog( "close" );
            	}
        		})(name, data, jThis),
        	"text" : "Add " + name.charAt(0).toUpperCase() + name.slice(1),
        	"class" : "btn btn-default"
        };
}

function deleteDialogIfExists(name){
	$(".ui-dialog").filter(function(i) {
		if($(this).children('#' + name).length){
			$(this).children('#' + name).remove();
			return true;
		}
		else{
			return false;
		}
	}).remove();
}

function getDialogParameter(){
	dialog_parameter = {
	    resizable: false,
	    width:530,
	    modal: true,
	    autoOpen: false,
	    open: function ( event, ui ) {
	        var data = $(this).data('container').data('settings');
	        data = eval('data' + $(this).data('path'));	
	        var found = false;
	        var buttons = $.extend({}, $(this).dialog("option", "allbuttons"));
	        var addArray = $(this).dialog("option", "addArray");
	        for(var i in allowed_object){
	    		var key = allowed_object[i];
	    		if(key in data){
	    			found = true;
	                if(addArray.indexOf(key) > -1){
	                    buttons[key] = addButton(key, data, $(this));
	                }
	    		}
	        }
	        if(!found){
	            for(var i in addArray){
	                buttons[addArray[i]] = addButton(addArray[i], data, $(this));
	            }
	        }
	        $(this).find("[type='submit']").each(function(){
	            $(this).hide();
	            buttons["save"] = {
	            	"click" : function(){
		                var data = $(this).data('container').data('settings');
		                data = eval('data' + $(this).data('path'));	
		                $(this).fromFormToJs(data);
		                $(this).data('container').setSubmit();
		                var form = $(this).find('form');
		                url = form.attr('action');
		                params = form.serialize();
		                $(this).dialog( "close" );
		                treeAjaxCall(url, params);
	            	},
	            	"text" : "Save",
	            	"class" : "btn btn-primary"
	            };
	        });
	        $(this).dialog("option", "buttons", buttons);
	    },
	    allbuttons: {
	        "apply": {
	    		"click" : function() {
				        var data = $(this).data('container').data('settings');
				        data = eval('data' + $(this).data('path'));
			            $(this).fromFormToJs(data);
			            $(this).dialog( "close" );
		        	},
		        "text" : "Apply",
		        "class" : "btn btn-default"
	    	}
	    },
	    close: function ( event, ui) {
	    	$(this).data('source').empty();
	    	$(this).data('source').model({'path' : $(this).data('path'), 'parent_path': $(this).data('parent_path'), 'type' : $(this).data('type')});
	    }
	};
	return dialog_parameter;
}
