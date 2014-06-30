deleteDialogIfExists('dialog-template');
$('#dialog-template').dialog($.extend(getDialogParameter(), {"addArray" : ['areas']}));
$('#rightbox-content').html('');
$('#rightbox-content').model({"type" : "template"});