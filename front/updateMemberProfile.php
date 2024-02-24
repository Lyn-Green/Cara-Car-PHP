<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

try {
        require_once("../connectChd104g6.php");

    // 檢查是否有收到值
    if(isset($_POST['member_id'])) {
        // SQL 更新
        $sql = "UPDATE member SET 
                    m_name = :m_name,
                    m_phone = :m_phone,
                    m_birthday = :m_birthday,
                    m_email = :m_email,
                    m_city = :m_city,
                    m_district = :m_district,
                    m_address = :m_address
                WHERE member_id = :member_id";

        // 準備 SQL 更新
        $updateMemberProfile = $pdo->prepare($sql);
        $updateMemberProfile->bindValue(':m_name', $_POST["m_name"]);
        $updateMemberProfile->bindValue(':m_phone', $_POST["m_phone"]);
        $updateMemberProfile->bindValue(':m_birthday', $_POST["m_birthday"]);
        $updateMemberProfile->bindValue(':m_email', $_POST["m_email"]);
        $updateMemberProfile->bindValue(':m_city', $_POST["m_city"]);
        $updateMemberProfile->bindValue(':m_district', $_POST["m_district"]);
        $updateMemberProfile->bindValue(':m_address', $_POST["m_address"]);
        $updateMemberProfile->bindValue(':member_id', $_POST["member_id"]);
        // 執行 SQL 更新
        $updateMemberProfile->execute();

        // 檢查是否有更新資料
        if ($updateMemberProfile->rowCount() > 0) {
            echo json_encode(["success" => true, "message" => "成功更新會員資料"]);
        } else {
            echo json_encode(["success" => false, "message" => "未能更新會員資料"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "未接收到會員資料"]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "errMsg" => "執行失敗: " . $e->getMessage()]);
}
?>