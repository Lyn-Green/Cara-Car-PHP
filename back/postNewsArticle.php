<?php
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json;charset=utf-8");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
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
    $formData = json_decode(file_get_contents("php://input"), true);
	
    // SQL 指令
	$sql = "INSERT INTO news (news_title, news_content, news_start_date, news_end_date, img_path, news_category, news_state) VALUES 
	(:news_title, :news_content, :news_start_date, :news_end_date, :img_path, :news_category, :news_state);";
    
	//編譯, 執行
    $stmt = $pdo->prepare($sql);

    // 綁定參數並執行
    $stmt->bindParam(":news_title", $formData['eventTitle']);
    $stmt->bindParam(":news_content", $formData['eventInformation']);
    $stmt->bindParam(":news_start_date", $formData['startDate']);
    $stmt->bindParam(":news_end_date", $formData['endDate']);
    $stmt->bindParam(":img_path", $formData['eventImg']);
    $stmt->bindParam(":news_category", $formData['classify']);
    $stmt->bindParam(":news_state", $formData['eventState']);

    $stmt->execute();

    $msg = "新增消息成功";


     // 檢查是否有資料
    // if ($stmt->rowCount() > 0) {
    //     $newsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     echo json_encode($newsData);
    // } else {
    //     echo json_encode(["errMsg" => ""]);
    // }
    
    // $result = ["msg"=>$msg];
    // echo json_encode($result);
}
catch (PDOException $e) {
	$msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
//     $result = ["msg"=>$msg];
// echo json_encode($result);
}
//輸出結果
$result = ["msg"=>$msg];
echo json_encode($result);
?>