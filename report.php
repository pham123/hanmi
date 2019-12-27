<?php
session_start();
ob_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');

include 'config.php';
getfunc('db');
$oDB = new db();
// var_dump($db);
if (isset($_COOKIE['hanmi'])&&$_COOKIE['hanmi']=='8400a17d1d3a92967a2e63b5522baaaa') {
    $LabelHistory = $oDB->query('SELECT * FROM LabelHistory WHERE TraceStationId = 7 ORDER BY LabelHistoryId DESC LIMIT 1000')->fetchAll();

}else{
    echo "Please contact with admin";
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script type="text/javascript" src="jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="DataTables/datatables.min.css"/>
    <script type="text/javascript" src="DataTables/datatables.min.js"></script>
</head>
<body>
    <h1>Lịch sử đọc QR code</h1>
    <p><a href="./">Về trang chủ</a></p>
    <table id="myTable" class="display" style="width:100%">
    <thead>
        <tr>
            <th>TT</th>
            <th>Code</th>
            <th>Time</th>
        </tr>
    </thead>
    <tbody>

        <?php
        foreach ($LabelHistory as $key => $value) {

        echo "<tr>";
        echo    "<td>".($key+1)."</td>";
        echo    "<td>".$value['LabelHistoryLabelValue']."</td>";
        echo    "<td>".$value['LabelHistoryCreateDate']."</td>";
        echo "</tr>";
        }
        ?>
    </tbody>
    
    </table>
</body>

<script>
$(document).ready( function () {
    $('#myTable').DataTable(
        {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'excel'
        ]
        }
    );
} );
</script>
</html>
