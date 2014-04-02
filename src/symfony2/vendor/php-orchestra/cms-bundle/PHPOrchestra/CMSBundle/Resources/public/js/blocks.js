(function($){
	$.fn.createSelect = function(label, id, values, value_key, value_label){
        var select = $( "<select/>", {"id": id, "name": id});
        $( "<option/>", {"value": "", "text": "--------"}).appendTo(select);
        for(var i in values){
            $( "<option/>", {"value": values[i][value_key], "text": values[i][value_label]}).appendTo(select);
        }
        $( "<label/>", {"text": label, "for": id}).appendTo($(this));
        select.appendTo($(this));
        return select;
    }
	$.fn.addSpan = function(name){
	    var span =  $(this).children('span.' + name);
	    if(span.length == 0){
			span = $( "<span/>", {"class": name}).appendTo($(this));
	    }
	    else{
	    	span.html('');
	    }
	    return span;
	}
})(jQuery);

function refreshForm(obj, name, blocks, urlNode, urlBlock){
    if(obj.val() == 'create'){
        var container = $('#dialog-' + name).addSpan('start-' + name);
        var select = container.createSelect("Choose a block", name + "_component", blocks, "action", "alias");
        select.addClass("used-as-label");
        select.change(function(){
            subcontainer = container.addSpan('start-' + name);
            if($(this).val()){
                for(var i in blocks){
                    if($(this).val() == blocks[i].action){
                        $(blocks[i].form).appendTo(subcontainer);
                    }
                }
            }
        });
    }
    else if(obj.val() == 'load'){
        $.ajax({
            'type': 'POST',
            'url': urlNode,
            'success': function(response){
        		var container = $('#dialog-' + name).addSpan('start-' + name);
                var select = container.createSelect("Choose a node", name + "_nodeId", response.data, "nodeId", "name");
                select.change(function(){
            		subcontainer = container.addSpan('start-' + name);
                    if($(this).val()){
                        $.ajax({
                            'type': 'POST',
                            'url': urlBlock,
                            'success': function(response){
                                var select = subcontainer.createSelect("Choose a block", name + "_blockId", response.data, "blockId", "name");
                                select.addClass("used-as-label");
                            },
                            'data': {'nodeId' : $(this).val()},
                            'dataType': 'json',
                            'async': false
                        });
                    }
                });
            },
            'dataType': 'json',
            'async': false
        });
    }
}
