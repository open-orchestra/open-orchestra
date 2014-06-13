var dialog_parameter = {};

function dt_0(){
	dialog_parameter = $.extend(dialog_parameter, {"addArray" : ['areas']});
	$( "#dialog-template" ).dialog(dialog_parameter);
	loadScript(urlJs + "pagegenerator/model.js", dt_1);
}
function dt_1(){
	$('#rightbox-content').append('<div id="template-model" class="main-model"></div>')
	$('#template-model').parseModel({"init" : true});
}

loadScript(urlJs + "pagegenerator/dialogNode.js?" + Math.random(), dt_0);