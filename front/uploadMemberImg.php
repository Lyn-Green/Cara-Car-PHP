<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

try {
    require_once("../connectChd104g6.php");

    $uploadedFile = $_FILES['file'];
    $memberId = $_POST['member_id'];
    $imgPath = $_POST['img_path'];

    // 指定前端資料夾路徑
    $frontendDirectory = 'C:/wamp64/www/g6/front/src/assets/imgs/memberImg/'; //本地端
    // $frontendDirectory = '../../imgs/memberImgs/'; //雲端

    // 指定文件保存路徑
    $targetPath = $frontendDirectory . $imgPath;

    // 檢查目標文件夾是否存在，如果不存在則創建
    if (!file_exists($frontendDirectory)) {
        mkdir($frontendDirectory, 0777, true);
    }

    // 檢查是否存在相同的文件名
    if (file_exists($targetPath)) {
        // 如果存在，刪除現有文件
        unlink($targetPath);
    }

    // 移動上傳的文件到指定路徑
    if (move_uploaded_file($uploadedFile['tmp_name'], $targetPath)) {
        $uploadMemberImgSql = "UPDATE member SET img_path = :imgPath WHERE member_id = :memberId";
        $uploadMemberImgStmt = $pdo->prepare($uploadMemberImgSql);
        $uploadMemberImgStmt->bindParam(':imgPath', $imgPath);
        $uploadMemberImgStmt->bindParam(':memberId', $memberId);
        $uploadMemberImgStmt->execute();

        echo json_encode(["msg" => "Y", "imgPath" => $imgPath]);
    }
} catch (PDOException $e) {
    echo json_encode(["errMsg" => "執行失敗: " . $e->getMessage()]);
}
