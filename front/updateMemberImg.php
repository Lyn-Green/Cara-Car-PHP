<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

try {
        require_once("../connectChd104g6.php");
    $member_id = $_POST['member_id'];
    $img_path = $_FILES['img_path']["name"]?? '';
    move_uploaded_file($_FILES['img_path']['tmp_name'], "../imgs/memberImgs" .$_FILES['img_path']['name']);
        // SQL 更新
        $sql = "UPDATE member SET img_path = :img_path WHERE member_id = :member_id";

        // 準備 SQL 更新
        $updateMemberImg = $pdo->prepare($sql);
        $updateMemberImg->bindParam(':img_path', $img_path);
        $updateMemberImg->bindParam(':member_id', $member_id);
        // 執行 SQL 更新
        $updateMemberImg->execute();

        // 檢查是否有更新資料
        // if ($updateMemberImg->rowCount() > 0) {
        //     echo json_encode(["success" => true, "message" => "成功更新會員大頭貼"]);
        // } else {
        //     echo json_encode(["success" => false, "message" => "未能更新會員大頭貼"]);
        // }
    // } else {
        // echo json_encode(["success" => false, "message" => "未接收到圖片檔"]);
        $msg = "更新大頭貼成功！";
} catch (PDOException $e) {
    // echo json_encode(["success" => false, "errMsg" => "執行失敗: " . $e->getMessage()]);
    $msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
}
?>