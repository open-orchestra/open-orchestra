function loadDataTableScripts(path, listurl, order) {
    
    loadCss(path + "plugin/DataTables-1.10.0/media/css/jquery.dataTables.min.css");
    loadCss(path + "plugin/DataTables-1.10.0/media/css/jquery.dataTables_themeroller.min.css");
    loadScript(path + "plugin/DataTables-1.10.0/media/js/jquery.dataTables.min.js", dt_1);
    
    
    function dt_1() {
        loadCss(path + "plugin/DataTables-1.10.0/extensions/AutoFill/css/dataTables.autoFill.min.css");
        loadScript(path + "plugin/DataTables-1.10.0/extensions/AutoFill/js/dataTables.autoFill.min.js", dt_2);
    }
    function dt_2() {
        loadCss(path + "plugin/DataTables-1.10.0/extensions/ColReorder/css/dataTables.colReorder.min.css");
        loadScript(path + "plugin/DataTables-1.10.0/extensions/ColReorder/js/dataTables.colReorder.min.js", dt_3);
    }
    function dt_3() {
        loadCss(path + "plugin/DataTables-1.10.0/extensions/ColVis/css/dataTables.colVis.min.css");
        loadScript(path + "plugin/DataTables-1.10.0/extensions/ColVis/js/dataTables.colVis.min.js", dt_4);
    }
    function dt_4() {
        loadCss(path + "plugin/DataTables-1.10.0/extensions/FixedColumns/css/dataTables.fixedColumns.min.css");
        loadScript(path + "plugin/DataTables-1.10.0/extensions/FixedColumns/js/dataTables.fixedColumns.min.js", dt_5);
    }
    function dt_5() {
        loadCss(path + "plugin/DataTables-1.10.0/extensions/FixedHeader/css/dataTables.fixedHeader.min.css");
        loadScript(path + "plugin/DataTables-1.10.0/extensions/FixedHeader/js/dataTables.fixedHeader.min.js", dt_6);
    }
    function dt_6() {
        loadCss(path + "plugin/DataTables-1.10.0/extensions/KeyTable/css/dataTables.keyTable.min.css");
        loadScript(path + "plugin/DataTables-1.10.0/extensions/KeyTable/js/dataTables.keyTable.min.js", dt_7);
    }
    function dt_7() {
        loadCss(path + "plugin/DataTables-1.10.0/extensions/Scroller/css/dataTables.scroller.min.css");
        loadScript(path + "plugin/DataTables-1.10.0/extensions/Scroller/js/dataTables.scroller.min.js", dt_8);
    }
    function dt_8() {
        loadCss(path + "plugin/DataTables-1.10.0/extensions/TableTools/css/dataTables.tableTools.min.css");
        loadScript(path + "plugin/DataTables-1.10.0/extensions/TableTools/js/dataTables.tableTools.min.js", 
        runDataTables(path, listurl, order));
    }
}
function runDataTables(path, listurl, order) {
    var table = $('#datatable_fixed_column').dataTable({
        "serverSide": true,
        "ordering": true,
        "order": order,
        "searching": false,
        "scroller": {
            "loadingIndicator": true,
            "displayBuffer": 2
        },
        "ajax": function ( data, callback, settings ) {
        	$(".DTS_Loading").show();
            var start = (data.start) ? data.start : 0;
            var length = (data.length) ? data.length : 0;
            var criteria = $('.search_init').filter(function() { return $(this).val() != ""; }).serialize();
            var sort = {};
            for(var i in data.order){
                var name = $('.search_init').eq(data.order[i].column).attr('name');
                sort[name] = (data.order[i].dir == "asc") ? 1 : -1;
            }
            $.ajax({
                "type": "POST",
                "url": listurl,
                "dataType": "json",
                "data": { "parse": true, "start": start, "length": length, "criteria": criteria, "sort": sort},
            })
            .done(function( records ) {
            	$(".DTS_Loading").hide();
                out = records.data.values;
                callback( {
                    draw: data.draw,
                    data: out,
                    recordsTotal: records.data.count,
                    recordsFiltered: records.data.partialCount
                } );
            });
        },
        "dom": 'R<"top-tools"TC><"clear">rtiS',
        "tableTools": {
            "sSwfPath": path + "plugin/DataTables-1.10.0/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
        },
        "scrollY": 200
    } );
    
    $('.search_init').on( 'keyup change', function (e) {
        table._fnDraw();
    } );
}

function createDeleteConfirmDialog(){
	var deleteDocument = new ConfirmDialog(
	        'deleteDocument',
	        function(params){
	            window.location.hash = params.url;
	        },
	        370
	    );
	    
	deleteDocument.create();
}

$(document).ready(function() {
	
	$('#content').on('click', 'button.redirect', function(){
		window.location.hash = $(this).attr('data-parameter');
	});
	
	$('#content').on('click', 'button.submit', function(){
		var data = $('#content form').serializeArray();
	    displayLoader();
		$.post($(this).attr('data-parameter') , data, function (response) {
			if(response.success){
				window.location.hash = response.data;
			}
			else{
				$('#content').html(response.data);
			}
		});
	});
	$('#content').on('click', 'button.delete', function(){
	    $("#dialog-deleteDocument").dialog({'okParams' : {'url' : $(this).attr('data-parameter')}});
	    $("#dialog-deleteDocument").dialog("open");
	});    
});