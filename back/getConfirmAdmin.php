<?php 
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");

require_once("../connectChd104g6.php");

$login_account = empty( $_GET["admin_account"] ) ? ( $_POST["admin_account"] ?? "" ) : $_GET["admin_account"];
$login_psw = empty( $_GET["admin_psw"] ) ? ( $_POST["admin_psw"] ?? "" ) : $_GET["admin_psw"];

if($login_account != "" && $login_psw != "") {
    $sql = " SELECT * FROM admin WHERE admin_account = '{$login_account}' OR admin_psw = '{$login_psw}'; ";
    $result = $pdo->query($sql);
    $resArray = $result->fetch(PDO::FETCH_ASSOC);
    $admin_psw = $resArray["admin_psw"]??"";

    if($admin_psw == $login_psw) {
        $nowTime = time();
        session_start();
        $_SESSION = $resArray;
        $result_array = ["code"=>"1", "msg"=>"登入成功",'memInfo'=>$_SESSION,'session_id'=>session_id()];
        echo json_encode($result_array);
    }else {
        $result_array = ["code"=>"0", "msg"=>"帳號或密碼錯誤"];
        echo json_encode($result_array);
    }
}else {
    $result_array = ["code"=>"0", "msg"=>"帳號或密碼錯誤"];
    echo json_encode($result_array);
}    
?>