<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

try {
    require_once("../connectChd104g6.php");

    $uploadedFile = $_FILES['file'];
    $newsId = $_POST['news_id'];
    $imgPath = $_POST['img_path'];

    // 指定前端資料夾路徑
    // $frontendDirectory = 'C:/wamp64/www/g6/front/src/assets/imgs/event/'; //本地端

    $frontendDirectory = '../../imgs/event/'; //雲端

    // 指定文件保存路徑
    $targetPath = $frontendDirectory . $imgPath;

    // 檢查目標文件夾是否存在，如果不存在則創建。 0777為最大權限設定 / true則為Boolean欄位
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
        try{
            $uploadMemberImgStmt = $pdo->prepare("UPDATE news SET img_path = :img_path WHERE news_id = :news_id;");
            $uploadMemberImgStmt->bindParam(':img_path', $imgPath);
            $uploadMemberImgStmt->bindParam(':news_id', $newsId);
            $uploadMemberImgStmt->execute();
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => '資料庫插入失敗: ' . $e->getMessage()]);
            exit;
        }
        

        echo json_encode(["msg" => "Y", "imgPath" => $imgPath, "news_id" =>$newsId ]);
    }
} catch (PDOException $e) {
    echo json_encode(["errMsg" => "執行失敗: " . $e->getMessage()]);
}
?>
