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
    $sql = "select sh_pro_img.img_id, sh_pro_img.img_name 
    from sh_pro join sh_pro_img on sh_pro.sh_pro_id = sh_pro_img.sh_pro_id
    where sh_pro_img.sh_pro_id = {$pageId}";


    // 準備 SQL 查詢
    $sh_proImgs = $pdo->prepare($sql);

    // 執行 SQL 查詢
    $sh_proImgs->execute();

    // 檢查是否有資料
    if ($sh_proImgs->rowCount() > 0) {
        $sh_proImgsData = $sh_proImgs->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($sh_proImgsData);
    } else {
        echo json_encode(["errMsg" => ""]);
    }
} catch (PDOException $e) {
    echo json_encode(["errMsg" => "執行失敗: " . $e->getMessage()]);
}
?>
