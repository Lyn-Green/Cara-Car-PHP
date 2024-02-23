<?php 
ini_set("display_errors", "On");//php偵錯
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

require_once("../connectChd104g6.php");

$login_account = empty( $_GET["m_email"] ) ? ( $_POST["m_email"] ?? "" ) : $_GET["m_email"];
$login_psw = empty( $_GET["member_psw"] ) ? ( $_POST["member_psw"] ?? "" ) : $_GET["member_psw"];

if($login_account != "" && $login_psw != "") {
    $sql = " SELECT * FROM member WHERE m_email = :login_account";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['login_account' => $login_account]);
    $resArray = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($resArray) {
        // 檢查密碼是否正確
        if($resArray["member_psw"] == $login_psw) {
            // 登入成功
            $nowTime = time();
            session_start();
            $_SESSION = $resArray;
            $result_array = ["code"=>"1", "msg"=>"登入成功", "memInfo"=>$_SESSION, "session_id"=>session_id()];
            echo json_encode($result_array);
        } else {
            // 密碼錯誤
            $result_array = ["code"=>"0", "msg"=>"密碼錯誤"];
            echo json_encode($result_array);
        }
    } else {
        // 帳號錯誤
        $result_array = ["code"=>"0", "msg"=>"帳號錯誤"];
        echo json_encode($result_array);
    }
}else {
    // 帳號或密碼為空
    $result_array = ["code"=>"0", "msg"=>"帳號或密碼欄位不得為空"];
    echo json_encode($result_array);
} 
?>