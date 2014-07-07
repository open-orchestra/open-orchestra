(function($){
    $.fn.addButton = function(button)
    {
		return this.each(function(){
			var buttons = $(this).dialog("option", "buttons");
			buttons.push(button);
			$(this).dialog("option", "buttons", buttons);
		});
	}

	$.fn.addObjectButton = function(name)
    {
		return this.each(function(){
	        var data = $(this).data('container').data('settings');
	        data = eval('data' + $(this).data('path'));	
			var button = {
	        	"click" : function(){
            		if(!(name in data)){
            			data[name] = [];
            		}
            		resetPercent(data[name]);
                    data[name].push({'ui-model' : {}});
                    var rank = data[name].length - 1;
                    $(this).dialog( "close" );
                    $('#dialog-' + name).data('css', $(this).data('css'));
                    $('#dialog-' + name).data('parent_path', $(this).data('path'));
                    $('#dialog-' + name).data('path', $(this).data('path') + '.' + name + '[' + rank + ']');
                    $('#dialog-' + name).data('source', $(this).data('source').find('li').last());
                    $('#dialog-' + name).fromJsToForm();
                    $('#dialog-' + name).dialog( "open" );
            	},
	        	"text" : "Add " + name.charAt(0).toUpperCase() + name.slice(1),
	        	"class" : "btn btn-default"
	        };
			$(this).addButton(button);
		});
	}
    
    $.fn.addSubmitButton = function(name)
    {
		return this.each(function(){
			var button = {
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
			$(this).addButton(button);
		});
    }
    $.fn.addApplyButton = function(name)
    {
		return this.each(function(){
			var button = {
	    		"click" : function() {
			        var data = $(this).data('container').data('settings');
			        data = eval('data' + $(this).data('path'));
		            $(this).fromFormToJs(data);
		            $(this).dialog( "close" );
	        	},
		        "text" : "Apply",
		        "class" : "btn btn-default"
	        };
			$(this).addButton(button);
		});
    }
})(jQuery);

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
			$(this).data('source').children().first().addClass('dialog-selected');
			$(this).dialog("option", "buttons", []);
			$(this).addApplyButton();
	        var data = $(this).data('container').data('settings');
	        data = eval('data' + $(this).data('path'));	
	        var found = false;
	        var addArray = $(this).dialog("option", "addArray");
	        for(var i in allowed_object){
	    		var key = allowed_object[i];
	    		if(key in data){
	    			found = true;
	                if(addArray.indexOf(key) > -1){
	                	$(this).addObjectButton(key);
	                }
	    		}
	        }
	        if(!found){
	            for(var i in addArray){
                	$(this).addObjectButton(addArray[i]);
	            }
	        }
	        if($(this).find("[type='submit']").length){
	        	$(this).find("[type='submit']").hide();
	        	$(this).addSubmitButton();
	        }
	    },
	    close: function ( event, ui) {
	    	$(this).data('source').children().first().removeClass('dialog-selected');
	    	$(this).data('source').empty();
	    	$(this).data('source').model({'path' : $(this).data('path'), 'parent_path': $(this).data('parent_path'), 'type' : $(this).data('type')});
	    }
	};
	return dialog_parameter;
}
