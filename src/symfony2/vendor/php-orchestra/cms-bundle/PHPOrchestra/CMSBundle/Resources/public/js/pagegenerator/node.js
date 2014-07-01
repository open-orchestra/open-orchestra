function returnNextActionType(length, direction){
	actionType = 'none';
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
			}
	};
	return actions[type];
}
deleteDialogIfExists('dialog-node');
$('#dialog-node').dialog($.extend(getDialogParameter(), {"addArray" : []}));
$('#content div[role="content"]').html('');
$('#content div[role="content"]').model({"type" : "node", "resizable" : false});
