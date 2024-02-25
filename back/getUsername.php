<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

try {
    require_once("../connectChd104g6.php");
    
    $thisAdmin_id = $_GET['admin_id']; //先定義登入者的id是多少
    // 編寫好 SQL 查詢
    $sql = "SELECT * FROM admin WHERE admin_id = :admin_id";  // :admin_id在下方定義(20行)
    // 準備 SQL 查詢
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':admin_id', $thisAdmin_id, PDO::PARAM_INT); //安全性的需求準備使用PDO的方法bindParam(佔位符)準備給$thisAdmin_id
    // 執行 SQL 查詢
    $stmt->execute();

    // 檢查是否有資料
    if ($stmt->rowCount() > 0) {
        $adminData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($adminData);
    } else {
        echo json_encode(["errMsg" => "發生錯誤囉"]);
    }
} catch (PDOException $e) {
    echo json_encode(["errMsg" => "執行失敗: " . $e->getMessage()]);
}
?>
