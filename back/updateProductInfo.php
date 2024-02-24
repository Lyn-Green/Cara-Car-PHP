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
    $sql = "UPDATE product SET 
        pro_name = :pro_name,
        pro_en_name = :pro_en_name,
        pro_category = :pro_category,
        pro_price = :pro_price,
        pro_intro = :pro_intro,
        pro_info = :pro_info,
        launch_date = :launch_date,
        end_date = :end_date,
        pro_state = :pro_state,
        pro_pin = :pro_pin,
    WHERE 
        pro_id = :pro_id";  
        
        
        // 準備 SQL 更新
        $Pro = $pdo->prepare($sql);
        // //將資料放入並執行之        
        //$formData[""] 裡面放你要更改的資料庫表單的欄位
        $Pro->bindParam(":pro_id",$formData['pro_id']);
        $Pro->bindParam(":pro_name",$formData['pro_name']);
        $Pro->bindParam(":pro_en_name",$formData['pro_en_name']);
        $Pro->bindParam(":pro_category",$formData['pro_category']);
        $Pro->bindParam(":pro_price",$formData['pro_price']);
        $Pro->bindParam(":pro_intro", $formData['pro_intro']);
        $Pro->bindParam(":pro_info", $formData['pro_info']);
        $Pro->bindParam(":launch_date",$formData['launch_date']);
        $Pro->bindParam(":end_date",$formData['end_date']);
        $Pro->bindParam(":pro_state",$formData['pro_state']);
        // 把pro_pin的true/false轉換成tinyint用的1/0
        $pro_pin = $formData['pro_pin'] ? 1 : 0;
        $Pro->bindParam(":pro_pin", $pro_pin);


        $Pro->execute();
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
