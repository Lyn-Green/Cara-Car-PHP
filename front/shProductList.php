<?php
//header("Access-Control-Allow-Origin: *"); // 允許跨域請求，即允許從任何來源訪問該 API
//header("Content-Type: application/json; charset=UTF-8"); //指示請求的回應內容類型為 JSON 格式

header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$host = 'localhost';
$dbname = 'chd104g6';
$username = 'root';
$password = '';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

// 目的: 從資料庫中擷取資料並將其轉換為 JSON 格式，返回給客戶端，以供前端使用
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");
    exit; // 結束程式執行
}
try {
    require_once("../connectChd104g6.php");

    // SQL 查詢
    $sql =  $sql = "select *
	from sh_pro
    join (select MIN(img_id) AS min_img_id, sh_pro_id, img_name from sh_pro_img group by sh_pro_id) AS sub on sh_pro.sh_pro_id = sub.sh_pro_id;";

    $shProduct = $pdo->prepare($sql);

    // 執行 SQL 查詢
    $shProduct->execute();

    // 檢查是否有資料
    if ($shProduct->rowCount() > 0) {
        $shProductData = $shProduct->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($shProductData);
    } else {
        echo json_encode(["errMsg" => ""]);
    }
} catch (PDOException $e) {
    echo json_encode(["errMsg" => "執行失敗: " . $e->getMessage()]);
}

?>
