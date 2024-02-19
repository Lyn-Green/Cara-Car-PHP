<?php
header("Access-Control-Allow-Origin: *"); // 允許跨域請求，即允許從任何來源訪問該 API
header("Content-Type: application/json; charset=UTF-8"); //指示請求的回應內容類型為 JSON 格式

// 目的: 從資料庫中擷取資料並將其轉換為 JSON 格式，返回給客戶端，以供前端使用

try {
    // 連線 MySQL
    if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1') {
        // 開發環境
        require_once("./connectChd104g6.php");
    } else {
        // 生產環境
        require_once("https://tibamef2e.com/chd104/g6/api/connectChd104g6.php");
    }

    // SQL 查詢
    $sql = "SELECT * FROM sh_pro";  // 修改為您的 SQL 查詢

    // 準備 SQL 查詢 ($shOder、$shOderData(通常為***Data)為自訂義名稱)
    $shProduct = $pdo->prepare($sql);

    // 執行 SQL 查詢
    $shProduct->execute();

    // 檢查是否有資料
    if ($shProduct->rowCount() > 0) {
        $shProductData = $shProduct->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($shProductData);
    } else {
        echo json_encode(["errMsg" => ""]);
    }
} catch (PDOException $e) {
    echo json_encode(["errMsg" => "執行失敗: " . $e->getMessage()]);
}
?>