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
		result.push({'name': prefix + '_' + i, 'value': data[i]});
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
	        $(this).find(":input")
	        	.not('.not-mapped')
	        	.not('#' + prefix + '_token')
	        	.each(function(){
			        var id = $(this).attr( "id" ).replace(prefix + '_', '');
		        	data[id] = $(this).val();
		        	if($(this).hasClass('used-as-label')){
		        		data['ui-model'].label = (!$(this).is('select')) ? $(this).val() : $(this).find(":selected").text();
		        	}
	        });
    		if('ui-model' in data && 'html' in data['ui-model'] && (url = $(this).find('form').attr("action")) != ''){
    			if(url != ''){
				    $.ajax({
				        'type': 'POST',
				        'url': url,
				        'success': function(response){
				    		data['ui-model']['html'] = response.data;
				        },
				        'data': $.extend(data, {'preview': true}),
				        'dataType': 'json',
				        'async': false
				    });
    			}
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
	        	$(this).val(getValueInObject(data, '', id));
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
			settings.areas = getValueInObject(values, '', 'areas');
			settings['ui-model'] = {};
			$("#dialog-" + options.type).data('path', '');
			$("#dialog-" + options.type).fromFormToJs();
		});
	}
	$.fn.setSubmit = function(options)
	{
		return this.each(function(){
			var settings = $(this).data('settings');
			$("#" + $(this).data('type') + "_areas").val(JSON.stringify({'areas' : settings.areas}));
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
	$.fn.activDraggable = function(parameters){
		return this.each(function(){
			$(this).draggable({
				opacity: 1,
				zIndex: 100,
				axis: parameters.axe,
				drag: function(event, ui){
					size = $(this).offset()[parameters.origine] - $(this).data('origine');
					$(this).prev().changeSize(parameters.vector, $(this).data('prev') + size);
					$(this).next().changeSize(parameters.vector, $(this).data('next') - size);
				},
				start: function(){
					$(this).data('origine', $(this).offset()[parameters.origine]);
					$(this).data('prev', eval('$(this).prev().' + parameters.vector + '()'));
					$(this).data('next', eval('$(this).next().' + parameters.vector + '()'));
				},
				stop: function(event, ui){
					$(this).css(parameters.origine, 'auto');
					var container = $(this).parents('.ui-model');
					var data = container.data('settings');
					eval('data' + $(this).prev().data('path') + '.boPercent = ' + parseFloat($(this).prev()[0].style[parameters.vector]) + ';');
					eval('data' + $(this).next().data('path') + '.boPercent = ' + parseFloat($(this).next()[0].style[parameters.vector]) + ';');
			    	container.parent().model({"type" : container.data('type'), "resizable" : container.data('resizable')});
				}
			})
		});
	}
	$.fn.activDroppable = function(css){
		return this.each(function(){
			$(this).droppable({
				greedy: true,
				tolerance: "pointer",
				hoverClass: 'over',
				drop : function(event, ui){
					if(ui.draggable.data("path")){
						$(this).moveFromTo(ui.draggable.data("path"), $(this).parent().data("path"));
					}
				},
				accept: css
			});
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

			var addArray = $.merge([], $("#dialog-" + options.type).dialog("option", "addArray"));

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
							if(container.data('resizable')){
								if(j != this_settings[i].length -1){
									var separator = $('<li/>', {"class": 'separator-'+ bo_direction_tools.prefix});
									separator.appendTo(ul);
									separator.activDraggable(bo_direction_tools);
								}
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
				for(var i in addArray){
					addArray[i] = '.ui-model-' + addArray[i];
				}
				div.activDroppable(addArray.join(', '));
			}
		});
	}

})(jQuery);