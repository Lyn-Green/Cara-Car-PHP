<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

try {
    require_once("../connectChd104g6.php");

    // 檢查是否有收到值
    if(isset($_POST['m_state'])) {
        $m_state = $_POST['m_state']; // 假設接收到的是 0 或 1
        // SQL 更新
        $sql = "UPDATE member SET m_state = :m_state WHERE member_id = :member_id";  

        // 準備 SQL 更新
        $updateMemberState = $pdo->prepare($sql);
        $updateMemberState->bindValue(':m_state',$_POST["m_state"]);
        $updateMemberState->bindValue(':member_id',$_POST["member_id"]);
        // 執行 SQL 更新
        $updateMemberState->execute();

        // 檢查是否有更新資料
        if ($updateMemberState->rowCount() > 0) {
            echo json_encode(["success" => true, "message" => "成功更新 m_state"]);
        } else {
            echo json_encode(["success" => false, "message" => "未能更新 m_state"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "未接收到 m_state 值"]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "errMsg" => "執行失敗: " . $e->getMessage()]);
}
?>
