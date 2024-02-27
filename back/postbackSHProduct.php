<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json;charset=utf-8");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
try{
    require_once("../connectChd104g6.php");


    // 接收從前端發送過來的資料
    $formData = json_decode(file_get_contents("php://input"), true);
	
    // SQL 指令
    $sql = "INSERT INTO sh_pro (sh_pro_name, sh_pro_en_name, sh_pro_year, sh_pro_price, sh_pro_intro, sh_pro_situation, sh_pro_state, launch_date, sh_pro_pin, sh_pro_info, sh_pro_sold) values ( :sh_pro_name, :sh_pro_en_name, :sh_pro_year, :sh_pro_price, :sh_pro_intro, :sh_pro_situation, :sh_pro_state,  :launch_date, :sh_pro_pin, :sh_pro_info, :sh_pro_sold)";
    
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
    $shPro->bindParam(":sh_pro_sold",$formData['sh_pro_sold']);
    $shPro->bindParam(":sh_pro_pin", $formData['sh_pro_pin']);
    $shPro->bindParam(":launch_date", $formData['launch_date']);



    if($shPro->execute()) {
        // 若成功新增資料，取得最後插入的資料的主鍵
        $lastInsertedId = $pdo->lastInsertId();
        // 返回成功訊息和最後插入的資料的主鍵
        echo json_encode(array("message" => "新增商品成功", "sh_pro_id" => $lastInsertedId));
    } else {
        // 若新增資料失敗，返回錯誤訊息
        echo json_encode(array("message" => "新增商品失敗"));
    }
}
catch (PDOException $e) {
	$msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
}

?>