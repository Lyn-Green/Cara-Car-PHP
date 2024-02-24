<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

try {
    require_once("../connectChd104g6.php");

    // SQL 查詢
    $sql = "SELECT * FROM member";  // 修改為您的 SQL 查詢

    // 準備 SQL 查詢
    $member = $pdo->prepare($sql);

    // 執行 SQL 查詢
    $member->execute();

    // 檢查是否有資料
    if ($member->rowCount() > 0) {
        $memData = $member->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($memData);
    } else {
        echo json_encode(["errMsg" => ""]);
    }
} catch (PDOException $e) {
    echo json_encode(["errMsg" => "執行失敗: " . $e->getMessage()]);
}
?>
