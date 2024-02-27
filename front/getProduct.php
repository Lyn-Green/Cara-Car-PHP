<?php
session_start();
header("Access-Control-Allow-Origin:*");
header("Content-Type:application/json;charset=utf-8");
// $cart = file_get_contents("php://input");
// $data = json_decode($cart, true);
$cartArrayJSON = $_POST["cartArray"];
$cartArray = json_decode($cartArrayJSON, true);

// require_once("shared_ord_id.php");

try{
	    // 連線 MySQL
        if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1') {
            // 開發環境
            require_once("../connectChd104g6.php");
        } else {
            // 生產環境
            require_once("https://tibamef2e.com/chd104/g6/api/connectChd104g6.php");
        }

	// echo json_encode($_POST["cart"]);
	
	// $cartItems = json_decode($jsonString);

	// echo $cartItems;


	// $memId = $_GET["member_id"];

	
	foreach($cartArray as $item){

		$sql = "INSERT INTO ord_content (ord_id,pro_id, pro_name, ord_qty, pro_price, promo_ratio, pro_sale, ord_sum) VALUES 
		(:ord_id,:pro_id, :pro_name, :ord_qty, :pro_price, :promo_ratio, :pro_sale, :ord_sum);";
		//編譯, 執行
		$order = $pdo->prepare($sql);	

		// $ordId = $_SESSION['ordId'];
		// $ordId = getOrdId();
		
		// $order->bindParam(":ord_id", $ordId);
		$order->bindParam(":ord_id", $item["ord_id"]);
		$order->bindParam(":pro_id", $item["pro_id"]);
		$order->bindParam(":pro_name", $item["pro_name"]);
		$order->bindParam(":ord_qty", $item["ord_qty"]);
		$order->bindParam(":pro_price", $item["pro_price"]);
		$order->bindParam(":promo_ratio", $item["promo_ratio"]);
		$order->bindParam(":pro_sale", $item["pro_sale"]);
		$order->bindParam(":ord_sum", $item["ord_sum"]);
		$order->execute();


	}
	// $order->bindValue(":pro_id", $_POST["pro_id"]);
	// $order->bindValue(":pro_name", $_POST["pro_name"]);
	// $order->bindValue(":ord_qty", $_POST["ord_qty"]);
	// $order->bindValue(":pro_price", $_POST["pro_price"]);
	// $order->bindValue(":promo_ratio", $_POST["promo_ratio"]);
	// $order->bindValue(":pro_sale", $_POST["pro_sale"]);
    // $order->bindValue(":ord_sum", $_POST["ord_sum"]);

	// $order->execute();
	// $pdo->commit();
    $msg = "已抓取商品資訊";
}
catch (PDOException $e) {
	$msg = "錯誤行號 : ".$e->getLine().", 錯誤訊息 : ".$e->getMessage();
}
//輸出結果
$result = ["msg"=>$msg];
echo json_encode($result);
?>