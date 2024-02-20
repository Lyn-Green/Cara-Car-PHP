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

    // SQL 查詢
    $sql = "select * from news ";

    // 準備 SQL 查詢
    $newsList = $pdo->prepare($sql);

    // 執行 SQL 查詢
    $newsList->execute();

    // 檢查是否有資料
    if ($newsList->rowCount() > 0) {
        $newsData = $newsList->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($newsData);
    } else {
        echo json_encode(["errMsg" => ""]);
    }
} catch (PDOException $e) {
    echo json_encode(["errMsg" => "執行失敗: " . $e->getMessage()]);
}
?>
