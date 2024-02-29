<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
try {
    require_once("../connectChd104g6.php");
    // order_list JOIN order_content JOIN member  指令
    // SQL 查詢
    // $sql = "SELECT * FROM ord_list";  // 修改為您的 SQL 查詢
    //多張表單join 查詢
    $sql = 
    "select L.ord_id, L.member_id, L.ord_date, L.ord_reciever, L.ord_city, L.ord_district, L.ord_address, L.ord_phone, L.remark, L.ord_ship, L.ord_sum, L.ord_total, L.ord_del_state, C.pro_id, C.pro_name, C.ord_qty, C.pro_price, C.promo_ratio, C.pro_sale, M.m_name 
    from ord_list L join ord_content C on L.ord_id = C.ord_id 
                    join member M on L.member_id = M.member_id order by L.ord_id asc";

    // 準備 SQL 查詢
    $order = $pdo->prepare($sql);

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
?>
