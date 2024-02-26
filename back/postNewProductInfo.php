<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json;charset=utf-8");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

try {
  require_once("../connectChd104g6.php");

  // 檢查請求方法是否為 POST
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 接收從前端發送過來的資料
    $postdata = file_get_contents("php://input");
    $formData = json_decode($postdata, true);
    
    // SQL 
    $sql = "INSERT INTO product (pro_name, pro_en_name, pro_category, pro_price, pro_intro, pro_info, launch_date, end_date, pro_state, pro_pin) VALUES (
              :pro_name, 
              :pro_en_name, 
              :pro_category, 
              :pro_price, 
              :pro_intro, 
              :pro_info, 
              :launch_date, 
              :end_date, 
              :pro_state, 
              :pro_pin
            )";

    // 準備 SQL 語句
    $Pro = $pdo->prepare($sql);

    // 綁定參數並執行
    $Pro->bindParam(":pro_name", $formData['pro_name']);
    $Pro->bindParam(":pro_en_name", $formData['pro_en_name']);
    $Pro->bindParam(":pro_category", $formData['pro_category']);
    $Pro->bindParam(":pro_price", $formData['pro_price']);
    $Pro->bindParam(":pro_intro", $formData['pro_intro']);
    $Pro->bindParam(":pro_info", $formData['pro_info']);
    $Pro->bindParam(":launch_date", $formData['launch_date']);
    $Pro->bindParam(":end_date", $formData['end_date']);
    $Pro->bindParam(":pro_state", $formData['pro_state']);
    // 將 pro_pin 的 true/false 轉換成 tinyint 的 1/0
    $pro_pin = $formData['pro_pin'] ? 1 : 0;
    $Pro->bindParam(":pro_pin", $pro_pin);
    $msg = "";

    // 執行 SQL 語句
    if ($Pro->execute()) {
        // 若成功新增資料，取得最後插入的資料的主鍵
        $lastInsertedId = $pdo->lastInsertId();
        // 返回成功訊息和最後插入的資料的主鍵
        echo json_encode(array("message" => "新增商品成功", "pro_id" => $lastInsertedId));
    } else {
        // 若新增資料失敗，返回錯誤訊息
        echo json_encode(array("message" => "新增商品失敗"));
    }
  }
}catch (PDOException $e) {
  //準備要回傳給前端的資料
  $msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
}
?>
