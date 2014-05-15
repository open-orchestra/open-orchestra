/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël GILAIN <noel.gilain@businessdecision.com>
 */

$(document).ready(function() {

    $(function() {
        $("#dialog-clearRoutingCache").dialog({
            autoOpen : false,
            modal : true,
            width: 370,
            buttons : [
                {
                    html : "Cancel",
                    "class" : "btn btn-default",
                    click : function() {
                        $(this).dialog("close");
                    }
                },
                {
                    html : "<i class='fa fa-check'></i>&nbsp; OK",
                    "class" : "btn btn-primary",
                    click : function() {
                        $(this).dialog("close");
                        window.location.hash = clearingUrl;
                    }
                }
            ]
        });
    });

    $('#clearRoutingCache').click(function(e) {
        $("#dialog-clearRoutingCache").dialog("open");
    });
});