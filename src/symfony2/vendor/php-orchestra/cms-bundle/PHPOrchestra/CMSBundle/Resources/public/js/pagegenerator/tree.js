var treeAjaxCallDialog = {
    resizable: false,
    width:530,
    modal: true,
    close: function ( event, ui) {
        $(this).dialog("destroy");
    }
};

function treeAjaxCall(url, params)
{
	var newDiv = $(document.createElement('div')); 
	newDiv.html('<h1><i class="fa fa-cog fa-spin"></i> Loading...</h1>');
	newDiv.dialog($.extend({'title' : 'Mise à jour'}, treeAjaxCallDialog));
	
    $.ajax({
        'type': 'POST',
        'url': url,
        'data': params,
        'success': function(response) {
    		newDiv.dialog("close");
    		
    		if(typeof response == 'string'){
    			$('#content').html(response);
    		}
    		else{
	    		newDiv = $(response.dialog);
	    		if('url' in response){
	    			newDiv.dialog($.extend({	
	    				'buttons' : [
	    		               {
	    		                   "click" : function(){
	    		                       treeAjaxCall(response.url, response.value);
	    		                       $(this).dialog("close");
	    		                   },
	    		                   "text" : "Confimer",
	    		                   "class" : "btn btn-danger"
	    		               },
	    		               {
	    		                   "click" : function(){
	    		                       $(this).dialog("destroy");
	    		                   },
	    		                   "text" : "Annuler",
	    		                   "class" : "btn btn-default"
	    		               }]}, treeAjaxCallDialog));
	    		}
	    		else{
	    			newDiv.dialog(treeAjaxCallDialog);
	                window.setTimeout(function() {
	                    newDiv.dialog("close");
	                }, 2000);
	    		}
    		}
        }
    });
}

