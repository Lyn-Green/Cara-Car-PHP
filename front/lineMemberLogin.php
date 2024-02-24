<?php
header("Access-Control-Allow-Origin: *"); // 允許所有來源
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

try {
    require_once("../connectChd104g6.php");

    $sub = $_POST['sub'];
    $picture = $_POST['picture'];
    $name = $_POST['name'];

    // SQL 查詢
    $hasMemberStmtSql = "SELECT * FROM `member` WHERE LINE_SUB = :sub";

    $hasMemberStmt = $pdo->prepare($hasMemberStmtSql);
    $hasMemberStmt->bindParam(':sub', $sub);

    $hasMemberStmt->execute();

    // 檢查是否有member
    if ($hasMemberStmt->rowCount() > 0) {
        // 回傳既有member資料
        $hasMemberStmt = $hasMemberStmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($hasMemberStmt);
    } else {
        // 新建一筆member
        $createMemberSql = "INSERT INTO member (m_name,member_psw,line_sub,img_path) VALUES 
        (:m_name,:member_psw,:line_sub,:img_path)";
        //編譯, 執行
        $createMember = $pdo->prepare($createMemberSql);

        $createMember->bindValue(":m_name", $name);
        $createMember->bindValue(":img_path", $picture);
        $createMember->bindValue(":line_sub", $sub);
        $createMember->bindValue(":member_psw", $sub);

        $createMember->execute();

        $hasMemberStmt->execute();

        $hasMemberStmt = $hasMemberStmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($hasMemberStmt);
    }
} catch (PDOException $e) {
    echo json_encode(["errMsg" => "執行失敗: " . $e->getMessage()]);
}
