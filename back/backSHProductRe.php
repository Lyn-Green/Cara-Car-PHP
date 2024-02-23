<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

try {
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
    // SQL 
    $sql = "UPDATE sh_pro 
    SET 
        sh_pro_name = :sh_pro_name,
        sh_pro_en_name = :sh_pro_en_name,
        sh_pro_year = :sh_pro_year,
        sh_pro_price = :sh_pro_price,
        sh_pro_intro = :sh_pro_intro,
        sh_pro_info = :sh_pro_info,
        sh_pro_situation = :sh_pro_situation,
        sh_pro_state = :sh_pro_state,
        -- sh_pro_sold = :sh_pro_sold,
        launch_date = :launch_date,
        sh_pro_pin = :sh_pro_pin    
    WHERE 
        sh_pro_id = :sh_pro_id";  
        
        
        // 準備 SQL 更新
        $shPro = $pdo->prepare($sql);
        // //將資料放入並執行之
        // $sh_pro_intro = addslashes($formData["sh_pro_intro"]);
        // $sh_pro_info = addslashes($formData["sh_pro_info"]);
        $shPro->bindParam(":sh_pro_name",$formData['name']);
        $shPro->bindParam(":sh_pro_en_name",$formData['ename']);
        $shPro->bindParam(":sh_pro_year",$formData['year']);
        $shPro->bindParam(":sh_pro_price",$formData['price']);
        $shPro->bindParam(":sh_pro_intro", $formData['desc']);
        $shPro->bindParam(":sh_pro_info", $formData['descMore']);
        $shPro->bindParam(":sh_pro_situation",$formData['situation']);
        $shPro->bindParam(":sh_pro_state",$formData['sh_pro_state']);
        // $sh_pro->bindParam(":sh_pro_sold",$formData['sh_pro_sold']);
        $shPro->bindParam(":launch_date",$formData['date']);
        $sh_pro->bindParam(":sh_pro_pin",$formData['sh_pro_pin']);
        $shPro->bindParam(":sh_pro_id",$formData['SHProductsNo']);
        //$formData[""] 裡面放你要更改的資料庫表單的欄位
        $shPro->execute();
        $msg = "新增商品成功";
    } 
}
catch (PDOException $e) {
    //準備要回傳給前端的資料
    $msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
}
$result = ["msg"=>$msg];
echo json_encode($result);
?>
<!-- // 檢查是否有更新資料
//     if ($sh_pro->rowCount() > 0) {
    //         echo json_encode(["success" => true, "message" => "成功更新 sh_pro_state"]);
    //     } else {
        //         echo json_encode(["success" => false, "message" => "未能更新 sh_pro_state"]);
        //     }
        // } else {
            //     echo json_encode(["success" => false, "message" => "未接收到 sh_pro_state 值"]);
            // echo $sh_pro->rowCount(); -->
            

<!-- //準備sql指令    
// $sql = "insert into products (sh_pro_id, sh_pro_name, sh_pro_en_name, sh_pro_year, sh_pro_price, sh_pro_intro, sh_pro_situation, sh_pro_state, sh_pro_sold, launch_date, sh_pro_pin) values (:sh_pro_id, :sh_pro_name, :sh_pro_en_name, :sh_pro_year, :sh_pro_price, :sh_pro_intro, :sh_pro_situation, :sh_pro_state, :sh_pro_sold, :launch_date, :sh_pro_pin)"; -->