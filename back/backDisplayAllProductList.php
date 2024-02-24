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
    $sql = "select * , ROUND(pro_price * promo_ratio) as pro_sale
	from product p
    join (select MIN(img_id) AS min_img_id, pro_id, img_name from pro_img group by pro_id) AS sub on p.pro_id = sub.pro_id
    join promo on promo.pro_category =  p.pro_category;";
    /*  全欄位包含 
    pro_id, pro_category, pro_name, pro_price, pro_intro, pro_info, launch_date, end_date, pro_state, pro_pin,
    min_img_id, pro_id, img_name,
    promo_id, promo_start_date, promo_end_date, promo_name, pro_category, promo_ratio, 
    pro_sale <- 這一個是自定義欄位，非真實儲存欄位
    */


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
