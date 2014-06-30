deleteDialogIfExists('dialog-areas');
$('#dialog-areas').dialog($.extend(dialog_parameter, {"addArray" : ['areas', 'blocks']}));