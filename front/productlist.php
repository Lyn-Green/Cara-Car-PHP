<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

try {
    require_once("../connectChd104g6.php");

    // SQL 查詢
    $sql = "SELECT p.*,
            pi.img_name ,
            ROUND(p.pro_price * COALESCE(pm.min_promo_ratio, 1)) AS pro_sale,
            pm.promo_state,
            pm.promo_name
	FROM product p
    LEFT JOIN (
        SELECT pro_id, img_name 
                FROM pro_img AS t1 
                WHERE img_id = (
                    SELECT MIN(img_id) 
                    FROM pro_img AS t2 
                    WHERE t1.pro_id = t2.pro_id
                )
            ) AS pi ON p.pro_id = pi.pro_id
    LEFT JOIN (
        SELECT MIN(promo_ratio) AS min_promo_ratio, pro_category , promo_name, promo_state 
        FROM promo 
        WHERE promo_state = 1
        GROUP BY pro_category
    ) AS pm ON pm.pro_category = p.pro_category
    WHERE p.pro_state = 0
    ORDER BY p.pro_pin DESC, p.pro_id ASC;";

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
