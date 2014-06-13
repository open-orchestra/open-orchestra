function addButton(name, data, jThis){
	return {
        	"click" : (function (name, data, jThis){
            	return function(){
            		resetPercent(data.this_values[name]);
                    data.this_values[name].push({'is_recursive' : true});
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
        var data = $(this).data();
        var found = false;
        var buttons = $.extend({}, $(this).dialog("option", "allbuttons"));
        var addArray = $(this).dialog("option", "addArray");
        for(var i in addArray){
            if(addArray[i] in data.this_values){
                found = true;
                buttons[addArray[i]] = addButton(addArray[i], data, $(this));
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
	                var data = $(this).data();
	                $(this).getValue(data.this_values);
	                formatForSubmit(data.settings);
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
        $(this).setValue(data.this_values);
    },
    allbuttons: {
        "apply": {
    		"click" : function() {
		            var data = $(this).data();
		            $(this).getValue(data.this_values);
		            $(this).dialog( "close" );
	        	},
	        "text" : "Apply",
	        "class" : "btn btn-default"
    	}
    },
    close: function ( event, ui) {
        var data = $(this).data();
        data.settings.element.parseModel($.extend(data.settings, {"path": null}));
    }
};
