<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
// $sh_proData = $_POST;


try {
    // 連線 MySQL
    // if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1') {
        // 開發環境
        require_once("../connectChd104g6.php");
    // } else {
    //     // 生產環境
    //     require_once("https://tibamef2e.com/chd104/g6/api/connectChd104g6.php");
    // }

    // SQL 查詢
    // $sql = "SELECT * FROM sh_pro";  // 修改為您的 SQL 查詢

 //準備sql指令    
    // $sql = "insert into products (sh_pro_id, sh_pro_name, sh_pro_en_name, sh_pro_year, sh_pro_price, sh_pro_intro, sh_pro_situation, sh_pro_state, sh_pro_sold, launch_date, sh_pro_pin) values (:sh_pro_id, :sh_pro_name, :sh_pro_en_name, :sh_pro_year, :sh_pro_price, :sh_pro_intro, :sh_pro_situation, :sh_pro_state, :sh_pro_sold, :launch_date, :sh_pro_pin)";
    
// 檢查是否有收到值
if(isset($_POST['sh_pro_id'])) {
    $sh_pro_id = $_POST['sh_pro_id']; // 假設接收到的是 0 或 1
    // SQL 更新
    $sql = "UPDATE sh_pro 
    SET 
        sh_pro_state = :sh_pro_state,
        sh_pro_name = :sh_pro_name,
        sh_pro_en_name = :sh_pro_en_name,
        -- sh_pro_year = :sh_pro_year,
        -- sh_pro_price = :sh_pro_price,
        -- sh_pro_intro = :sh_pro_intro,
        -- sh_pro_info = :sh_pro_info,
        -- sh_pro_situation = :sh_pro_situation,
        sh_pro_sold = :sh_pro_sold,
        launch_date = :launch_date,
        sh_pro_pin = :sh_pro_pin    
    WHERE sh_pro_id = :sh_pro_id";  
    //UPDATE sh_pro表單 SET sh_pro_state欄位 = :sh_pro_state(佔位) WHERE透過 sh_pro_id(管理員ID) = :sh_pro_id(佔位);
    // 準備 SQL 更新 用prepare就要用bindValue
    $sh_pro = $pdo->prepare($sql);
    // //將資料放入並執行之
    // $sh_pro_intro = addslashes($_POST["sh_pro_intro"]);
    // $sh_pro_info = addslashes($_POST["sh_pro_info"]);
    $sh_pro->bindValue(':sh_pro_state',$_POST["sh_pro_state"]);
    $sh_pro->bindValue(':sh_pro_name',$_POST["sh_pro_name"]);
    $sh_pro->bindValue(':sh_pro_en_name',$_POST["sh_pro_en_name"]);
    // $sh_pro->bindValue(':sh_pro_year',$_POST["sh_pro_year"]);
    // $sh_pro->bindValue(':sh_pro_price',$_POST["sh_pro_price"]);
    // $sh_pro->bindValue(':sh_pro_intro', $sh_pro_intro);
    // $sh_pro->bindValue(':sh_pro_info', $sh_pro_info);
    // $sh_pro->bindValue(':sh_pro_situation',$_POST["sh_pro_situation"]);
    $sh_pro->bindValue(':sh_pro_sold',$_POST["sh_pro_sold"]);
    $sh_pro->bindValue(':launch_date',$_POST["launch_date"]);
    $sh_pro->bindValue(':sh_pro_pin',$_POST["sh_pro_pin"]);
    $sh_pro->bindValue(':sh_pro_id',$_POST["sh_pro_id"]);
    //$_POST[""] 裡面放你要更改的資料庫表單的欄位
    // 執行 SQL 更新
    $sh_pro->execute();

    // 檢查是否有更新資料
    if ($sh_pro->rowCount() > 0) {
        echo json_encode(["success" => true, "message" => "成功更新 sh_pro_state"]);
    } else {
        echo json_encode(["success" => false, "message" => "未能更新 sh_pro_state"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "未接收到 sh_pro_state 值"]);
}
} catch (PDOException $e) {
	//準備要回傳給前端的資料
    $result = ["error" => true, "msg" => $e->getMessage()];
    echo json_encode($result);
}

?>
