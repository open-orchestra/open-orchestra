var dialog_parameter = {};

function dt_0(){
	dialog_parameter = $.extend(dialog_parameter, {"addArray" : []});
	$( "#dialog-blocks" ).dialog(dialog_parameter);
}

loadScript(urlJs + "pagegenerator/dialogNode.js?" + Math.random(), dt_0);