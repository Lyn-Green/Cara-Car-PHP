<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json;charset=utf-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
try{
	    // // 連線 MySQL
        // if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1') {
        //     // 開發環境
        //     require_once("../connectChd104g6.php");
        // } else {
        //     // 生產環境
        //     require_once("https://tibamef2e.com/chd104/g6/api/connectChd104g6.php");
        // }

        // 生產環境
        require_once("../connectChd104g6.php");



    // 接收從前端發送過來的資料
    // $formData = json_decode(file_get_contents("php://input"), true);
	
    // SQL 指令
    $sql = "UPDATE news SET 
    news_title = :news_title, 
    news_content = :news_content, 
    news_start_date = :news_start_date, 
    news_end_date = :news_end_date, 
    img_path = :img_path, 
    news_category = :news_category,
    news_state = :news_state
    WHERE 
    news_id = :news_id";

    // news_id = 1"; 
    // 若是有執行成功(出現 msg: "新增消息成功"),但沒有更新進資料庫, 先把id寫死, 看是不是沒抓到id
    

	//編譯, 執行
    $stmt = $pdo->prepare($sql);

    // 綁定參數並執行, 要確保每一個對應的參數都有綁到, 否則就會報錯 
    // eg.錯誤訊息 : SQLSTATE[HY093]: Invalid parameter number: number of bound variables does not match number of tokens -> 報錯顯示這個就是有參數沒綁到
    
    $stmt->bindParam(":news_id", $_POST['newsId']);
    $stmt->bindParam(":news_title", $_POST['eventTitle']);
    $stmt->bindParam(":news_content", $_POST['eventInformation']);
    $stmt->bindParam(":news_start_date", $_POST['startDate']);
    $stmt->bindParam(":news_end_date", $_POST['endDate']);
    $stmt->bindParam(":img_path", $_POST['eventImg']);
    $stmt->bindParam(":news_category", $_POST['classify']);
    $stmt->bindParam(":news_state", $_POST['eventState']);

    $stmt->execute();

    $msg = "新增消息成功";
}
catch (PDOException $e) {
	$msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
}
//輸出結果
// $result = ["msg"=>$msg, "sql" => $sql, $formData['news_id']]; 可以用輸出結果來找是哪個欄位沒抓到正確的值
$result = ["msg" => $msg, 
"eventState" => $_POST['eventState']
];
echo json_encode($result);
?>


