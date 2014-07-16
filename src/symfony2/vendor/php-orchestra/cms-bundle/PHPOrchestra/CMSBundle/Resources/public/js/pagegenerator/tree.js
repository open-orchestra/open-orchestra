var treeAjaxCallDialog = {
    resizable: false,
    width:530,
    modal: true,
    close: function ( event, ui) {
        $(this).dialog("destroy");
    }
};

function treePlaceHolder(name, ui){
	$('.' + name + '-sortable-placeholder').html('<a href="">' + ui.helper.find('a').html() + '</a>');
	ui.helper.css('display', 'none');
}

function treeParameter(name, moveUrl, target){
	return {
	    connectWith: '.' + name + '-connectedSortable',
	    placeholder: name + '-sortable-placeholder active',
	    toleranceElement: '> div',
	    appendTo: "body",
	    helper: 'clone',
	    items: "li:not(.ui-state-unsortable)",
	    stop: function(event, ui){
	        treeAjaxCall(moveUrl, {'node':ui.item.data('tree-parameter'), 'parentNode':ui.item.parents('li').eq(0).data('tree-parameter')});
	    }
	};
}

function treeAjaxCall(url, params, target)
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
   				target.refreshNav();	
    		}
    		else{
	    		newDiv = $(response.dialog);
	    		if('url' in response){
	    			newDiv.dialog($.extend({	
	    				'buttons' : [
	    		               {
	    		                   "click" : function(){
	    		                       treeAjaxCall(response.url, response.value, target);
	    		                       $(this).dialog("close");
	    		                   },
	    		                   "text" : "Confirmer",
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
	    			target.refreshNav();	
	                window.setTimeout(function() {
	                    newDiv.dialog("close");
	                }, 2000);
	    		}
    		}
        }
    });
}

(function($){
    $.fn.treeRedirect = function(target)
    {
    	return this.each(function(){
    	    treeAjaxCall($(this).data('url'), $(this).closest('li').data('tree-parameter'), target);
    	});
    }
    $.fn.refreshNav = function(){
    	return this.each(function(){
	        var refThis = $(this);
	        $.ajax({
	            'type': 'POST',
	            'url': refThis.data('url'),
	            'success': function(response){
	                refThis.replaceWith(response);
	                refThis.jarvismenu({
	                	accordion : true,
	                	speed : $.menu_speed,
	                	closedSign : '<em class="fa fa-expand-o"></em>',
	                	openedSign : '<em class="fa fa-collapse-o"></em>'
	                }); 
	            },
	            'data': {'controller' : refThis.data('controller')},
	            'async': false
	        });
    	});
    }
})(jQuery);