var dialog_parameter = {
        resizable: false,
        width:530,
        modal: true,
        autoOpen: false,
        open: function ( event, ui) {
            var data = $(this).data();
            var found = false;
            var buttons = $(this).dialog("option", "allbuttons");
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
	                if('areas' in data.settings.values){
	                    $("#template_areas").val(JSON.stringify(data.settings.values.areas));
	                }
	                if('blocks' in data.settings.values){
	                    $("#template_blocks").val(JSON.stringify(data.settings.values.blocks));
	                }
	                $("form[name='template']").submit();
	                $(this).dialog( "close" );
	           }
            });
            $(this).dialog("option", "buttons", buttons);
            $(this).find(":input").setValue(data.this_values);
        },
        allbuttons: {
            "Apply": function() {
                var data = $(this).data();
                $(this).find(":input").getValue(data.this_values);
                $(this).dialog( "close" );
            }
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

		if(settings.path == null){
			settings.element = this;
			settings.path = "values";
			settings.type = "node";
			settings.style = '';
			settings.element.html('');
		}
		
		var this_values = eval('settings.' + settings.path);
		var title = '';
		if(settings.type == "node"){
		    $( ".dialog-node" ).find(":input").getValue(this_values);
			title = (this_values.name) ? this_values.name : 'No Template Name';
		}
		else if(settings.type == "areas"){
			title = (this_values.areaId) ? this_values.areaId : 'No HTML ID';
		}
		else if(settings.type == "blocks"){
			title = (this_values.component) ? this_values.component : 'No Controller';
		}
		var span = $( "<span/>", {"class": settings.css, "text": title});
		var div = $( "<div/>", {"class": settings.css});
		var li = $( "<li/>", {"class": settings.css, "css": settings.style});
		var ul = $( "<ul/>", {"class": settings.css});
		span.appendTo(div);
		div.appendTo(li);

		div.mouseover(function(event){
			$(this).addClass('over');
			event.stopPropagation();
		});
		div.mouseout(function(){
			$(this).removeClass('over');
		});
		div.click(function(event){
			event.stopPropagation();
			var type = settings.type;
			$( ".dialog-" + type ).data("settings", settings);
			$( ".dialog-" + type ).data("this_values", this_values);
			$( ".dialog-" + type ).dialog( "open" );
		});
		ul.addClass(settings.css + '-' + 'none');
		for(var i in this_values){
			if(Array.isArray(this_values[i]) && this_values[i].length > 0){
				ul.addClass(settings.css + '-' + i);
				$.createSubTemplate(settings, i, ul);
				ul.children().addClass(settings.css + '-' + i);
				ul.removeClass(settings.css + '-' + 'none');
			}
		}
		ul.appendTo(div);
		ul.data('path', settings.path);
		if(settings.path == "values"){
			ul = $( "<ul/>", {"class": settings.css + ' ' + settings.css + '-' + 'node',
				"css": {"display": settings.style}});
			li.appendTo(ul);
			ul.appendTo(this);
			$('ul.' + settings.css + '-' + 'areas, ul.' + settings.css + '-' + 'blocks, ul.' + settings.css + '-' + 'none').parent().droppable({
				greedy: true,
				tolerance: "pointer",
				hoverClass: 'over',
				drop : function(event, ui){
					var this_values = eval('settings.' + $(this).find('ul').data('path'));
					var move = eval('settings.' + ui.draggable.data('path'));
					if("blockId" in move){
						this_values.blocks.push(move);
					}
					else{
						this_values.areas.push(move);
					}
					var pattern = new RegExp('^(.*)\\[(\\d*)]$');
					var path = 'settings.' + ui.draggable.data('path');
					eval(path.replace(pattern, '$1.splice($2, 1);'));
					settings.element.parseTemplate($.extend(settings, {"path": null}));
				},
				deactivate : function(){
				}
			});
			$('ul.' + settings.css + '-' + 'areas').parent().droppable({
				accept: 'li.' + settings.css + '-' + 'areas',
			});
			$('ul.' + settings.css + '-' + 'none').parent().droppable({
				accept: 'li.' + settings.css + '-' + 'areas, li.' + settings.css + '-' + 'blocks',
			});
			$('ul.' + settings.css + '-' + 'blocks').parent().droppable({
				accept: 'li.' + settings.css + '-' + 'blocks',
			});
		}
		else{
			li.data('path', settings.path);
			li.draggable({
				opacity: 0.5,
				containment: settings.element,
				drag: function(event, ui){
					settings.element.find('div').unbind('mouseover');
					settings.element.find('div').unbind('mouseout');
				}
			});
		}
		return li;
	}
    $.fn.getValue = function(values, pre){
    	if($(this).length > 1){
            var pre = ($(this).parents("form").length) ? $(this).parents("form").attr("name") + '_' : '';
	    	$(this).each(function(){
	    		$(this).getValue(values, pre);
	    	});
    	}
    	else{
	        var id = $(this).attr( "id" ).replace(pre, '');
	        values[id] = $(this).val();
    	}
    }
    $.fn.setValue = function(values, pre){
    	if($(this).length > 1){
            var pre = ($(this).parents("form").length) ? $(this).parents("form").attr("name") + '_' : '';
	    	$(this).each(function(){
	    		$(this).setValue(values, pre);
	    	});
    	}
    	else{
	        var id = $(this).attr( "id" ).replace(pre, '');
	        $(this).val('');
	        if(id in values){
	            $(this).val(values[id]);
	        }
    	}
    }
})(jQuery);