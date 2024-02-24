<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

try {
    require_once("../connectChd104g6.php");

    // SQL 查詢
    $sql = "SELECT  *, member.member_id, sh_pro.sh_pro_id, sh_pro.sh_pro_name 
    FROM sh_ord
    JOIN member ON sh_ord.member_id = member.member_id
    JOIN sh_pro ON sh_ord.sh_pro_id = sh_pro.sh_pro_id";  // 修改為您的 SQL 查詢

    // 準備 SQL 查詢
    $shProducts = $pdo->prepare($sql);

    // 執行 SQL 查詢
    $shProducts->execute();

    // 檢查是否有資料
    if ($shProducts->rowCount() > 0) {
        $shProductsData = $shProducts->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($shProductsData);
    } else {
        echo json_encode(["errMsg" => "查無資料"]);
    }
} catch (PDOException $e) {
    echo json_encode(["errMsg" => "執行失敗: " . $e->getMessage()]);
}
?>
