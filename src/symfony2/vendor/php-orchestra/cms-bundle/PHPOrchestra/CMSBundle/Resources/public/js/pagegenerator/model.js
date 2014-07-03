function getValueInObject(data, path, key){
	try{
		return (key) ? eval('data' + path + '.' + key) : eval('data' + path);
	}
	catch(e){
	}
}
function resetPercent(objects){
	for(var i in objects){
		delete objects[i].boPercent;
	}
}
function formIdToName(prefix, data){
	var result = [];
	for(var i in data){
		result.push({'name': prefix + '[' + i.replace('_', '][') + ']', 'value': data[i]});
	}
	return result;
}
(function($){
    $.fn.fromFormToJs = function()
    {
		return this.each(function(){
			var data = getValueInObject($(this).data('container').data('settings'), $(this).data('path'));
			var prefix = $(this).data('type');
			var ref = $(this);
	        for(var i in data){
				try{
					'ui-model' in data[i][0];
				}
				catch(e){
					if(i != 'ui-model'){
						delete data[i];
					}
				}
	        }
	        $(this).find(":input").not('button').each(function(){
		        var id = $(this).attr( "id" ).replace(prefix + '_', '');
		        if(!$(this).hasClass('not-mapped') && id != '_token'){
		        	data[id] = $(this).val();
		        	if('ui-model' in data){
			        	if($(this).hasClass('used-as-label')){
			        		data['ui-model'].label = $(this).val();
			        		if($(this).is('select')){
			        			data['ui-model'].label = $(this).find(":selected").text();
			        		}
			        	}
		        	}
		        }
	        });
    		if('method' in data){
			    $.ajax({
			        'type': 'GET',
			        'url': $(this).find('form').attr("action"),
			        'success': function(response){
			    		data['ui-model']['html'] = response.data;
			        },
			        'data': $.extend(data, {'preview': true}),
			        'dataType': 'json',
			        'async': false
			    });
    		}
		});
    }
    $.fn.fromJsToForm = function()
    {
		return this.each(function(){
			var data = getValueInObject($(this).data('container').data('settings'), $(this).data('path'));
			var prefix = $(this).data('type');
			var ref = $(this);
			var refresh = $(this).find(":input.refresh");
			if(refresh.length){
				refresh.eq(0).refreshForm(formIdToName(prefix, data));
			}
	        $(this).find(':input[id!="' + prefix + '__token"]').each(function(){
	        	var id = $(this).attr("id").replace(prefix + '_', '');
	        	if(id in data){
	        		$(this).val(data[id]);
	        	}
	        	else{
	        		$(this).val('');
	        	}
	    	});
		});
    }
	$.fn.moveFromTo = function(source, destination){
		return this.each(function(){
			var pattern = new RegExp('^(.*)\\.(.*?)\\[(\\d*)]$');
			var container = $(this).parents('.ui-model');
			var data = container.data('settings');
			eval(source.replace(pattern, 'var sourceInfo = {"tab" : eval("data$1.$2"), "type" : "$2", "index" : $3};'));
			var remove = sourceInfo.tab.splice(sourceInfo.index, 1)[0];
			if(typeof destination != 'undefined'){
				if(isNaN(destination) || destination == ''){
					destination = 'data' + destination;
					eval(destination + ' = $.extend({}, {"' + sourceInfo.type + '" : []}, ' + destination + ');');
					eval(destination + '.' + sourceInfo.type + '.unshift(remove);');
					resetPercent(eval(destination + '.' + sourceInfo.type));
				}
				else{
					var new_index = (sourceInfo.index + destination + sourceInfo.tab.length) % sourceInfo.tab.length;
					sourceInfo.tab.splice(new_index, 0, remove);
				}
			}
			resetPercent(sourceInfo.tab);
	    	container.parent().model({"type" : container.data('type'), "resizable" : container.data('resizable')});
		});
	}
	$.fn.changeSize = function(coordinate, size){
		eval('size = 100 * (size) / $(this).offsetParent().' + coordinate + '();');
		$(this).css(coordinate, size + '%');
	}
	$.fn.setSettings = function(options)
	{
		return this.each(function(){
			var settings = $(this).data('settings');
			eval('values = ' + $("#" + options.type + "_areas").val() + ';');
			if('areas' in values){
				settings.areas = values.areas;
			}
			settings['ui-model'] = {};
			$("#dialog-" + options.type).data('path', '');
			$("#dialog-" + options.type).fromFormToJs();
		});
	}
	$.fn.setSubmit = function(options)
	{
		return this.each(function(){
			var settings = $(this).data('settings');
			$("#" + $(this).data('type') + "_areas").val(JSON.stringify(settings.areas));
		});
	}
	$.fn.addAction = function(actions)
	{
		return this.each(function(){
			type = 'none';
			for(var i in actions){
				$("<i/>").addClass(i).click({'js': actions[i].join('')}, function(event){
					event.stopPropagation();
					eval(event.data.js);
				}).appendTo($(this));
			}
		});
	}
	$.fn.model = function(options)
	{
		return this.each(function(){

			options = $.extend({
				"css": "",
				"path" : "",
				"type" : ""
			}, options || {});

			var container = $.merge($(this).find('.ui-model'), $(this).parents('.ui-model'));

			if(container.length == 0){
				container = $( "<div/>").addClass("ui-model");
				container.appendTo($(this));
				container.data(options);
				container.data('settings', {});
				$('#dialog-' + options.type).data('container', container);
				$('#dialog-' + options.type).data('type', options.type);
				for(var i in allowed_object){
					var key = allowed_object[i];
					$('#dialog-' + key).data('type', key);
					$('#dialog-' + key).data('container', container);
				}
				container.setSettings(options);
			}
			$(this).data(options);
			
			var this_settings = getValueInObject(container.data('settings'), options.path);
			var bo_direction_tools = (this_settings.boDirection == 'v') ? {'axe' : 'x', 'origine': 'left', 'vector':'width', 'css':'inline', 'prefix':'v'} : {'axe' : 'y', 'origine': 'top', 'vector':'height', 'css':'block', 'prefix':'h'};
			var is_container = $(this).find('.ui-model').length > 0;
			var father_length = getValueInObject(container.data('settings'), options.parent_path + '.' + options.type, 'length');
			var father_bo_direction = (father_bo_direction = getValueInObject(container.data('settings'), options.parent_path, 'boDirection')) ? father_bo_direction : 'h';

			var div = $("<div/>");
			$("<span/>").addClass("title")
						.text(getValueInObject(container.data('settings'), options.path + "['ui-model']", 'label'))
						.appendTo(div);
			$("<span/>").addClass("preview")
						.html(getValueInObject(container.data('settings'), options.path + "['ui-model']", 'html'))
						.appendTo(div);
			$("<span/>").addClass("action")
						.addAction(returnActions(options, father_length, father_bo_direction))
						.appendTo(div);
			if(is_container){
				container.empty();
				container.append(
					$("<ul/>").addClass('ui-model-' + options.type)
							  .append($("<li/>").append(div)));
			}
			else{
				div.appendTo($(this));
			}

			var addArray = $("#dialog-" + options.type).dialog("option", "addArray");

			for(var i in this_settings){
				try{
					if('ui-model' in this_settings[i][0]){
						addArray = [i];
						var ul = $( "<ul/>");
						ul.appendTo(div);
						ul.addClass('ui-model-' + i);
						for(var j in this_settings[i]){
							var subli = $( "<li/>");
							var path = options.path + '.' + i + '[' + j + ']';
							subli.appendTo(ul);
							boPercent = (boPercent = getValueInObject(container.data('settings'), path, "boPercent")) ? boPercent : 100 / (this_settings[i].length);
							subli.css(bo_direction_tools.vector, boPercent + '%');
							subli.addClass('ui-model-' + i)
							subli.model({'path' : path, 'parent_path': options.path, 'type' : i});
							if(j != this_settings[i].length -1 && container.data('resizable')){
								var separator = $('<li/>', {"class": 'separator-'+ bo_direction_tools.prefix});
								separator.appendTo(ul);
								(function(s){
									separator.draggable({
										opacity: 1,
										zIndex: 100,
										axis: s.axe,
										drag: function(event, ui){
											size = $(this).offset()[s.origine] - $(this).data('source');
											$(this).prev().changeSize(s.vector, $(this).data('prev') + size);
											$(this).next().changeSize(s.vector, $(this).data('next') - size);
										},
										start: function(){
											$(this).data('source', $(this).offset()[s.origine]);
											$(this).data('prev', eval('$(this).prev().' + s.vector + '()'));
											$(this).data('next', eval('$(this).next().' + s.vector + '()'));
										},
										stop: function(event, ui){
											$(this).css(s.origine, 'auto');
											var container = $(this).parents('.ui-model');
											var data = container.data('settings');
											eval('data' + $(this).prev().data('path') + '.boPercent = ' + parseFloat($(this).prev()[0].style[s.vector]) + ';');
											eval('data' + $(this).next().data('path') + '.boPercent = ' + parseFloat($(this).next()[0].style[s.vector]) + ';');
									    	container.parent().model({"type" : container.data('type'), "resizable" : container.data('resizable')});
										}
									})
								})(bo_direction_tools);
							}
							if(container.data('resizable')){
								subli.draggable({
									'opacity': 0.5,
									'containment': container,
									'zIndex': 100
									
								});
							}
						}
						ul.children().addClass(bo_direction_tools.css);
					}
				}
				catch (e){}
			}
			if(container.data('resizable')){
				div.droppable({
					greedy: true,
					tolerance: "pointer",
					hoverClass: 'over',
					drop : function(event, ui){
						if(ui.draggable.data("path")){
							$(this).moveFromTo(ui.draggable.data("path"), options.path);
						}
					},
					accept: function(ui){
						var accept = false;
						for(var i in addArray){
							accept = accept || ui.hasClass('ui-model-' + addArray[i]);
						}
						return accept;
					}
				});
			}
		});
	}

})(jQuery);