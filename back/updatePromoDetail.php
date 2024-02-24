<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
try{
    require_once("../connectChd104g6.php");


    // 接收從前端發送過來的資料
    $formData = json_decode(file_get_contents("php://input"), true);
	
    // SQL 指令
    $sql = "UPDATE promo SET 
    promo_name = :promo_name, 
    promo_ratio = :promo_ratio, 
    pro_category = :pro_category, 
    promo_state = :promo_state, 
    promo_start_date = :promo_start_date, 
    promo_end_date = :promo_end_date
    WHERE 
    promo_id = :promo_id";

	//編譯, 執行
    $stmt = $pdo->prepare($sql);

    // 綁定參數並執行, 要確保每一個對應的參數都有綁到, 否則就會報錯 
    // eg.錯誤訊息 : SQLSTATE[HY093]: Invalid parameter number: number of bound variables does not match number of tokens -> 報錯顯示這個就是有參數沒綁到
    
    $stmt->bindParam(":promo_id", $formData['promo_id']);
    $stmt->bindParam(":promo_name", $formData['promo_name']);
    $stmt->bindParam(":promo_ratio", $formData['promo_ratio']);
    $stmt->bindParam(":pro_category", $formData['pro_category']);
    $stmt->bindParam(":promo_state", $formData['promo_state']);
    $stmt->bindParam(":promo_start_date", $formData['promo_start_date']);
    $stmt->bindParam(":promo_end_date", $formData['promo_end_date']);

    $stmt->execute();

    $msg = "成功更新促銷方案！";
}
catch (PDOException $e) {
	$msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
}
//輸出結果
// $result = ["msg"=>$msg, "sql" => $sql, $formData['news_id']]; 可以用輸出結果來找是哪個欄位沒抓到正確的值
$result = ["msg"=>$msg];
echo json_encode($result);
?>


