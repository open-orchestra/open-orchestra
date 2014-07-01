function tagAsModelElement(tab, keys){
	for(var i in keys){
		var key = keys[i];
		if(key in tab){
			for(var j in tab[key]){
				tagAsModelElement(tab[key][j], keys);
				tab[key][j]['ui-model'] = {};
			}
		}
	}
}
function untagAsModelElement(tab, keys){
	for(var i in keys){
		var key = keys[i];
		if(key in tab){
			for(var j in tab[key]){
				untagAsModelElement(tab[key][j], keys);
				delete tab[key][j]['ui-model'];
			}
		}
	}
}
function refreshSettings(tab, keys){
	for(var i in keys){
		var key = keys[i]
		if(key in tab){
			for(var j in tab[key]){
				$( "#dialog-" + key ).fromJsToForm(tab[key][j]);
				$( "#dialog-" + key ).fromFormToJs(tab[key][j]);
				refreshSettings(tab[key][j], keys);
			}
		}
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
    $.fn.fromFormToJs = function(data)
    {
		return this.each(function(){
			var prefix = $(this).attr('id').replace('dialog-', '');
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
    $.fn.fromJsToForm = function(data)
    {
		return this.each(function(){
			var prefix = $(this).attr('id').replace('dialog-', '');
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
	    	container.parent().model({"type" : container.data('target'), "resizable" : container.data('resizable')});
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
			settings['ui-model'] = {};
			$("#dialog-" + options.type).fromFormToJs($(this).data('settings'));
			settings.areas = eval($("#" + options.type + "_areas").val());
			tagAsModelElement(settings, $(this).data('subtab'));
			refreshSettings(settings, $(this).data('subtab'));
		});
	}
	$.fn.setSubmit = function(options)
	{
		return this.each(function(){
			var settings = $(this).data('settings');
			untagAsModelElement(settings, $(this).data('subtab'));
			$("#" + $(this).data('target') + "_areas").val(JSON.stringify(settings.areas));
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
				container.data('settings', {});
				container.data('target', options.type);
				container.data('resizable', options.resizable);
				container.data('subtab', ['areas', 'blocks']);
				container.setSettings(options);
			}
			
			$('#dialog-' + options.type).data('container', container);
			var container_settings = container.data('settings');
			var this_settings = eval('container_settings' + options.path);
			var boDirection = (this_settings.boDirection == 'v') ? 'v' : 'h';
			var is_container = $(this).find('.ui-model').length > 0;
			var title = $("<span/>").addClass("title").text(('label' in this_settings['ui-model']) ? this_settings['ui-model'].label : 'No Record');
			var div = $("<div/>");
			var action = $("<span/>").addClass("action");
			title.appendTo(div);
			if('html' in this_settings['ui-model']){
				var preview = $("<span/>").addClass("preview").html(this_settings['ui-model']['html']);
				preview.appendTo(div);	
			}
			action.appendTo(div);

			if(is_container){
				container.empty();
				var ul = $("<ul/>").addClass('ui-model-' + options.type);
				var li = $( "<li/>");
				div.appendTo(li);
				li.appendTo(ul);
				ul.appendTo(container);
			}
			else{
				div.appendTo($(this));
			}
			var actions = returnNextAction(options.actions);
			for(var i in actions){
				$("<i/>").addClass(i).click({'js': actions[i].join('')}, function(event){
					event.stopPropagation();
					eval(event.data.js);
				}).appendTo(action);
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
							var obj = this_settings[i][j];
							var subli = $( "<li/>");
							var path = options.path + '.' + i + '[' + j + ']';
							subli.appendTo(ul);
							obj.boPercent = (!("boPercent" in obj)) ? 100 / (this_settings[i].length) : obj.boPercent;						
							subli.css('width', (boDirection == 'v') ? obj.boPercent + '%' : '100%');
							subli.css('height', (boDirection == 'h') ? obj.boPercent + '%' : '100%');
							subli.addClass('ui-model-' + i)
							subli.data('path', path);
							subli.model({'path' : path, 'type' : i, 'actions': returnNextActionType(this_settings[i].length, boDirection)});
							if(j != this_settings[i].length -1 && container.data('resizable')){
								var separator = $('<li/>', {"class": 'separator-'+ boDirection});
								separator.appendTo(ul);
								var parameter = (boDirection == 'v') ? {'axe' : 'x', 'origine': 'left', 'vector':'width'} : {'axe' : 'y', 'origine': 'top', 'vector':'height'};
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
									    	container.parent().model({"type" : container.data('target'), "resizable" : container.data('resizable')});
										}
									})
								})(parameter);
							}
							subli.draggable({
								'opacity': 0.5,
								'containment': container,
								'zIndex': 100
								
							});
						}
						if(boDirection == 'v'){
							ul.children().addClass('inline');
						}
						else{
							ul.children().addClass('block');
						}
					}
				}
				catch (e){}
			}

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
		});
	}

})(jQuery);