<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json;charset=utf-8");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
try{
	    // 連線 MySQL
        if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1') {
            // 開發環境
            require_once("../connectChd104g6.php");
        } else {
            // 生產環境
            require_once("https://tibamef2e.com/chd104/g6/api/connectChd104g6.php");
        }


    // 接收從前端發送過來的資料
    $formData = json_decode(file_get_contents("php://input"), true);
	
    // SQL 指令
    $sql = "insert into sh_pro (sh_pro_name, sh_pro_en_name, sh_pro_year, sh_pro_price, sh_pro_intro, sh_pro_situation, sh_pro_state, launch_date, sh_pro_pin, sh_pro_info) values ( :sh_pro_name, :sh_pro_en_name, :sh_pro_year, :sh_pro_price, :sh_pro_intro, :sh_pro_situation, :sh_pro_state,  :launch_date, :sh_pro_pin, :sh_pro_info)";
    
	//編譯, 執行
    $shPro = $pdo->prepare($sql);

    // 綁定參數並執行

    $shPro->bindParam(":sh_pro_name", $formData['sh_pro_name']);
    $shPro->bindParam(":sh_pro_en_name", $formData['sh_pro_en_name']);
    $shPro->bindParam(":sh_pro_year", $formData['sh_pro_year']);
    $shPro->bindParam(":sh_pro_price", $formData['sh_pro_price']);
    $shPro->bindParam(":sh_pro_intro", $formData['sh_pro_intro']);
    $shPro->bindParam(":sh_pro_info", $formData['sh_pro_info']);
    $shPro->bindParam(":sh_pro_situation", $formData['sh_pro_situation']);
    $shPro->bindParam(":sh_pro_state", $formData['sh_pro_state']);
    $shPro->bindParam(":launch_date", $formData['launch_date']);
    $shPro->bindParam(":sh_pro_pin", $formData['sh_pro_pin']);

    $shPro->execute();

    $msg = "新增商品成功";
}
catch (PDOException $e) {
	$msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
}
//輸出結果
$result = ["msg"=>$msg];
echo json_encode($result);
?>