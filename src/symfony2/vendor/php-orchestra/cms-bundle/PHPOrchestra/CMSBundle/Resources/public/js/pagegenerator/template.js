deleteDialogIfExists('dialog-template');
$('#dialog-template').dialog($.extend(getDialogParameter(), {"addArray" : ['areas']}));
$('#content div[role="content"]').html('');
$('#content div[role="content"]').model({"type" : "template"});