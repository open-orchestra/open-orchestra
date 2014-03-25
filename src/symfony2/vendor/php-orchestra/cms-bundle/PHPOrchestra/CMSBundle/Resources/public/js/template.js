(function($){
	$.generateFunction = function(type){
		var functions = {'create': function(){return false;},
				'add': function(){return false;},
				'save': function(){return false;},
				'open': function(){return false;},
				'send': function(){return false;}
				}
		functions['save'] = function(obj, settings, this_values){
			obj.find(":input").each(function(){
				var name = $(this).attr('id').replace(settings.form_name + '_', '');
				if(!Array.isArray(this_values[name])){
					this_values[name] = $(this).val();
				}
				else if($(this).is(':visible')){
					this_values[name] = $(this).val().split(',');
				}
			});
		}
		functions['open'] = function(obj, settings, this_values){
			obj.find(":input").each(function(){
				var name = $(this).attr('id').replace(settings.form_name + '_', '');
				if(!Array.isArray(this_values[name])){
					$(this).val(this_values[name]);
				}
				else if($(this).is(':visible')){
					$(this).val(this_values[name].join(','));
				}
			});
		}
		if(type == "node"){
			functions = $.extend(functions, $.generateNodeFunction());
		}
		else if(type == "areas" || type == "subAreas"){
			functions = $.extend(functions, $.generateAreaFunction());
		}
		else if(type == "blocks"){
			functions = $.extend(functions, $.generateBlockFunction());
		}
		return functions;
	}
	$.generateNodeFunction = function(){
		var empty_area = {"classes": [], "subAreas": [], "blocks": []};
		var create = function(obj, settings, this_values){
			var buttons = obj.dialog( "option", "buttons" );
			delete buttons['Add Blocks'];
			delete buttons['Add Areas'];
			obj.dialog( "option", "buttons", buttons);
		}
		var add = function(obj, settings, this_values){
			this_values.direction = obj.find("select[name=\'direction\']").val();
			this_values.areas.push(empty_area);
		}
		var send = function(obj, settings, this_values){
			$("#template_areas").val(JSON.stringify(settings.values.areas));
			$("#template_blocks").val(JSON.stringify(settings.values.blocks));
			$("form[name='template']").submit();
		}
		return {'create': create,
				'add': add,
				'send': send
			};
	}
	$.generateAreaFunction = function(settings, this_values){
		var empty_area = {"classes": [], "subAreas": [], "blocks": []};
		var empty_block = {"component": "No Controller", "attributes": []};
		var create = function(obj, settings, this_values){
			var buttons = obj.dialog( "option", "buttons" );
			delete buttons['Save'];
			if(this_values.blocks.length > 0 || this_values.subAreas.length > 0){
				delete buttons['Add Blocks'];
				delete buttons['Add Areas'];
			}
			else{
				delete buttons['Add'];
			}
			obj.dialog( "option", "buttons", buttons);
		}
		var add = function(obj, settings, this_values, type){
			this_values.direction = obj.find("select[name=\'direction\']").val();
			if(this_values.blocks.length > 0 || type == 'block'){
				var length = settings.values.blocks.length;
				settings.values.blocks[length] = empty_block;
				this_values.blocks.push({"nodeId": 0, "blockId": length});
			}
			else{
				this_values.subAreas.push(empty_area);
			}
		}
		return {'create': create,
			'add': add
		};
	}
	$.generateBlockFunction = function(settings, this_values){
		var create = function(obj, settings, this_values){
			var buttons = obj.dialog( "option", "buttons" );
			delete buttons['Save'];
			delete buttons['Add'];
			delete buttons['Add Blocks'];
			delete buttons['Add Areas'];
			obj.dialog( "option", "buttons", buttons);
		}
		var save = function(obj, settings, this_values){
			settings.values.blocks[this_values.blockId].component = obj.find("input[name=\'component\']").val();
			settings.values.blocks[this_values.blockId].attributes = obj.find("input[name=\'customAttributes\']").val().split(',');
		}
		var open = function(obj, settings, this_values){
			obj.find("input[name='component']").val(settings.values.blocks[this_values.blockId].component);
			obj.find("input[name='customAttributes']").val(settings.values.blocks[this_values.blockId].attributes.join(','));
		}
		return {'create': create,
			'save': save,
			'open': open
			};
	}
	$.createSubTemplate = function(settings, type, target){
		var values = eval('settings.' + settings.path);
		var tab = eval('settings.' + settings.path + '.' + type);
		var path = settings.path + '.' + type;
		values.direction = (values.direction) ? values.direction : 'h';
		if(tab.length > 0){
			for(var i in tab){
				$(target).parseTemplate({"values": settings.values,
									"path": path + '[' + i + ']',
									"css": settings.css,
									"style" : {"display": (values.direction == 'v') ? "inline-block" : "block", "width": (values.direction == 'v') ? 100 / (tab.length) + '%' : '100%', "height": (values.direction == 'h') ? 100 / (tab.length) + '%' : '100%'},
									"index": settings.index + 1,
									"type": type,
									"element": settings.element,
									"form_name": settings.form_name}).appendTo(target);
			}
		}
	}
	$.fn.parseTemplate = function(options)
	{
		var settings = $.extend({
			"values": $(this).data(),
			"css": "ui-widget-model",
			"form_name": ''
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
			title = ((this_values.name) ? this_values.name : 'No Template Name');
		}
		else if(settings.type == "areas" || settings.type == "subAreas"){
			title = ((this_values.areaId) ? this_values.areaId : 'No HTML ID');
		}
		else if(settings.type == "blocks"){
			title = ((settings.values.blocks[this_values.blockId].component) ? settings.values.blocks[this_values.blockId].component : 'No Controller');
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
			var type = settings.type;
			if(settings.type == "subAreas"){
				type = "areas";
			}
			var functions = $.generateFunction(type);
			$( ".dialog-" + type ).dialog({
				resizable: false,
				width:530,
				modal: true,
				open: function ( event, ui) {
					functions.open($(this), settings, this_values);
				},
				create: function ( event, ui) {
					functions.create($(this), settings, this_values);
				},
				buttons: {
					"Apply": function() {
						functions.save($(this), settings, this_values);
						$(this).dialog( "close" );
					},
					"Save": function() {
						functions.send($(this), settings, this_values);
						$(this).dialog( "close" );
					},
					"Add": function() {
						functions.add($(this), settings, this_values);
						$(this).dialog( "close" );
					},
					"Add Blocks": function() {
						functions.add($(this), settings, this_values, 'block');
						$(this).dialog( "close" );
					},
					"Add Areas": function() {
						functions.add($(this), settings, this_values, 'area');
						$(this).dialog( "close" );
					}
				},
				close: function ( event, ui) {
					$(this).dialog( "destroy" );
					settings.element.parseTemplate($.extend(settings, {"path": null}));
				}
			});
			event.stopPropagation();
		});
		if(this_values.areas){
			ul.addClass(settings.css + '-' + 'areas');
			$.createSubTemplate(settings, 'areas', ul);
			ul.children().addClass(settings.css + '-' + 'areas');
		}
		else if(this_values.blocks && this_values.blocks.length > 0){
			ul.addClass(settings.css + '-' + 'blocks');
			$.createSubTemplate(settings, 'blocks', ul);
			ul.children().addClass(settings.css + '-' + 'blocks');
		}
		else if(this_values.subAreas && this_values.subAreas.length > 0){
			ul.addClass(settings.css + '-' + 'areas');
			$.createSubTemplate(settings, 'subAreas', ul);
			ul.children().addClass(settings.css + '-' + 'areas');
		}
		else{
			ul.addClass(settings.css + '-' + 'none');
		}
		if(settings.type != 'blocks'){
			ul.appendTo(div);
		}
		ul.data('path', settings.path);
		if(settings.path == "values"){
			ul = $( "<ul/>", {"class": settings.css + ' ' + settings.css + '-' + 'nodes',
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
						if("subAreas" in this_values){
							this_values.subAreas.push(move);
						}
						else{
							this_values.areas.push(move);
						}
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
})(jQuery);