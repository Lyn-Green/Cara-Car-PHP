<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
// header("Content-Type: multipart/form-data");
header("Content-Type:application/json;charset=utf-8");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
// header("Access-Control-Allow-Methods: POST");

try {
    require_once("../connectChd104g6.php");

    // 接收從前端發送過來的資料
    $formData = json_decode(file_get_contents("php://input"), true);
    // SQL 
    $sql = "UPDATE sh_pro SET 
        sh_pro_name = :sh_pro_name,
        sh_pro_en_name = :sh_pro_en_name,
        sh_pro_year = :sh_pro_year,
        sh_pro_price = :sh_pro_price,
        sh_pro_intro = :sh_pro_intro,
        sh_pro_info = :sh_pro_info,
        sh_pro_situation = :sh_pro_situation,
        sh_pro_state = :sh_pro_state,
        sh_pro_sold = :sh_pro_sold,
        sh_pro_pin = :sh_pro_pin,    
        launch_date = :launch_date
    WHERE 
        sh_pro_id = :sh_pro_id";  
        
        
        // 準備 SQL 更新
        $shPro = $pdo->prepare($sql);
        // //將資料放入並執行之
        $shPro->bindParam(":sh_pro_id",$formData['sh_pro_id']);
        $shPro->bindParam(":sh_pro_name",$formData['sh_pro_name']);
        $shPro->bindParam(":sh_pro_en_name",$formData['sh_pro_en_name']);
        $shPro->bindParam(":sh_pro_year",$formData['sh_pro_year']);
        $shPro->bindParam(":sh_pro_price",$formData['sh_pro_price']);
        $shPro->bindParam(":sh_pro_intro", $formData['sh_pro_intro']);
        $shPro->bindParam(":sh_pro_info", $formData['sh_pro_info']);
        $shPro->bindParam(":sh_pro_situation",$formData['sh_pro_situation']);
        $shPro->bindParam(":sh_pro_state",$formData['sh_pro_state']);
        $shPro->bindParam(":sh_pro_sold",$formData['sh_pro_sold']);
        $shPro->bindParam(":sh_pro_pin",$formData['sh_pro_pin']);
        $shPro->bindParam(":launch_date",$formData['launch_date']);
        //$formData[""] 裡面放你要更改的資料庫表單的欄位
        $shPro->execute();
        $msg = "修改商品成功";
        // $msg = ["error" => false,"訊息:"=>"修改商品成功"];
    
}
catch (PDOException $e) {
    //準備要回傳給前端的資料
    $msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
}
$result = ["msg"=>$msg];
echo json_encode($result);
?>
