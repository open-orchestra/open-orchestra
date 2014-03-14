(function($){
	$.createSubTemplate = function(settings, type, target){
		var values = eval('settings.' + settings.path);
		var tab = eval('settings.' + settings.path + '.' + type);
		var path = settings.path + '.' + type;
		if(tab.length > 0){
			var width = (values.direction == 'h') ? 100 : (100 / Math.max(tab.length, 1)).toFixed(3);
			var height = (values.direction == 'v') ? 100 : (100 / Math.max(tab.length, 1)).toFixed(3);
			var style = {"top": "16px", "left": "16px", "bottom": "16px", "right": "16px"};
			for(var i in tab){
				i = parseInt(i);
				var value0 = (16 * (tab.length - i) / tab.length).toFixed(0);
				var value1 = (16 * (i + 1) / tab.length).toFixed(0);
				if(values.direction == 'h'){
					style.top = value0 + 'px';
					style.bottom = value1 + 'px';
				}
				else if(values.direction == 'v'){
					style.left = value0 + 'px';
					style.right = value1 + 'px';
				}
				$(target).parseTemplate({"width": width,
									"height": height,
									"values": settings.values,
									"path": path + '[' + i + ']',
									"css": settings.css,
									"style" : style,
									"index": settings.index + 1,
									"type": type,
									"element": settings.element});
			}
		}
	}
	$.fn.parseTemplate = function(options)
	{
		var empty_node = {"templateId": 0, "siteId": 0, "version": 1, "language": "fr", "status": "draft", "blocks": [], "areas": []};
		var empty_area = {"classes": [], "subAreas": [], "blocks": []};
		var empty_block = {"component": "No Controller", "attributes": []};
		var settings = $.extend({
			"width": 100,
			"height": 100,
			"values": empty_node,
			"path": null,
			"css": "ui-widget-model",
			"style": {"top": "0px", "left": "0px", "bottom": "0px", "right": "0px"},
			"index": 0,
			"type": "node",
			"element": null
		}, options || {});

		if(settings.path == null){
			settings.element = this;
			settings.path = "values";
			settings.element.html('');
			var html = '';

			html = '<label for="siteId">Site id : </label><input type="text" name="siteId" id="siteId" value=""><br />';
			html += '<label for="name">Name : </label><input type="text" name="name" id="name" value=""><br />';
			html += '<label for="language">Language : </label><input type="text" name="language" id="language" value="">';
			settings.element.append('<div class="dialog-node" style="display:none;" title="Node">' + html + '</div>');
			
			html = '<label for="areaId">Area id : </label><input type="text" name="areaId" id="areaId" value=""><br />';
			html += '<label for="classes">Name : </label><input type="text" name="classes" id="classes" value=""><br />';
			html += '<label for="addBlocks">add Blocks : </label><input type="checkbox" name="addBlocks" id="addBlocks">';
			settings.element.append('<div class="dialog-areas dialog-subAreas" style="display:none;" title="Area">' + html + '</div>');
			
			html = '<label for="component">Component : </label><input type="text" name="component" id="component" value=""><br />';
			html += '<label for="customAttribute">Custom Attributes : </label><input type="text" name="customAttributes" id="customAttributes" value=""><br />';
			settings.element.append('<div class="dialog-blocks" style="display:none;" title="Block">' + html + '</div>');

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
		var legend = $( "<h1/>", {"class": settings.css + '-legend', "text": title});		
		var fieldset = $( "<div/>", {"class": settings.css + '-fieldset', "css" : settings.style});
		var div = $( "<div/>", {"class": settings.css + ' ' + settings.css + '-' + settings.type,
								"css": {"width": String(settings.width) + '%',
										"height": String(settings.height) + '%',
										"z-index": settings.index
										}});
		legend.appendTo(fieldset);
		fieldset.appendTo(div);

		fieldset.mouseover(function(event){
			$(this).eq(0).addClass('over');
			event.stopPropagation();
		});
		fieldset.mouseout(function(){
			$(this).eq(0).removeClass('over');
		});
		
		fieldset.click(function(event){
			var this_values = eval('settings.' + settings.path);
			var refresh = function(){return false;};
			var save = function(){return false;};
			var open = function(){return false;};
			var create = function(){return false;};
			var send = function(){return false;};
			if(settings.type == "node" || settings.type == "areas" || settings.type == "subAreas"){
				create = function(obj){
					var buttons = obj.dialog( "option", "buttons" );
					if(this_values.direction){
						delete buttons['Split horizontally'];
						delete buttons['Split vertically'];
					}
					else{
						delete buttons['Split'];
					}
					if(settings.type != "node"){
						delete buttons['Send'];
					}
					obj.dialog( "option", "buttons", buttons);
				}
			}
			else if(settings.type == "blocks"){
				create = function(obj){
					var buttons = obj.dialog( "option", "buttons" );
					delete buttons['Split horizontally'];
					delete buttons['Split vertically'];
					delete buttons['Split'];
					delete buttons['Send'];
					obj.dialog( "option", "buttons", buttons);
				}
			}
			if(settings.type == "node"){
				refresh = function(obj){
					this_values.areas.push(empty_area);
				}
				save = function(obj){
					this_values.siteId = obj.find("input[name=\'siteId\']").val();
					this_values.name = obj.find("input[name=\'name\']").val();
					this_values.language = obj.find("input[name=\'language\']").val();
				}
				open = function(obj){
					obj.find("input[name='siteId']").val(this_values.siteId);
					obj.find("input[name='name']").val(this_values.name);
					obj.find("input[name='language']").val(this_values.language);
				}
				send = function(obj){
					$("#template_siteId").val(settings.values.siteId);
					$("#template_name").val(settings.values.name);
					$("#template_version").val(settings.values.version);
					$("#template_language").val(settings.values.language);
					$("#template_status").val(settings.values.status);
					$("#template_templateId").val(settings.values.templateId);
					$("#template_areas").val(JSON.stringify(settings.values.areas));
					$("#template_blocks").val(JSON.stringify(settings.values.blocks));
					$("form[name='template']").submit();
				}
			}
			else if(settings.type == "areas" || settings.type == "subAreas"){
				refresh = function(obj){
					if(obj.find("input[name='addBlocks']").is(':checked')){
						var length = settings.values.blocks.length;
						settings.values.blocks[length] = empty_block;
						this_values.blocks.push({"nodeId": 0, "blockId": length});
					}
					else{
						this_values.subAreas.push(empty_area);
					}
				}
				save = function(obj){
					this_values.areaId = obj.find("input[name=\'areaId\']").val();
					this_values.classes = obj.find("input[name=\'classes\']").val().split(',');
				}
				open = function(obj){
					obj.find("input[name='areaId']").val(this_values.areaId);
					obj.find("input[name='classes']").val(this_values.classes.join(','));
					if(this_values.blocks.length > 0){
						obj.find("input[name='addBlocks']").attr("checked", "checked");
					}
					if(this_values.blocks.length > 0 || this_values.subAreas.length > 0){
						obj.find("input[name='addBlocks']").attr('disabled','disabled');;
					}
				}
			}
			else if(settings.type == "blocks"){
				save = function(obj){
					settings.values.blocks[this_values.blockId].component = obj.find("input[name=\'component\']").val();
					settings.values.blocks[this_values.blockId].attributes = obj.find("input[name=\'customAttributes\']").val().split(',');
				}
				open = function(obj){
					obj.find("input[name='component']").val(settings.values.blocks[this_values.blockId].component);
					obj.find("input[name='customAttributes']").val(settings.values.blocks[this_values.blockId].attributes.join(','));
				}
			}
			$( ".dialog-" + settings.type ).dialog({
				resizable: false,
				width:490,
				modal: true,
				open: function ( event, ui) {
					open($(this));
				},
				create: function ( event, ui) {
					create($(this));
				},
				buttons: {
					"Save": function() {
						save($(this));
						$(this).dialog( "close" );
					},
					"Send": function() {
						send($(this));
						$(this).dialog( "close" );
					},
					"Split horizontally": function() {
						this_values.direction = "h";
						refresh($(this));
						$(this).dialog( "close" );
					},
					"Split vertically": function() {
						this_values.direction = "v";
						refresh($(this));
						$(this).dialog( "close" );
					},
					"Split": function() {
						refresh($(this));
						$(this).dialog( "close" );
					}
				},
				close: function ( event, ui) {
					//console.log(JSON.stringify(settings.values.areas));
					$(this).dialog( "destroy" );
					settings.element.parseTemplate({'values': settings.values});
				}
			});
			event.stopPropagation();
		});
		$(div).draggable();
		
		if(this_values.areas){
			$.createSubTemplate(settings, 'areas', fieldset);
		}
		else{
			if(this_values.blocks && this_values.blocks.length > 0){
				$.createSubTemplate(settings, 'blocks', fieldset);
			}
			else if(this_values.subAreas && this_values.subAreas.length > 0){
				$.createSubTemplate(settings, 'subAreas', fieldset);
			}
		}
		div.appendTo(this);
	}
})(jQuery);