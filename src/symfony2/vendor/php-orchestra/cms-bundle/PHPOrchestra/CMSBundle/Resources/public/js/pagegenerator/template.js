function returnNextActionType(length, direction){
	actionType = 'alone';
	if(length > 1){
		actionType = direction;
	}
	return actionType;
}
function returnNextAction(type){
	type = (!type) ? 'none' : type;
	var actions = {
			'none': {
				'fa fa-cog' : [
		       	   	'$( "#dialog-" + options.type ).data("path", options.path);',
		       	   	'$( "#dialog-" + options.type ).fromJsToForm(this_settings);',
		       		'$( "#dialog-" + options.type ).dialog( "open" );'
		       	]
			},
			'v': {
				'fa fa-trash-o' : [
				    '$(this).moveFromTo(options.path);',
		       	],
		       	'fa fa-arrow-circle-o-right' : [
		       		'$(this).moveFromTo(options.path, +1);',
		       	],
		       	'fa fa-arrow-circle-o-left' : [
		       		'$(this).moveFromTo(options.path, -1);',
		       	],
		       	'fa fa-cog' : [
		       	   	'$( "#dialog-" + options.type ).data("path", options.path);',
		       	   	'$( "#dialog-" + options.type ).fromJsToForm(this_settings);',
		       		'$( "#dialog-" + options.type ).dialog( "open" );'
		       	]
			},
			'h': {
				'fa fa-trash-o' : [
				    '$(this).moveFromTo(options.path);',
		       	],
		       	'fa fa-arrow-circle-o-down' : [
		       		'$(this).moveFromTo(options.path, +1);',
		       	],
		       	'fa fa-arrow-circle-o-up' : [
		       		'$(this).moveFromTo(options.path, -1);',
		       	],
		       	'fa fa-cog' : [
		       	   	'$( "#dialog-" + options.type ).data("path", options.path);',
		       	   	'$( "#dialog-" + options.type ).fromJsToForm(this_settings);',
		       		'$( "#dialog-" + options.type ).dialog( "open" );'
		       	]
			},
			'alone': {
				'fa fa-trash-o' : [
				    '$(this).moveFromTo(options.path);',
		       	],
		       	'fa fa-cog' : [
		       	   	'$( "#dialog-" + options.type ).data("path", options.path);',
		       	   	'$( "#dialog-" + options.type ).fromJsToForm(this_settings);',
		       		'$( "#dialog-" + options.type ).dialog( "open" );'
		       	]
			}
		};
	return actions[type];
}
deleteDialogIfExists('dialog-template');
$('#dialog-template').dialog($.extend(getDialogParameter(), {"addArray" : ['areas']}));
$('#content div[role="content"]').html('');
$('#content div[role="content"]').model({"type" : "template", "resizable" : true});