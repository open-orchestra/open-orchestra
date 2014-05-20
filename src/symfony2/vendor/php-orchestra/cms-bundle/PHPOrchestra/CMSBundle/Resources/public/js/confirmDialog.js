/**
 * This file is part of the PHPOrchestra\CMSBundle.
 *
 * @author Noël GILAIN <noel.gilain@businessdecision.com>
 */

function ConfirmDialog(confirmId, okCallback, width)
{
    /**
     * dialog html Id
     */
    this.confirmId = confirmId;
    
    /**
     * callback executed when user confirm
     */
    this.okCallback = okCallback;
    
    /**
     * dialog width
     */
    this.width = width;
    
    /**
     * Create the dialog
     */
    this.create = function()
    {
        var that = this;
        
        $("#dialog-" + this.confirmId).dialog(
            that.getConf(that.okCallback, that.width)
        );
        
        $('#' + this.confirmId).click(function(e) {
            $("#dialog-" + that.confirmId).dialog("open");
        });
    }
    
    /**
     * Get dialog conf
     */
    this.getConf = function()
    {
        var that = this;
        
        var confirmConf = {
            autoOpen : false,
            modal : true,
            width: this.width,
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
                        that.okCallback($(this).dialog("option", "okParams"));
                    }
                }
            ]
        };
        return confirmConf;
    }
}