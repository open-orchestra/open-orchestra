deleteDialogIfExists('dialog-areas');
$('#dialog-areas').dialog($.extend(getDialogParameter(), {"addArray" : ['areas', 'blocks']}));