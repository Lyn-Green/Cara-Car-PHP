<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");

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
    $sql = "SELECT * FROM ord_list";  // 修改為您的 SQL 查詢

    // 準備 SQL 查詢
    $order = $pdo->prepare($sql);

    // 執行 SQL 查詢
    $order->execute();

    // 檢查是否有資料
    if ($order->rowCount() > 0) {
        $orderData = $order->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($orderData);
    } else {
        echo json_encode(["errMsg" => ""]);
    }
} catch (PDOException $e) {
    echo json_encode(["errMsg" => "執行失敗: " . $e->getMessage()]);
}
?>