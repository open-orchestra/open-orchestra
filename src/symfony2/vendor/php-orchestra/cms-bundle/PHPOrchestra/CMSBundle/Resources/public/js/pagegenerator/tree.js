tree_parameter = {
    //extensions: ['persist', 'dnd'],
    /*persist: {
        expandLazy: true
    },*/
    autoActivate: false,
    autoScroll: true,
    clickFolderMode: 1,
    keyboard: false,
    selectMode: 1
};

var treeNodesMenuOptions = [
                            {'title': 'Créer une sous-page', 'cmd': 'createNode'},
                            {'title': 'Supprimer', 'cmd': 'deleteNode'}/*,
                            {'title': '----'},*/
                           ];

var treeTemplatesMenuOptions = [
                                {'title': 'Créer un template', 'cmd': 'createTemplate'},
                                {'title': 'Supprimer', 'cmd': 'deleteTemplate'}
                               ];

var treePreviousJs = {
        'deleteNode': function(){return confirmTreeDelete();},
        'deleteTemplate': function(){return confirmTemplateDelete();}
};

function treeAjaxCall(url, params)
{
    $('#rightbox-content').html('<h1><i class="fa fa-cog fa-spin"></i> Loading...</h1>');
    $.ajax({
        'type': 'POST',
        'url': url,
        'data': params,
        'success': function(response) {
            for (var selector in response) {
                $(selector).html(response[selector]);
            }
        },
        'dataType': 'json'
    });
}

function confirmTreeDelete()
{
    return confirm("Vous êtes sur le point de supprimer une page ainsi que toute la sous-arborescence associée.\n\nSi vous souhaitez tout supprimer, cliquez sur \"Ok\", sinon cliquez sur \"Annuler\" et déplacez d'abord la sous-arborescence.")
}

function confirmTemplateDelete()
{
    return confirm("Etes-vous certain de vouloir supprimer ce template ?")
}

function confirmDragNDrop()
{
    return confirm("Etes-vous certain de vouloir déplacer la sous-arcborescence ici ?")
}
