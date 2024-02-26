<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

try {
    require_once("../connectChd104g6.php");
    // 取得本頁的id
    $pageId = $_GET['pageId'];

    // SQL 查詢
    $sql = "SELECT p_i.img_id, p_i.img_name 
    FROM product p JOIN pro_img p_i ON p.pro_id = p_i.pro_id
    WHERE p_i.pro_id = {$pageId}";

    // 準備 SQL 查詢
    $proImgs = $pdo->prepare($sql);

    // 執行 SQL 查詢
    $proImgs->execute();

    // 檢查是否有資料
    if ($proImgs->rowCount() > 0) {
        $proImgsData = $proImgs->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($proImgsData);
    } else {
        echo json_encode(["errMsg" => ""]);
    }
} catch (PDOException $e) {
    echo json_encode(["errMsg" => "執行失敗: " . $e->getMessage()]);
}
?>
