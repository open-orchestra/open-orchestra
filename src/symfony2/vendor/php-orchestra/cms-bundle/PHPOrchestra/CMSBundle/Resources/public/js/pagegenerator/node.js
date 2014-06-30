deleteDialogIfExists('dialog-node');
$('#dialog-node').dialog($.extend(getDialogParameter(), {"addArray" : []}));
$('#rightbox-content').html('');
$('#rightbox-content').model({"type" : "node"});
