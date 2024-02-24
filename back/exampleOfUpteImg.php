<?php
// 設定 CORS 標頭，允許從任何來源進行跨域請求
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
// 引入數據庫連接文件
require_once("../../connect_chd104g3.php");
// 檢查請求方法是否為 POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 檢查是否接收到了標題和圖片檔案
    if (isset($_POST['title']) && isset($_FILES['image'])) { 
        // 獲取標題
        $title = $_POST['title'];
        // 獲取上傳的檔案名稱
        $uploadedFileName = $_FILES['image']['name'];
        // 獲取檔名
        $fileName = pathinfo($uploadedFileName, PATHINFO_FILENAME);
        // 獲取副檔名
        $extension = pathinfo($uploadedFileName, PATHINFO_EXTENSION);

// ---------指定要存的圖片路徑---------------------
        // $targetDirectory = 'C:/Users/T14 Gen 3/Desktop/admin/src/assets/images/banner/';  //筆電
        $targetDirectory = '../../admin/';  // 家裡
        // $targetDirectory = '../img/';  //佈署
// ------------------------------------------------

        // 存進資料庫的檔案名稱 "banner"+檔名+副檔名
        $copyFile =  "banner" . $fileName . '.' . $extension;
        // 存進本地端
        $uploadedFile = $targetDirectory . $copyFile;
        //move_uploaded_file() 函式用於將上傳的檔案從暫存目錄移動到指定的目標目錄
        //判斷檔案是否成功移動
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadedFile)) {
            try {
                // 將標題和檔案名稱插入到資料庫中
                $query = $pdo->prepare("INSERT INTO banner_carousel (banner_title, banner_image) VALUES (:title, :image)");
                // 使用bindParam()防止 SQL 注入攻擊   可以不寫
                $query->bindParam(':title', $title);
                $query->bindParam(':image', $copyFile);
                // 如果執行成功，execute()不會返回任何值 有錯誤發生會拋出一個 PDOException 
                $query->execute();
                // 返回成功的 JSON 響應 json_encode() 函式是內建函式，將 PHP 數組或物件轉換為 JSON 字串
                echo json_encode(['success' => true, 'message' => 'Banner保存成功']);
                // catch (PDOException $e) PDOException 是一個類，代表了一個與 PDO 相關的異常 $e 是一個變數，它用來捕獲 try 塊中拋出的異常（exception）
            } catch (PDOException $e) {
                // 如果插入失敗，返回錯誤的 JSON 響應
                echo json_encode(['success' => false, 'message' => '資料庫遭做失敗: ' . $e->getMessage()]);
            }
        } else {
            // 如果上傳檔案失敗，返回錯誤的 JSON 響應
            echo json_encode(['success' => false, 'message' => '文件上傳失敗']);
        }
    } else {
        // 如果缺少必要的資料，返回錯誤的 JSON 響應
        echo json_encode(['success' => false, 'message' => '缺少必要的資料']);
    }
} else {
    // 如果請求方法不是 POST，返回錯誤的 JSON 響應
    echo json_encode(['success' => false, 'message' => '非法請求']);
}
?>
