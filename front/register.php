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


	
	// $sql = "insert into tibamefe_cgd103g1.member('mem_name', 'mem_acoount', 'mem_psw') values (:mem_name, :mem_account, :mem_psw)";
	$sql = "INSERT INTO member (m_name, m_birthday, m_email, m_phone, m_address, member_psw) VALUES 
	(:m_name, :m_birthday, :m_email, :m_phone, :m_address, :member_psw);";
	//編譯, 執行
	$member = $pdo->prepare($sql);	

	$member->bindValue(":m_name", $_POST["m_name"]);
	$member->bindValue(":m_birthday", $_POST["m_birthday"]);
	$member->bindValue(":m_email", $_POST["m_email"]);
	$member->bindValue(":m_phone", $_POST["m_phone"]);
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