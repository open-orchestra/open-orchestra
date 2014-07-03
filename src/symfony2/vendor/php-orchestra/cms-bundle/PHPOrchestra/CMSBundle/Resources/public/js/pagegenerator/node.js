var allowed_object = ['areas', 'blocks'];

function returnActions(options, length, direction){
	id = 'none';
	var actions = {
			'none': {
				'fa fa-cog' : [
		       	   	'$("#dialog-' + options.type + '").data(' + JSON.stringify(options) + ');',
		       	   	'$("#dialog-' + options.type + '").data("source", $(this).closest("li"));',
		       	   	'$("#dialog-' + options.type + '").fromJsToForm();',
		       		'$("#dialog-' + options.type + '").dialog( "open" );'
		       	]
			}
	};
	return actions[id];
}

deleteDialogIfExists('dialog-node');
$('#dialog-node').dialog($.extend(getDialogParameter(), {"addArray" : []}));
$('#content div[role="content"]').html('');
$('#content div[role="content"]').model({"type" : "node", "resizable" : false});
