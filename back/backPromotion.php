<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

try {
    require_once("../connectChd104g6.php");

    // SQL 查詢
    $sql = "SELECT * FROM promo";  // 修改為您的 SQL 查詢

    // 準備 SQL 查詢
    $promo = $pdo->prepare($sql);

    // 執行 SQL 查詢
    $promo->execute();

    // 檢查是否有資料
    if ($promo->rowCount() > 0) {
        $promoData = $promo->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($promoData);
    } else {
        echo json_encode(["errMsg" => ""]);
    }
} catch (PDOException $e) {
    echo json_encode(["errMsg" => "執行失敗: " . $e->getMessage()]);
}
?>
