<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
try {
    require_once("../connectChd104g6.php");

    $thismemberId = $_GET['member_id'];
    $sql =
            "SELECT L.* FROM ord_list L
            JOIN (SELECT * FROM ord_content WHERE ord_id IS NOT NULL) AS OC ON L.ord_id = OC.ord_id
            JOIN member M ON L.member_id = M.member_id 
            WHERE L.member_id = :member_id
            GROUP BY L.ord_id";
    // 準備 SQL 查詢
    $order = $pdo->prepare($sql);
    $order->bindParam(':member_id', $thismemberId, PDO::PARAM_INT);
    // 執行 SQL 查詢
    $order->execute();

    // 檢查是否有資料
    if ($order->rowCount() > 0) {
        $orderData = $order->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($orderData);
    } else {
        echo json_encode(["errMsg" => ""]);
    }
} catch (PDOException $e) {
    echo json_encode(["errMsg" => "執行失敗: " . $e->getMessage()]);
}
