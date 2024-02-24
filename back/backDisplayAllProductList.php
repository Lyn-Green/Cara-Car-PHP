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
    $sql = "SELECT * , ROUND(p.pro_price * pm.min_promo_ratio) AS pro_sale
	FROM product p
    JOIN (SELECT MIN(img_id) AS min_img_id, pro_id, img_name FROM pro_img GROUP BY pro_id) AS sub ON p.pro_id = sub.pro_id
    JOIN (SELECT MIN(promo_ratio) AS min_promo_ratio, pro_category, promo_name FROM promo) AS pm ON pm.pro_category =  p.pro_category;";

    // 準備 SQL 查詢
    $products = $pdo->prepare($sql);

    // 執行 SQL 查詢
    $products->execute();

    // 檢查是否有資料
    if ($products->rowCount() > 0) {
        $productsData = $products->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($productsData);
    } else {
        echo json_encode(["errMsg" => ""]);
    }
} catch (PDOException $e) {
    echo json_encode(["errMsg" => "執行失敗: " . $e->getMessage()]);
}
?>
