<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json;charset=utf-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

try{
    require_once("../connectChd104g6.php");

	$sql = "INSERT INTO member (m_name, m_birthday, m_email, m_phone, m_city, m_district, m_address, member_psw) VALUES 
	(:m_name, :m_birthday, :m_email, :m_phone, :m_city, :m_district, :m_address, :member_psw);";

	//編譯, 執行
	$member = $pdo->prepare($sql);	

	$member->bindValue(":m_name", $_POST["m_name"]);
	$member->bindValue(":m_birthday", $_POST["m_birthday"]);
	$member->bindValue(":m_email", $_POST["m_email"]);
	$member->bindValue(":m_phone", $_POST["m_phone"]);
	$member->bindValue(":m_city", $_POST["m_city"]);
	$member->bindValue(":m_district", $_POST["m_district"]);
	$member->bindValue(":m_address", $_POST["m_address"]);
	$member->bindValue(":member_psw", $_POST["member_psw"]);

	$member->execute();

    $msg = "會員註冊成功";
}
catch (PDOException $e) {
	$msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
}
//輸出結果
$result = ["msg"=>$msg];
echo json_encode($result);
?>