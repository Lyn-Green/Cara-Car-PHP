<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

try {

    require_once("../connectChd104g6.php");

    // SQL 查詢
    $sql = "SELECT * FROM news";

    // 用 ORDER BY 篩選會壞掉
    // $sql = "SELECT * FROM news
    //         ORDER BY news_state, news_id";

    // 準備 SQL 查詢
    $news = $pdo->prepare($sql);

    // 執行 SQL 查詢
    $news->execute();

    // 檢查是否有資料
    if ($news->rowCount() > 0) {
        $newsData = $news->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($newsData);
    } else {
        echo json_encode(["errMsg" => ""]);
    }
} catch (PDOException $e) {
    echo json_encode(["errMsg" => "執行失敗: " . $e->getMessage()]);
}
?>
