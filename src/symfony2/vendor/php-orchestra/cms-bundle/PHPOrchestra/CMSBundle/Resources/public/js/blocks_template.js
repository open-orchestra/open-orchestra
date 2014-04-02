function init(parameter){
	$(document).ready(function() {
        $.ajax({
            'type': 'POST',
            'url': parameter.urlNode,
            'success': function(response){
        		var container = $('#dialog-' + parameter.name).addSpan('start-' + parameter.name);
                var select = container.createSelect("Choose a node", parameter.name + "_nodeId", response.data, "nodeId", "name");
                select.change(function(){
            		subcontainer = container.addSpan('start-' + parameter.name);
                    if($(this).val()){
                        $.ajax({
                            'type': 'POST',
                            'url': parameter.urlBlock,
                            'success': function(response){
                                var select = subcontainer.createSelect("Choose a block", parameter.name + "_blockId", response.data, "blockId", "name");
                                select.addClass("used-as-label");
                            },
                            'data': {'nodeId' : $(this).val()},
                            'dataType': 'json',
                            'async': false
                        });
                    }
                });
            },
            'dataType': 'json',
            'async': false
        });
	});
}