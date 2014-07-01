deleteDialogIfExists('dialog-node');
$('#dialog-node').dialog($.extend(getDialogParameter(), {"addArray" : []}));
$('#content div[role="content"]').html('');
$('#content div[role="content"]').model({"type" : "node"});
