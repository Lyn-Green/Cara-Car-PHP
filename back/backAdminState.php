<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

try {
    require_once("../connectChd104g6.php");

    // 檢查是否有收到值
    if(isset($_POST['admin_state'])) {
        $admin_state = $_POST['admin_state']; // 假設接收到的是 0 或 1
        // SQL 更新
        $sql = "UPDATE admin SET admin_state = :admin_state WHERE admin_id = :admin_id";  

        // 準備 SQL 更新
        $updateAdminState = $pdo->prepare($sql);
        $updateAdminState->bindValue(':admin_state',$_POST["admin_state"]);
        $updateAdminState->bindValue(':admin_id',$_POST["admin_id"]);
        // 執行 SQL 更新
        $updateAdminState->execute();

        // 檢查是否有更新資料
        if ($updateAdminState->rowCount() > 0) {
            echo json_encode(["success" => true, "message" => "成功更新 admin_state"]);
        } else {
            echo json_encode(["success" => false, "message" => "未能更新 admin_state"]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "未接收到 admin_state 值"]);
    }
} catch (PDOException $e) {
    echo json_encode(["success" => false, "errMsg" => "執行失敗: " . $e->getMessage()]);
}
?>
