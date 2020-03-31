<?php $this->view('partials/head'); ?>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h3><span data-i18n="extension_attributes.report"></span> <span id="total-count" class='label label-primary'>…</span></h3>
            <table class="table table-striped table-condensed table-bordered">
                <thead>
                    <tr>
                        <th data-i18n="listing.computername" data-colname='machine.computer_name'></th>
                        <th data-i18n="serial" data-colname='reportdata.serial_number'></th>
                        <th data-i18n="extension_attributes.displayname" data-colname='extension_attributes.displayname'></th>
                        <th data-i18n="extension_attributes.result" data-colname='extension_attributes.result'></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-i18n="listing.loading" colspan="4" class="dataTables_empty"></td>
                    </tr>
                </tbody>
            </table>
        </div> <!-- /span 13 -->
    </div> <!-- /row -->
</div>  <!-- /container -->

<script type="text/javascript">

	$(document).on('appUpdate', function(e){

		var oTable = $('.table').DataTable();
		oTable.ajax.reload();
		return;

	});

	$(document).on('appReady', function(e, lang) {

        // Get modifiers from data attribute
        var mySort = [], // Initial sort
            hideThese = [], // Hidden columns
            col = 0, // Column counter
            runtypes = [], // Array for runtype column
            columnDefs = [{ visible: false, targets: hideThese }]; //Column Definitions

        $('.table th').map(function(){

            columnDefs.push({name: $(this).data('colname'), targets: col, render: $.fn.dataTable.render.text()});

            if($(this).data('sort')){
              mySort.push([col, $(this).data('sort')])
            }

            if($(this).data('hide')){
              hideThese.push(col);
            }

            col++
        });

	    oTable = $('.table').dataTable( {
            ajax: {
                url: appUrl + '/datatables/data',
                type: "POST",
                data: function(d){
                    d.mrColNotEmpty = "extension_attributes.displayname";
                }
            },
            dom: mr.dt.buttonDom,
            buttons: mr.dt.buttons,
            order: mySort,
            columnDefs: columnDefs,
            createdRow: function( nRow, aData, iDataIndex ) {
	        	// Update name in first column to link
	        	var name=$('td:eq(0)', nRow).html();
	        	if(name == ''){name = "No Name"};
	        	var sn=$('td:eq(1)', nRow).html();
	        	var link = mr.getClientDetailLink(name, sn, '#tab_extension_attributes-tab');
	        	$('td:eq(0)', nRow).html(link);

	        	// Format new lines
	        	var celldata=$('td:eq(3)', nRow).text();
	        	$('td:eq(3)', nRow).html(celldata.replace(/\n/g, "<br>").replace(/\r/g, "<br>"))
            }
	    } );
        
	    // Use hash as searchquery
	    if(window.location.hash.substring(1))
	    {
			oTable.fnFilter( decodeURIComponent(window.location.hash.substring(1)) );
	    }
	} );
</script>

<?php $this->view('partials/foot')?>
