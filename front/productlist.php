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
    $sql = "select *
	from product p
    join (select MIN(img_id) AS min_img_id, pro_id, img_name from pro_img group by pro_id) AS sub on p.pro_id = sub.pro_id;";

    // 準備 SQL 查詢
    $productList = $pdo->prepare($sql);

    // 執行 SQL 查詢
    $productList->execute();

    // 檢查是否有資料
    if ($productList->rowCount() > 0) {
        $productsData = $productList->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($productsData);
    } else {
        echo json_encode(["errMsg" => ""]);
    }
} catch (PDOException $e) {
    echo json_encode(["errMsg" => "執行失敗: " . $e->getMessage()]);
}
?>
