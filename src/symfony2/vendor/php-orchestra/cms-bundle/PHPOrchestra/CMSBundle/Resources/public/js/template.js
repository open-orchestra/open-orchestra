function formatForSubmit(settings){
	if(!('blocks' in settings.values)){
		settings.values.blocks = [];
	}
	treeFormatForSubmit(settings, settings.values);
	if('areas' in settings.values){
        $("#template_areas").val(JSON.stringify(settings.values.areas));
    }
    if('blocks' in settings.values){
        $("#template_blocks").val(JSON.stringify(settings.values.blocks));
    }
}
function treeFormatForSubmit(settings, values){
	if('blocks' in values){
		for(var i in values.blocks){
			delete values.blocks[i].method;
			delete values.blocks[i].label;
			if(!('nodeId' in values.blocks[i])){
				if('component' in values.blocks[i]){
					var newBlock = {'component': values.blocks[i].component};
					delete values.blocks[i].component;
					newBlock.attributes = values.blocks[i];
					settings.values.blocks.push(newBlock);
					values.blocks[i] = {'nodeId': 0, 'blockId': settings.values.blocks.length - 1};
				}
			}
		}
	}
	else if('areas' in values){
		for(var i in values.areas){
			treeFormatForSubmit(settings, values.areas[i]);
		}
	}
}

function formatForLoad(settings){
	settings.values.areas = eval($("#template_areas").val());
	settings.values.blocks = eval($("#template_blocks").val());
	treeFormatForLoad(settings, settings.values);
	delete settings.values.blocks;
}
function treeFormatForLoad(settings, values){
	if('blocks' in values){
		for(var i in values.blocks){
			if(values.blocks[i].nodeId == 0){
				var refBlock = settings.blocks[values.blocks[i].blockId];
				values.blocks[i] = $.extend({
						'method': 'create',
						'label': 'Hummm...',
						'component': refBlock.component}, refBlock.attributes);
				delete refBlock;
			}
			else{
				values.blocks[i] = $.extend({
					'method': 'load',
					'label': 'Hummm...'}, values.blocks[i]);
			}
		}
	}
	else if('areas' in values){
		for(var i in values.areas){
			treeFormatForLoad(settings, values.areas[i]);
		}
	}
}

var dialog_parameter = {
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
                    buttons["Add " + addArray[i].charAt(0).toUpperCase() + addArray[i].slice(1)] = (function (name){
	                	return function(){
	                        data.this_values[name].push({});
	                        $(this).dialog( "close" );
	                	}
	                })(addArray[i]);
                }
            }
            if(!found){
	            for(var i in addArray){
	                buttons["Add " + addArray[i].charAt(0).toUpperCase() + addArray[i].slice(1)] = (function (name){
	                	return function(){
	                        data.this_values[name] = new Array();
	                        data.this_values[name].push({});
	                        $(this).dialog( "close" );
	                	}
	                })(addArray[i]);
	            }
            }
            $(this).find("[type='submit']").each(function(){
            	$(this).hide();
            	buttons["Send"] = function(){
	                formatForSubmit(data.settings);
	                $("form[name='template']").submit();
	                $(this).dialog( "close" );
	           }
            });
            $(this).dialog("option", "buttons", buttons);
            $(this).setValue(data.this_values);
        },
        allbuttons: {
            "Apply": function() {
                var data = $(this).data();
                $(this).find(":input").not('button').getValue(data.this_values);
                data.this_values.label = eval($(this).dialog("option", "label"));
                $(this).dialog( "close" );
            },
        },
        close: function ( event, ui) {
            var data = $(this).data();
            data.settings.element.parseTemplate($.extend(data.settings, {"path": null}));
        }
    };


(function($){
    $.createSubTemplate = function(settings, type, target){
		var values = eval('settings.' + settings.path);
		var tab = eval('settings.' + settings.path + '.' + type);
		var path = settings.path + '.' + type;
		values.boDirection = (values.boDirection) ? values.boDirection : 'h';
		if(tab.length > 0){
			for(var i in tab){
				$(target).parseTemplate({"values": settings.values,
									"path": path + '[' + i + ']',
									"css": settings.css,
									"style" : {"display": (values.boDirection == 'v') ? "inline-block" : "block", "width": (values.boDirection == 'v') ? 100 / (tab.length) + '%' : '100%', "height": (values.boDirection == 'h') ? 100 / (tab.length) + '%' : '100%'},
									"index": settings.index + 1,
									"type": type,
									"element": settings.element}).appendTo(target);
			}
		}
	}
	$.fn.parseTemplate = function(options)
	{
		var settings = $.extend({
			"values": $(this).data(),
			"css": "ui-widget-model"
		}, options || {});

		var actions = ['delete', 'movedown', 'moveup'];
		if(settings.path == null){
			settings.element = this;
			settings.path = "values";
			settings.type = "node";
			settings.style = '';
			settings.element.html('');
			actions = [];
		}
		var this_values = eval('settings.' + settings.path);
		if(settings.init){
		    $( ".dialog-node" ).find(":input").getValue(this_values);
		    formatForLoad(settings);
		    delete settings.init;
		}
		var span = $( "<span/>", {"class": settings.css, "text": (this_values.label) ? this_values.label : 'No Record'});
		for(var i in actions){
			var action = $( "<span/>", {"class": "action " + actions[i], "text": actions[i]});
			action.appendTo(span);
			action.click(function(event){
				event.stopPropagation();
				var pattern = new RegExp('^(.*)\\.(.*?)\\[(\\d*)]$');
				var source = null;
				eval(settings.path.replace(pattern, 'source = {"path" : "$1", "type" : "$2", "index" : $3};'));
				if($(this).attr("class").indexOf("delete") >= 0){
					eval('settings.' + source.path + '.' + source.type + '.splice(' + source.index + ', 1)');
				}
				else if($(this).attr("class").indexOf("moveup") >= 0){
					eval('var tab = settings.' + source.path + '.' + source.type);
					if(source.index > 0){
						var tmp = tab[source.index - 1];
						tab[source.index - 1] = tab[source.index];
						tab[source.index] = tmp;
					}
				}
				else if($(this).attr("class").indexOf("movedow") >= 0){
					eval('var tab = settings.' + source.path + '.' + source.type);
					if(source.index < tab.length - 1){
						var tmp = tab[source.index + 1];
						tab[source.index + 1] = tab[source.index];
						tab[source.index] = tmp;
					}
				}
				settings.element.parseTemplate($.extend(settings, {"path": null}));
			});
		}
		var div = $( "<div/>", {"class": settings.css});
		var li = $( "<li/>", {"class": settings.css, "css": settings.style});
		var ul = $( "<ul/>", {"class": settings.css});
		span.appendTo(div);
		div.appendTo(li);

		div.mouseover(function(event){
			event.stopPropagation();
			$(this).addClass('over');
		});
		div.mouseout(function(){
			$(this).removeClass('over');
		});
		div.click(function(event){
			event.stopPropagation();
			$( ".dialog-" + settings.type ).data("settings", settings);
			$( ".dialog-" + settings.type ).data("this_values", this_values);
			$( ".dialog-" + settings.type ).dialog( "open" );
		});
		for(var i in this_values){
			if(Array.isArray(this_values[i]) && this_values[i].length > 0){
				ul.addClass(settings.css + '-' + i);
				$.createSubTemplate(settings, i, ul);
				ul.children().addClass(settings.css + '-' + i);
			}
		}
		if($( ".dialog-" + settings.type ).dialog("option", "addArray").length){
			ul.appendTo(div);
			ul.data('path', settings.path);
		}
		if(settings.path == "values"){
			ul = $( "<ul/>", {"class": settings.css + ' ' + settings.css + '-' + 'node',
				"css": {"display": settings.style}});
			li.appendTo(ul);
			ul.appendTo($(this));
			$('ul.' + settings.css).parent().droppable({
				greedy: true,
				tolerance: "pointer",
				hoverClass: 'over',
				drop : function(event, ui){
					var pattern = new RegExp('^(.*)\\.(.*?)\\[(\\d*)]$');
					var target = eval('settings.' + $(this).find('ul').data('path'));
					var path = 'settings.' + ui.draggable.data('path');
					var source = null;
					eval(path.replace(pattern, 'source = {"path" : "$1", "type" : "$2", "index" : $3};'));
					if(!(source.type in target)){
						target[source.type] = new Array();
					}
					target[source.type].push(eval(path));
					eval(source.path + '.' + source.type + '.splice(' + source.index + ', 1)');
					settings.element.parseTemplate($.extend(settings, {"path": null}));
				},
				accept: function(event){
					return event.attr("class").indexOf($(this).children('ul').attr("class")) >= 0;
				}
			});
			$('li.' + settings.css).draggable({
				opacity: 0.5,
				containment: settings.element,
				drag: function(event, ui){
					settings.element.find('div').unbind('mouseover');
					settings.element.find('div').unbind('mouseout');
				}
			});
		}
		else{
			li.data('path', settings.path);
		}
		return li;
	}
    $.fn.getValue = function(values, pre){
    	if($(this).length > 1){
            var pre = ($(this).parents("form").length) ? $(this).parents("form").attr("name") + '_' : '';
            for(var i in values){
            	if(typeof values[i] != 'object'){
            		delete values[i];
            	}
            }
	    	$(this).each(function(){
	    		$(this).getValue(values, pre);
	    	});
    	}
    	else if($(this).length == 1){
	        var id = $(this).attr( "id" ).replace(pre, '');
	        if(!$(this).hasClass('not-mapped')){
	        	values[id] = $(this).val();
	        }
    	}
    }
    $.fn.setValue = function(values, pre){
        var pre = ($(this).find("form").length) ? $(this).find("form").attr("name") + '_' : '';
        $(this).find(":input").each(function(){
    		$(this).val('');
    		$(this).change();
    	});
        for(var id in values){
        	var obj = $(this).find('#' + pre + id);
        	if(obj.length && !obj.hasClass('not-mapped')){
        		obj.val(values[id]);
        		obj.change();
        	}
        }
    }
    $.fn.createSelect = function(label, id, values, value_key, value_label){
        var select = $( "<select/>", {"id": id});
        $( "<option/>", {"value": "", "text": "--------"}).appendTo(select);
        for(var i in values){
            $( "<option/>", {"value": values[i][value_key], "text": values[i][value_label]}).appendTo(select);
        }
        $( "<label/>", {"text": label}).appendTo($(this));
        select.appendTo($(this));
        return select;
    }

})(jQuery);