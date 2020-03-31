<h2 data-i18n="extension_attributes.extension_attributes"></h2>
<div id="extension_attributes-tab"></div>

<div id="extension_attributes-msg" data-i18n="listing.loading" class="col-lg-12 text-center"></div>

<script>
$(document).on('appReady', function(){
    // Set blank tab badge
    $('#extension_attributes-cnt').text("");

    $.getJSON(appUrl + '/module/extension_attributes/get_tab_data/' + serialNumber, function(data){
                
        if( ! data ){
            $('#extension_attributes-msg').text(i18n.t('no_data'));
        } else {
            
            // Hide
            $('#extension_attributes-msg').text('');
            // Update the tab badge
            $('#extension_attributes-cnt').text(data.length);
            
            // Build out the ea table
            $('#extension_attributes-tab')
                .append('<div id="extension_attributes-table-view" class="row" style="padding-left: 15px; padding-right: 15px;"><table class="table table-striped table-condensed table-bordered" id="extension_attributes-table"><thead><tr><th data-colname="extension_attributes.displayname">'+i18n.t('extension_attributes.displayname')+'</th><th data-colname="extension_attributes.result">'+i18n.t('extension_attributes.result')+'</th></tr></thead><tbody><tr><td data-i18n="listing.loading" colspan="2" class="dataTables_empty"></td></tr></tbody></table></div>')

            // Parse the JSON string into vaiable
            var table_data = data;
            var known_networks = true;
            $('#extension_attributes-table').DataTable({

                data: table_data,
                order: [[0,'asc']],
                autoWidth: false,
                columns: [
                    { data: 'displayname' },
                    { data: 'result' }
                ],
                createdRow: function( nRow, aData, iDataIndex ) {
                    // Format new lines
                    var celldata=$('td:eq(1)', nRow).text();
                    $('td:eq(1)', nRow).html(celldata.replace(/\n/g, "<br>").replace(/\r/g, "<br>"))
                }
            });
        }
    });
});
</script>