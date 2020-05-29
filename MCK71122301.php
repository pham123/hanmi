<?php
session_start();
ob_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');


include 'config.php';
getfunc('db');
$oDB = new db();
// var_dump($db);
if (isset($_COOKIE['hanmi'])&&$_COOKIE['hanmi']=='8400a17d1d3a92967a2e63b5522baaaa') {
    # code...
}else{
    echo "Please contact with admin";
    exit();
}

if (isset($_POST['hanmicode'])&&strlen($_POST['hanmicode'])==22) {
    $code = $_POST['hanmicode'];
    $pattern = 'MCK71122301_ST_****_*****';
    #Kiểm tra xem mã tem có đảm bảo không
    $check = 1;
    if (strlen($pattern)!=strlen($code)) {
        $_SESSION['message'] = "<h1 style='background-color:red;'>Độ dài tem ".$code." không hợp lệ .".$pattern."</h1>";
        header('Location: ?');
        exit();
    }
    for ($i=0; $i < strlen($code) ; $i++) { 
        if ( $pattern[$i]!='*') {
            if ( $pattern[$i]!=$code[$i]) {
                $_SESSION['message'] = "<h1 style='background-color:red;'>Cấu trúc tem ".$code." không hợp lệ</h1>";
            $check = 0;
            break;
            }
        }else{
            if ( !is_numeric($code[$i])) {
                $_SESSION['message'] = "<h1 style='background-color:red;'>Cấu trúc tem ".$code." không hợp lệ, phần chữ số có chứa kí tự</h1>";
                $check = 0;
                break;
                }
        }
    }

    if ($check == 0) {
        header('Location: ?');
        exit();
    }

    $stationid = 7;
    //Lấy về thông tin label 
    $LabelHistory = $oDB->query('SELECT * FROM LabelHistory WHERE TraceStationId = ? AND LabelHistoryLabelValue =? ', $stationid,$code)->fetchArray();
            //var_dump();
    if (isset($LabelHistory['TraceStationId'])) {
        $_SESSION['message'] = "<h1 style='background-color:red;'>Mã tem ".$LabelHistory['LabelHistoryLabelValue']." đã được khai báo trên hệ thống : ".$LabelHistory['LabelHistoryCreateDate']." </h1>";
        header('Location:?');
        exit();
    }else{
        // Chưa có thì tiếp tục
    }

    //Insert thông tin label
    $oDB->query("INSERT INTO LabelHistory (`TraceStationId`,`LabelHistoryQuantityOk`,`LabelHistoryLabelValue`) VALUES (7,1,?)",$code);

    $_SESSION['message'] = "<h1 style='background-color:green;'>Thêm thành công mã tem : ".$code." lúc ".date("Y-m-d H:i:s")." </h1>";
    header('Location:?');
    exit();

} else {
//Không thấy post
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hanmi Station</title>
    <script>
        function startTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('txt').innerHTML =
        h + ":" + m + ":" + s;
        var t = setTimeout(startTime, 500);
        }
        function checkTime(i) {
        if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
        return i;
        }
    </script>
    <style>
        input{
            width:80%;
            text-align:center;
            padding:10px;
            margin:10px;
            font-size:30px;
        }
    </style>
</head>
<body onload="startTime()">
<table style='width:100%;body'>
        <tr>
            <th style='font-size:30px;'>HUD Cover Bottom RHD single (MCK71122301)</th>
            <th>
            <span style='text-align:center;font-size:25px;'>Time : <?php echo date("d-m-Y") ?> </span>
            <span id="txt" style='text-align:center;font-size:25px;'></span>
            </th>
        </tr>

        <tr>
            <td colspan="2" style='text-align:center;'>
                <form action="" method="post">
                <input type="text" name="hanmicode" placeholder='Đọc code cho sản phẩm' pattern="^[A-Z0-9_]{22}$" title="Input QR code" autofocus required>
                </form>
            </td>
        </tr>
</table>

<?php
if (isset($_SESSION['message'])) {
    echo $_SESSION['message'];
}
?>
<p><a href="MCK71113301.php">VW AR HUD cover bottom single</a></p>
<p><a href="MCK71122301.php">HUD Cover Bottom RHD single</a></p>

<p><a href="MCK71113301NG.php">Sản phẩm lỗi: VW AR HUD cover bottom single</a></p>
<p><a href="MCK71122301NG.php">Sản phẩm lỗi: HUD Cover Bottom RHD single</a></p>
<p><a href="report.php">Báo cáo</a></p>
</body>
</html>