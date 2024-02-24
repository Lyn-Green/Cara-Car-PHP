<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
try{
    require_once("../connectChd104g6.php");

    // 接收從前端發送過來的資料
    $promoData = json_decode(file_get_contents("php://input"), true);
	
    // SQL 指令
	$sql = "INSERT INTO promo 
    (promo_name, promo_ratio, pro_category, promo_state, promo_start_date, promo_end_date) VALUES 
	(:promo_name, :promo_ratio, :pro_category, :promo_state, :promo_start_date, :promo_end_date);";
    
	//編譯, 執行
    $stmt = $pdo->prepare($sql);

    // 綁定參數並執行
    $stmt->bindParam(":promo_name", $promoData['promo_name']);
    $stmt->bindParam(":promo_ratio", $promoData['promo_ratio']);
    $stmt->bindParam(":pro_category", $promoData['pro_category']);
    $stmt->bindParam(":promo_state", $promoData['promo_state']);
    $stmt->bindParam(":promo_start_date", $promoData['promo_start_date']);
    $stmt->bindParam(":promo_end_date", $promoData['promo_end_date']);

    $stmt->execute();

    $msg = "新增促銷方案成功";

}
catch (PDOException $e) {
	$msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
}
//輸出結果
$result = ["msg"=>$msg];
echo json_encode($result);

?>