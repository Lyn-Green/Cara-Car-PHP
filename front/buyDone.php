<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json;charset=utf-8");
try{
	    // 連線 MySQL
        if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1') {
            // 開發環境
            require_once("../connectChd104g6.php");
        } else {
            // 生產環境
            require_once("https://tibamef2e.com/chd104/g6/api/connectChd104g6.php");
        }


	// $memId = $_GET["member_id"];
	$sql = "INSERT INTO ord_list (ord_reciever, ord_city, ord_district, ord_address, ord_phone, remark) VALUES 
	(:ord_reciever, :ord_city, :ord_district, :ord_address, :ord_phone, :remark);";
	//編譯, 執行
	$order = $pdo->prepare($sql);	

	$order->bindValue(":ord_reciever", $_POST["ord_reciever"]);
	$order->bindValue(":ord_city", $_POST["ord_city"]);
	$order->bindValue(":ord_district", $_POST["ord_district"]);
	$order->bindValue(":ord_address", $_POST["ord_address"]);
	$order->bindValue(":ord_phone", $_POST["ord_phone"]);
	$order->bindValue(":remark", $_POST["remark"]);

	$order->execute();

    $msg = "完成訂購";
}
catch (PDOException $e) {
	$msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
}
//輸出結果
$result = ["msg"=>$msg];
echo json_encode($result);
?>