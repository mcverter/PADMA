<?php $tableID = self::RESULT_TABLE_ID; ?>
        <!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="../extensions/TableTools/css/dataTables.tableTools.css">
	<link rel="stylesheet" type="text/css" href="../extensions/ColReorder/css/dataTables.colReorder.css">
	<link rel="stylesheet" type="text/css" href="../extensions/ColVis/css/dataTables.colVis.css">

<!-- jQuery -->
<script type="text/javascript" charset="utf8" src="../js/jquery.js"></script>

<!-- DataTables -->
<script type="text/javascript" charset="utf8" src="../js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../extensions/TableTools/js/dataTables.tableTools.js"></script>
<script type="text/javascript" language="javascript" src="../extensions/ColReorder/js/dataTables.colReorder.js"></script>
<script type="text/javascript" language="javascript" src="../extensions/ColVis/js/dataTables.colVis.js"></script>
<script>
$(document).ready( function () {
    $('#{$tableID}').dataTable( {
        "dom": 'RC<"clear">lfrtip',
        "tableTools": {
            "sSwfPath": "/swf/copy_csv_xls_pdf.swf"
        }
    } );
}  );
</script>
