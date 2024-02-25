<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

try {
    require_once("../connectChd104g6.php");

    // SQL 查詢
    $sql =  $sql = "select *
	from sh_pro
    join (select MIN(img_id) AS min_img_id, sh_pro_id, img_name from sh_pro_img group by sh_pro_id) AS sub on sh_pro.sh_pro_id = sub.sh_pro_id;";

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