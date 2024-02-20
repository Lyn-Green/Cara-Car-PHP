<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

try {
    // 連線 MySQL
    if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1') {
        // 開發環境
        require_once("../connectChd104g6.php");
    } else {
        // 生產環境
        require_once("https://tibamef2e.com/chd104/g6/api/connectChd104g6.php");
    }
    
    $thisMem_id = $_GET['member_id']; //先定義登入者的id是多少
    // 編寫好 SQL 查詢
    $sql = "SELECT * FROM member WHERE member_id = :member_id";  // :member_id在下方定義(20行)
    // 準備 SQL 查詢
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':member_id', $thisMem_id, PDO::PARAM_INT); //安全性的需求準備使用PDO的方法bindParam(佔位符)準備給$thisMem_id
    // 執行 SQL 查詢
    $stmt->execute();

    // 檢查是否有資料
    if ($stmt->rowCount() > 0) {
        $memberData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($memberData);
    } else {
        echo json_encode(["errMsg" => "發生錯誤囉"]);
    }
} catch (PDOException $e) {
    echo json_encode(["errMsg" => "執行失敗: " . $e->getMessage()]);
}
?>
