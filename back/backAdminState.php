<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");

try {
    // 連線 MySQL
    if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1') {
        // 開發環境
        require_once("../connectChd104g6.php");
    } else {
        // 生產環境
        require_once("https://tibamef2e.com/chd104/g6/api/connectChd104g6.php");
    }

    // 檢查是否有收到值
    if(isset($_POST['admin_state'])) {
        $admin_state = $_POST['admin_state']; // 假設接收到的是 0 或 1

        // SQL 更新
        $sql = "UPDATE admin SET admin_state = :admin_state";  

        // 準備 SQL 更新
        $updateAdminState = $pdo->prepare($sql);

        // 執行 SQL 更新
        $updateAdminState->execute(array(':admin_state' => $admin_state));

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
