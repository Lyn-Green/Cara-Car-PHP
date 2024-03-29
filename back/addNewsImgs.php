<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

try {
    require_once("../connectChd104g6.php");

    // $newsId = $_POST['news_id'];
    $uploadedFile = $_FILES['file'];
    $imgPath = $_POST['img_path'];

    // 指定前端資料夾路徑
    // $frontendDirectory = 'C:/wamp64/www/g6/imgs/event/'; //本地端
    $frontendDirectory = '../../imgs/event/'; //雲端

    // 指定文件保存路徑
    $targetPath = $frontendDirectory . $imgPath;

    // 動態生成文件名
    // $imgPath = 'news_img_' . $newsId . '.jpg';

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
    // if (move_uploaded_file($uploadedFile['tmp_name'], $targetPath)) {
    //     $uploadNewsImgSql = "UPDATE news SET img_path = :img_path WHERE news_id = :news_id";
    //     $uploadNewsImgStmt = $pdo->prepare($uploadNewsImgSql);
    //     $uploadNewsImgStmt->bindParam(':img_path', $imgPath);
    //     $uploadNewsImgStmt->bindParam(':news_id', $newsId);
    //     $uploadNewsImgStmt->execute();

    //     echo json_encode(["msg" => "Y", "imgPath" => $imgPath]);
    // }else {
    //     echo json_encode(['success' => false, 'message' => '文件上傳失敗']);
    // }
    if (move_uploaded_file($uploadedFile['tmp_name'], $targetPath)) {
        // 返回成功信息
        echo json_encode(["msg" => "Y", "imgPath" => $imgPath]);
    } else {
        // 返回失敗信息
        echo json_encode(['success' => false, 'message' => '文件上傳失敗']);
    }
} catch (PDOException $e) {
    echo json_encode(["errMsg" => "執行失敗: " . $e->getMessage()]);
}
