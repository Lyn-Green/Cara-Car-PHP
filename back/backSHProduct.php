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

    // $sql = "SELECT p.*, pi.img_name
    // FROM sh_pro AS p
    // LEFT JOIN (                                -----> 使用 LEFT JOIN 聯結 sh_pro_img 表，並將結果別名為 pi，以 sh_pro_id 作為關聯欄位。
    //     SELECT sh_pro_id, img_name 
    //     FROM sh_pro_img AS t1 
    //     WHERE img_id = (                       ----->在主查詢中使用了一個子查詢，目的是從 sh_pro_img 表中選擇每個商品的第一張圖片
    //         SELECT MIN(img_id)                 ----->限制 t1 的選擇，只選擇符合子查詢條件的資料
    //         FROM sh_pro_img AS t2              ----->用來找到每個商品的最小 img_id
    //         WHERE t1.sh_pro_id = t2.sh_pro_id
    //     )
    // ) AS pi ON p.sh_pro_id = pi.sh_pro_id
    // ORDER BY sh_pro_id;";

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
