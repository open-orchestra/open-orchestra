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
	        var keys = $(this).data('container').data('subtab');
	        
	        for(var i in keys){
	    		var key = keys[i];
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
	    	console.log(event);
	    	
	    	$(this).data('container').parent().model({"type" : $(this).data('container').data('target'), "resizable" : $(this).data('container').data('resizable')});
	    }
	};
	return dialog_parameter;
}
