<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

try {
    require_once("../connectChd104g6.php");

    $sql = "SELECT 
        MAX(CASE WHEN look_up_key = 'line_channel_id' THEN look_up_value END) AS channelId,
        MAX(CASE WHEN look_up_key = 'line_channel_secret' THEN look_up_value END) AS channelSecret,
        MAX(CASE WHEN look_up_key = 'line_redirect_uri' THEN look_up_value END) AS redirectUri
        FROM look_up
        WHERE look_up_key IN ('line_channel_id', 'line_channel_secret', 'line_redirect_uri')";

    // 準備 SQL 查詢
    $data = $pdo->prepare($sql);

    // 執行 SQL 查詢
    $data->execute();

    // 檢查是否有資料
    if ($data->rowCount() > 0) {
        $data = $data->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($data);
    } else {
        echo json_encode(["errMsg" => ""]);
    }
} catch (PDOException $e) {
    echo json_encode(["errMsg" => "執行失敗: " . $e->getMessage()]);
}
