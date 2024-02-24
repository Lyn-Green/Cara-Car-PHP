<?php
	//建立表單名稱,使用者名稱,密碼,port，建立$dsn去連線資料庫，建立options是表單設定,可用可不用，最後建立PDO物件 new PDO(驗證)


	// $dbname = "tibamefe_chd104g6";
	// $user = "tibamefe_since2021";
	// $password = "vwRBSb.j&K#E";
	// $dbname = "chd104g6";
	// $user = "root";
	// $password = "";
	// $port ="3306";
	// $dsn = "mysql:host=localhost;port={$port};dbname={$dbname};charset=utf8";;
	// $options = array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_CASE=>PDO::CASE_NATURAL);
	// //建立pdo物件
	// $pdo = new PDO($dsn, $user, $password, $options);

	$dbname = "chd104g6";
	$user = "dev";
	$password = "Chd104g6";
	$port ="3306";
	$host = "chd104g6.ch44i2mqiwrj.ap-southeast-2.rds.amazonaws.com";
	$dsn = "mysql:host={$host};port={$port};dbname={$dbname};charset=utf8";;
	$options = array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_CASE=>PDO::CASE_NATURAL);

	// //建立pdo物件
	$pdo = new PDO($dsn, $user, $password, $options);


	//表單options的設定

	//ATTR_ERRMODE定義：是 PDO（PHP Data Objects）中的一個屬性，用於設置PDO的錯誤模式。它決定了PDO在遇到錯誤時的行為方式。
	//======ATTR_ERRMODE : 3
	//ERRMODE_SILENT , 0  //在發生錯誤時，PDO不主動發出任何警告或錯誤，需要開發者手動檢查錯誤狀態。
	//ERRMODE_WARNING, 1  //在發生錯誤時，PDO發出警告，但不停止腳本執行。
	//ERRMODE_EXCEPTION 2  //在發生錯誤時，PDO拋出一個 PDOException 例外，腳本停止執行。

	//ATTR_CASE的定義：在PDO（PHP Data Objects）中用來指定結果集中的欄位名稱的大小寫形式的屬性。
	//======ATTR_CASE : 8
	//CASE_NATURAL：的行為是根據資料庫驅動程序的默認行為，即不對欄位名稱進行任何大小寫轉換。這個模式讓欄位名稱的大小寫由資料庫自己的配置或預設值來決定，而不是被強制轉換成大寫或小寫。
	//CASE_NATURAL ,0,  原欄位名稱 : memName  --> memName
	//CASE_UPPER：表示結果集中的欄位名稱將被轉換為大寫。
	//CASE_UPPER   ,1,  原欄位名稱 : memName  --> MEMNAME
	//CASE_LOWER：表示結果集中的欄位名稱將被轉換為小寫。
	//CASE_LOWER   ,2,  原欄位名稱 : memName  --> memname
	//
?>

