<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// 引入數據庫連接文件
require_once("../connectChd104g6.php");
$news_id = $_POST['newsId'];
// 檢查請求方法是否為 POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 檢查是否接收到了圖片
    if (isset($_POST['newsId']) && isset($_FILES['image'])) { 
        // 處理每張圖片
        foreach ($_FILES['image']
        ['tmp_name'] as $key => $tmp_name) {
            // 獲取上傳的檔案名稱
            $uploadedFileName = $_FILES['image']['name'][$key];
            // 獲取檔名
            $fileName = pathinfo($uploadedFileName, PATHINFO_FILENAME);
            // 獲取副檔名
            $extension = pathinfo($uploadedFileName, PATHINFO_EXTENSION);
            // 定義pro_id
            $news_id = $_POST['newsId'];

            // ---------指定要存的圖片路徑---------------------
            // $targetDirectory = 'C:/Users/T14 Gen 3/Desktop/admin/src/assets/images/banner/';  //筆電
            $targetDirectory = '../../imgs/';  // 測試
            // ------------------------------------------------

            // 存進資料庫的檔案名稱 "banner"+檔名+副檔名
            $copyFile = $fileName . '.' . $extension;
            // 存進本地端
            $uploadedFile = $targetDirectory . $copyFile;

            //move_uploaded_file() 函式用於將上傳的檔案從暫存目錄移動到指定的目標目錄 
            //判斷檔案是否成功移動，成功移動則將圖檔名稱更新進資料庫
            if (move_uploaded_file($_FILES['image']['tmp_name'][$key], $uploadedFile)) {
                try {
                    // 將檔案名稱插入到資料庫中
                    $query = $pdo->prepare(
                        "INSERT INTO news (news_id, img_path) VALUES 
                        (:news_id ,:fileName)"
                    );
                    // 使用bindParam()防止 SQL 注入攻擊   可以不寫
                    $query->bindParam(':fileName', $copyFile);
                    $query->bindParam(':news_id', $news_id);
                    // 如果執行成功，execute()不會返回任何值 有錯誤發生會拋出一個 PDOException 
                    $query->execute();
                } catch (PDOException $e) {
                    // 如果插入失敗，返回錯誤的 JSON 響應
                    echo json_encode(['success' => false, 'message' => '資料庫插入失敗: ' . $e->getMessage()]);
                    exit; // 停止程式執行
                }
            } else {
                // 如果上傳檔案失敗，返回錯誤的 JSON 響應
                echo json_encode(['success' => false, 'message' => '文件上傳失敗']);
                exit; // 停止程式執行
            }
        }
        // 返回成功的 JSON 響應
        echo json_encode(['success' => true, 'message' => '圖片保存成功']);
    } else {
        // 如果缺少必要的資料，返回錯誤的 JSON 響應
        echo json_encode(['success' => false, 'message' => '缺少必要的資料']);
    }
} else {
    // 如果請求方法不是 POST，返回錯誤的 JSON 響應
    echo json_encode(['success' => false, 'message' => '非法請求']);
}
?>
