function addButton(name, data, jThis){
	return {
        	"click" : (function (name, data, jThis){
            	return function(){
            		resetPercent(data[name]);
                    data[name].push({'ui-model' : {}});
                    jThis.dialog( "close" );
            	}
        		})(name, data, jThis),
        	"text" : "Add " + name.charAt(0).toUpperCase() + name.slice(1),
        	"class" : "btn btn-default"
        };
}


dialog_parameter = {
    resizable: false,
    width:530,
    modal: true,
    autoOpen: false,
    open: function ( event, ui) {
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
        $(this).fromJsToForm(data);
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
    	$(this).data('container').parent().model({"type" : $(this).data('container').data('target')});
    }
};
