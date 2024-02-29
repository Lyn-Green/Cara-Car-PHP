<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

try {
    require_once("../connectChd104g6.php");

    // SQL 查詢
    $sql =  "SELECT P.*,
                pi.img_name
                    FROM sh_pro P
                    LEFT JOIN (
                        SELECT sh_pro_id, img_name 
                        FROM sh_pro_img AS t1 
                        WHERE img_id = (
                            SELECT MIN(img_id) 
                            FROM sh_pro_img AS t2 
                            WHERE t1.sh_pro_id = t2.sh_pro_id
                        )
                    ) AS pi ON P.sh_pro_id = pi.sh_pro_id
                    WHERE P.sh_pro_state = 1;";

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