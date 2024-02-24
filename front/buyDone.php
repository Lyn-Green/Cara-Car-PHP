<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
try{
    require_once("../connectChd104g6.php");

	// 检查必填字段是否為空
    $requiredFields = array("ord_reciever", "ord_city", "ord_district", "ord_address", "ord_phone");
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $msg = "請填寫完整資訊才能完成訂購";
            $result = array("msg" => $msg);
            echo json_encode($result);
            exit(); // 终止执行后续代码
        }
    }

	// $memId = $_GET["member_id"];
	$sql = "INSERT INTO ord_list (member_id, ord_reciever, ord_city, ord_district, ord_address, ord_phone, remark, ord_ship, ord_sum, ord_total, ord_del_state) VALUES 
	(:member_id, :ord_reciever, :ord_city, :ord_district, :ord_address, :ord_phone, :remark, :ord_ship, :ord_sum, :ord_total, :ord_del_state);";
	//編譯, 執行
	$order = $pdo->prepare($sql);	

	$order->bindValue(":member_id", $_POST["member_id"]);
	$order->bindValue(":ord_reciever", $_POST["ord_reciever"]);
	$order->bindValue(":ord_city", $_POST["ord_city"]);
	$order->bindValue(":ord_district", $_POST["ord_district"]);
	$order->bindValue(":ord_address", $_POST["ord_address"]);
	$order->bindValue(":ord_phone", $_POST["ord_phone"]);
	$order->bindValue(":remark", $_POST["remark"]);
	$order->bindValue(":ord_ship", $_POST["ord_ship"]);
	$order->bindValue(":ord_sum", $_POST["ord_sum"]);
	$order->bindValue(":ord_total", $_POST["ord_total"]);
	$order->bindValue(":ord_del_state", $_POST["ord_del_state"]);


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