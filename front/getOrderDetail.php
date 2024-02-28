<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

    require_once("../connectChd104g6.php");

    $member_id = $_GET['member_id'];

    $sql ="SELECT OC.*, OL.member_id FROM ord_content OC 
            JOIN ord_list OL ON OL.ord_id = OC.ord_id
            WHERE OL.member_id = :member_id
            GROUP BY pro_id";
            

    // 準備 SQL 查詢
    $ordContent = $pdo->prepare($sql);
    $ordContent->bindParam(':member_id', $member_id, PDO::PARAM_INT);

    // 執行 SQL 查詢
    $ordContent->execute();

    // 檢查是否有資料
    if ($ordContent->rowCount() > 0) {
        $contentData = $ordContent->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($contentData);
    } else {
        echo json_encode(["errMsg" => ""]);
    }