var dialog_parameter = {};
var target;

function dt_0(){
	dialog_parameter = $.extend(dialog_parameter, {"addArray" : []});
	$( "#dialog-blocks" ).dialog(dialog_parameter);
	target = $( "#dialog-blocks form" );
	loadScript(urlJs + "pagegenerator/block.js?" + Math.random());
}

loadScript(urlJs + "pagegenerator/dialogNode.js?" + Math.random(), dt_0);