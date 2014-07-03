var allowed_object = ['areas', 'blocks'];

function returnActions(options, length, direction){
	id = 'none';
	if(length){
		id = 'alone';
		if(length > 1){
			id = direction;
		}
	}
	var actions = {
		'fa fa-trash-o' : [
		    '$(this).moveFromTo("' + options.path + '");',
       	],
       	'fa fa-arrow-circle-o-right' : [
       		'$(this).moveFromTo("' + options.path + '", +1);',
       	],
       	'fa fa-arrow-circle-o-left' : [
       		'$(this).moveFromTo("' + options.path + '", -1);',
       	],
       	'fa fa-cog' : [
       	   	'$("#dialog-' + options.type + '").data(' + JSON.stringify(options) + ');',
       	   	'$("#dialog-' + options.type + '").data("source", $(this).closest("li"));',
       	   	'$("#dialog-' + options.type + '").fromJsToForm();',
       		'$("#dialog-' + options.type + '").dialog( "open" );'
       	]
	};
	var actions = {
		'none': {
			'fa fa-cog' : actions['fa fa-cog']
		},
		'v': {
			'fa fa-trash-o' : actions['fa fa-trash-o'],
	       	'fa fa-arrow-circle-o-right' : actions['fa fa-arrow-circle-o-right'],
	       	'fa fa-arrow-circle-o-left' : actions['fa fa-arrow-circle-o-left'],
	       	'fa fa-cog' : actions['fa fa-cog']
		},
		'h': {
			'fa fa-trash-o' : actions['fa fa-trash-o'],
	       	'fa fa-arrow-circle-o-down' : actions['fa fa-arrow-circle-o-right'],
	       	'fa fa-arrow-circle-o-up' : actions['fa fa-arrow-circle-o-left'],
	       	'fa fa-cog' : actions['fa fa-cog']
		},
		'alone': {
			'fa fa-trash-o' : actions['fa fa-trash-o'],
	       	'fa fa-cog' : actions['fa fa-cog']
		}
	};
	return actions[id];
}

deleteDialogIfExists('dialog-template');
$('#dialog-template').dialog($.extend(getDialogParameter(), {"addArray" : ['areas']}));
$('#content div[role="content"]').html('');
$('#content div[role="content"]').model({"type" : "template", "resizable" : true});