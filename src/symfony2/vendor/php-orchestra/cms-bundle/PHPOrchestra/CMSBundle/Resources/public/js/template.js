function formatForSubmit(settings){
	if(!('blocks' in settings.values)){
		settings.values.blocks = [];
	}
	treeFormatForSubmit(settings, settings.values);
	if('areas' in settings.values){
        $("#" + settings.type + "_areas").val(JSON.stringify(settings.values.areas));
    }
    if('blocks' in settings.values){
        $("#" + settings.type + "_blocks").val(JSON.stringify(settings.values.blocks));
    }
}
function treeFormatForSubmit(settings, values){
	if('blocks' in values){
		for(var i in values.blocks){
			if(!('nodeId' in values.blocks[i])){
				if('component' in values.blocks[i]){
					var newBlock = {'component': values.blocks[i].component};
					delete values.blocks[i].component;
					delete values.blocks[i].method;
					delete values.blocks[i].label;
					delete values.blocks[i].is_recursive;
					newBlock.attributes = values.blocks[i];
					settings.values.blocks.push(newBlock);
					values.blocks[i] = {'nodeId': 0, 'blockId': settings.values.blocks.length - 1};
				}
			}
		}
	}
	if('areas' in values){
		for(var i in values.areas){
			treeFormatForSubmit(settings, values.areas[i]);
		}
	}
}

function formatForLoad(settings){
	$( "#dialog-" + settings.type ).getValue(settings.values);
	settings.values.areas = eval($("#" + settings.type + "_areas").val());
	settings.blocks = eval($("#" + settings.type + "_blocks").val());
	delete settings.values.blocks;
	treeFormatForLoad(settings, settings.values);
	delete settings.blocks;
}
function treeFormatForLoad(settings, values){
	if('blocks' in values){
		for(var i in values.blocks){
			if(values.blocks[i].nodeId == 0){
				var refBlock = settings.blocks[values.blocks[i].blockId];
				values.blocks[i] = $.extend({'is_recursive' : true, 'method': 'create', 'component': refBlock.component}, refBlock.attributes);
			}
			else{
				values.blocks[i] = $.extend({'is_recursive' : true, 'method': 'load'}, values.blocks[i]);
			}
			$( "#dialog-blocks" ).setValue(values.blocks[i]);
			$( "#dialog-blocks" ).getValue(values.blocks[i]);
		}
	}
	if('areas' in values){
		for(var i in values.areas){
			values.areas[i].is_recursive = true;
			$( "#dialog-areas" ).setValue(values.areas[i]);
			$( "#dialog-areas" ).getValue(values.areas[i]);
			treeFormatForLoad(settings, values.areas[i]);
		}
	}
}

function moveFromTo(settings, source, destination){
	var pattern = new RegExp('^(.*)\\.(.*?)\\[(\\d*)]$');
	var copy = eval('$.extend(true, {}, '+ source + ');');
	eval(source.replace(pattern, 'source = {"path" : "$1", "type" : "$2", "index" : $3};'));
	if(destination){
		if(isNaN(destination)){
			eval(destination + ' = $.extend({}, {"' + source.type + '" : []}, ' + destination + ');');
			eval(destination + '.' + source.type + '.push(copy);');
		}
		else{
			eval(source.path + '.' + source.type + '.splice(' + (source.index + destination) +  ', 0, copy)');
		}
	}
	eval(source.path + '.' + source.type + '.splice(' + source.index + ', 1)');
	settings.element.parseTemplate($.extend(settings, {"path": null}));
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
	                        data.this_values[name].push({'is_recursive' : true});
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
	                        data.this_values[name].push({'is_recursive' : true});
	                        $(this).dialog( "close" );
	                	}
	                })(addArray[i]);
	            }
            }
            $(this).find("[type='submit']").each(function(){
            	$(this).hide();
            	buttons["Send"] = function(){
	                formatForSubmit(data.settings);
	                $(this).find('form').submit();
	                $(this).dialog( "close" );
	           }
            });
            $(this).dialog("option", "buttons", buttons);
            $(this).setValue(data.this_values);
        },
        allbuttons: {
            "Apply": function() {
                var data = $(this).data();
                $(this).getValue(data.this_values);
                $(this).dialog( "close" );
            },
        },
        close: function ( event, ui) {
            var data = $(this).data();
            data.settings.element.parseTemplate($.extend(data.settings, {"path": null}));
        }
    };


(function($){
    $.fn.createSubTemplate = function(settings, type){
		var values = eval(settings.path);
		var tab = eval(settings.path + '.' + type);
		var path = settings.path + '.' + type;
		values.boDirection = (values.boDirection) ? values.boDirection : 'h';
		if(tab.length > 0){
			for(var i in tab){
				$(this).parseTemplate({"values": settings.values,
									"path": path + '[' + i + ']',
									"css": settings.css,
									"style" : {"display": (values.boDirection == 'v') ? "inline-block" : "block", "width": (values.boDirection == 'v') ? 100 / (tab.length) + '%' : '100%', "height": (values.boDirection == 'h') ? 100 / (tab.length) + '%' : '100%'},
									"index": settings.index + 1,
									"type": type,
									"element": settings.element}).appendTo($(this));
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
			settings.path = "settings.values";
			settings.type = $(this).attr('id').replace('-model', '');
			settings.style = '';
			settings.element.html('');
			actions = [];
		}
		var this_values = eval(settings.path);

		if(settings.init){
		    formatForLoad(settings);
		    delete settings.init;
		}
		var span = $( "<span/>", {"class": settings.css, "text": (this_values.label) ? this_values.label : 'No Record'});
		for(var i in actions){
			var action = $( "<span/>", {"class": "fa action"});
			$("<span/>", {"class": '' + actions[i]}).appendTo(action);
			action.appendTo(span);
			action.click(function(event){
				event.stopPropagation();
				switch($(this).children().eq(0).attr("class")){
					case 'delete' :
						moveFromTo(settings, settings.path);
						break;
					case 'moveup' :
						moveFromTo(settings, settings.path, -1);
						break;
					case 'movedown' :
						moveFromTo(settings, settings.path, +1);
						break;
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
			$( "#dialog-" + settings.type ).data("settings", settings);
			$( "#dialog-" + settings.type ).data("this_values", this_values);
			$( "#dialog-" + settings.type ).dialog( "open" );
		});
		var found = false;
		for(var i in this_values){
			try{
				if('is_recursive' in this_values[i][0]){
					found = true;
					ul.addClass(settings.css + '-' + i);
					ul.createSubTemplate(settings, i);
					ul.children().addClass(settings.css + '-' + i);
				}
			}
			catch (e){}
		}
		
		if(found || $( "#dialog-" + settings.type ).dialog("option", "addArray").length){
			ul.appendTo(div);
			ul.data('path', settings.path);
		}
		if(settings.path == "settings.values"){
			ul = $( "<ul/>", {"class": settings.css + ' ' + settings.css + '-' + settings.type,
				"css": {"display": settings.style}});
			li.appendTo(ul);
			ul.appendTo($(this));
			
			if($( "#dialog-" + settings.type ).dialog("option", "addArray").length){
				$('ul.' + settings.css).parent().droppable({
					greedy: true,
					tolerance: "pointer",
					hoverClass: 'over',
					drop : function(event, ui){
						moveFromTo(settings, ui.draggable.data('path'), $(this).find('ul').data('path'));
					},
					accept: function(event){
						return event.attr("class").indexOf($(this).children('ul').attr("class")) >= 0;
					}
				});
				$('li.' + settings.css).draggable({
					opacity: 0.5,
					containment: settings.element,
					zIndex: 100,
					drag: function(event, ui){
						settings.element.find('div').unbind('mouseover');
						settings.element.find('div').unbind('mouseout');
					}
				});
			}
		}
		else{
			li.data('path', settings.path);
		}
		return li;
	}
    $.fn.getValue = function(values){
        var pre = $(this).attr('id').replace('dialog-', '') + '_';
        for(var i in values){
			try{
	        	if(!('is_recursive' in values[i][0])){
	        		delete values[i];
	        	}
			}
			catch(e){}
        }
        $(this).find(":input").not('button').each(function(){
	        var id = $(this).attr( "id" ).replace(pre, '');
	        if(!$(this).hasClass('not-mapped')){
	        	values[id] = $(this).val();
	        	if($(this).hasClass('used-as-label')){
	        		values.label = $(this).val();
	        		if($(this).is('select')){
	        			values.label = $(this).find(":selected").text();
	        		}
	        	}
	        }
        });
    }
    $.fn.setValue = function(values){
    	var pre = $(this).attr('id').replace('dialog-', '') + '_';
    	var ref = $(this);
        ref.find(":input").each(function(){
        	var id = $(this).attr("id").replace(pre, '');
        	var value = '';
        	if(id in values){
        		value = values[id]
        	}
        	if(value != $(this).val()){
	    		$(this).val(value);
	        	try{
		        	if('change' in $._data($(this)[0], 'events')){
		        		$(this).change();
		        		ref.setValue(values);
		        	}
	        	}
	        	catch(e){}
        	}
    	});
    }
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