<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

try {
    require_once("../connectChd104g6.php");

    // SQL 查詢"SELECT * FROM sh_pro ORDER BY sh_pro_id";
    $sql = "SELECT p.*, pi.img_name
    FROM sh_pro AS p
    LEFT JOIN (
        SELECT sh_pro_id, img_name 
        FROM sh_pro_img AS t1 
        WHERE img_id = (
            SELECT MIN(img_id) 
            FROM sh_pro_img AS t2 
            WHERE t1.sh_pro_id = t2.sh_pro_id
        )
    ) AS pi ON p.sh_pro_id = pi.sh_pro_id
    ORDER BY sh_pro_id;";

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
    //準備要回傳給前端的資料
    echo json_encode(["errMsg" => "執行失敗: " . $e->getMessage()]);
}
?>
