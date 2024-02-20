<?php 
header("Access-Control-Allow-Origin: *"); // 允許所有來源(跨域)
header("Content-Type: application/json; charset=UTF-8"); //設置了HTTP響應的Content-Type標頭，告訴client端回傳的資料是JSON格式並使用UTF-8編碼
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");//允許來自其他來源的瀏覽器發送的POST、GET和OPTIONS請求。
header("Access-Control-Allow-Headers: Content-Type");//指定了伺服器允許的HTTP標頭，它告訴瀏覽器，伺服器允許的標頭只有Content-Type。

require_once("../connectChd104g6.php");

//首先，它嘗試從GET請求中獲取名為"admin_account"的參數值，如果這個參數不存在或者是空值，則判斷 $_GET["admin_account"] 的值將是空的。
//如果 $_GET["admin_account"] 是空的，那麼程式會進入 empty( $_GET["admin_account"] ) ? 的部分，即判斷 $_POST["admin_account"] 是否存在並且是否有值。
//如果 $_POST["admin_account"] 存在且有值，那麼程式會將其值賦予 $login_account 變數。
//如果 $_GET["admin_account"] 不是空的，則程式直接將其值賦予 $login_account 變數。
$login_account = empty( $_GET["admin_account"] ) ? ( $_POST["admin_account"] ?? "" ) : $_GET["admin_account"];
$login_psw = empty( $_GET["admin_psw"] ) ? ( $_POST["admin_psw"] ?? "" ) : $_GET["admin_psw"];

//如果account跟psw不等於空值開始執行以下指令
if($login_account != "" && $login_psw != "") {
    $sql = " SELECT * FROM admin WHERE admin_account = :login_account";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['login_account' => $login_account]);
    $resArray = $stmt->fetch(PDO::FETCH_ASSOC);
    //開始檢查及判斷帳號密碼邏輯
    if($resArray) {
        // 檢查密碼是否正確
        if($resArray["admin_psw"] == $login_psw) {
            // 登入成功
            $nowTime = time();
            session_start();
            $_SESSION = $resArray;
            $result_array = ["code"=>"1", "msg"=>"登入成功", "adminInfo"=>$_SESSION, "session_id"=>session_id()];
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
} else {
    // 帳號或密碼為空
    $result_array = ["code"=>"0", "msg"=>"帳號或密碼欄位不得為空"];
    echo json_encode($result_array);
} 
?>