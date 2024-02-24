<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
try{
    require_once("../connectChd104g6.php");

	// 检查必填字段是否為空
    $requiredFields = array("sh_ord_reciever", "sh_ord_city", "sh_ord_district", "sh_ord_address", "sh_ord_phone");
    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $msg = "請填寫完整資訊才能完成訂購";
            $result = array("msg" => $msg);
            echo json_encode($result);
            exit(); // 终止执行后续代码
        }
    }

	// $memId = $_GET["member_id"];
	$sql = "INSERT INTO sh_ord (sh_pro_id, member_id, sh_ord_reciever, sh_ord_city, sh_ord_district, sh_ord_address, sh_ord_phone, remark, sh_ord_ship, sh_ord_sum, sh_ord_total, ord_del_state) VALUES 
	(:sh_pro_id ,:member_id, :sh_ord_reciever, :sh_ord_city, :sh_ord_district, :sh_ord_address, :sh_ord_phone, :remark, :sh_ord_ship, :sh_ord_sum, :sh_ord_total, :ord_del_state);";
	//編譯, 執行
	$order = $pdo->prepare($sql);	

	$order->bindValue(":sh_pro_id", $_POST["sh_pro_id"]);
	$order->bindValue(":member_id", $_POST["member_id"]);
	$order->bindValue(":sh_ord_reciever", $_POST["sh_ord_reciever"]);
	$order->bindValue(":sh_ord_city", $_POST["sh_ord_city"]);
	$order->bindValue(":sh_ord_district", $_POST["sh_ord_district"]);
	$order->bindValue(":sh_ord_address", $_POST["sh_ord_address"]);
	$order->bindValue(":sh_ord_phone", $_POST["sh_ord_phone"]);
	$order->bindValue(":remark", $_POST["remark"]);
	$order->bindValue(":sh_ord_ship", $_POST["sh_ord_ship"]);
	$order->bindValue(":sh_ord_sum", $_POST["sh_ord_sum"]);
	$order->bindValue(":sh_ord_total", $_POST["sh_ord_total"]);
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