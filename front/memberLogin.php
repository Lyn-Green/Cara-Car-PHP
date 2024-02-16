<?php 
/**
 * 前台會員登陸接口
 * $_SESSION 參考網站:https://ithelp.ithome.com.tw/articles/10207241
 * CORS 參考網站:https://blog.huli.tw/2021/02/19/cors-guide-3/
 * 
 * http://localhost/cgd103_g1/public/api/getConfirmMember.php?mem_account=charmy222@gmail.com&mem_psw=charmy222
 * http://localhost/cgd103_g1/public/api/getConfirmMember.php?mem_account=charmy333@gmail.com&mem_psw=charmy333
*/
ini_set("display_errors", "On");//php偵錯
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == '127.0.0.1') {
    // 開發環境
    require_once("../connectChd104g6.php");
} else {
    // 生產環境
    require_once("https://tibamef2e.com/chd104/g6/api/connectChd104g6.php");
}




$login_account = empty( $_GET["m_email"] ) ? ( $_POST["m_email"] ?? "" ) : $_GET["m_email"];
$login_psw = empty( $_GET["member_psw"] ) ? ( $_POST["member_psw"] ?? "" ) : $_GET["member_psw"];

if($login_account != "" && $login_psw != "") {
    $sql = " SELECT * FROM member WHERE m_email = '{$login_account}' OR member_psw = '{$login_psw}'";
    $result = $pdo->query($sql);
    $resArray = $result->fetch(PDO::FETCH_ASSOC);
    $mem_psw = $resArray["member_psw"]??"";
    if($mem_psw == $login_psw) {
        $nowTime = time();
        session_start();
        $_SESSION = $resArray;
        $result_array = ["code"=>"1", "msg"=>"登入成功",'memInfo'=>$_SESSION,'session_id'=>session_id()];
        echo json_encode($result_array);
    }
    else {
        $result_array = ["code"=>"0", "msg"=>"帳號或密碼錯誤"];
        echo json_encode($result_array);
    }
}

?>