<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['bool']) == false)
{
	print 'ゲストユーザーではこの機能は使えません';
	print '<a href="../index.php">top画面へ</a><br />';
	print '<br />';
}
else
{
	print 'ようこそ';
	print $_SESSION['regist_name'];
	print '様　';
	print '<br />';
	// ユーザー番号取得
	$user_num = $_SESSION['regist_number'];
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>フレンド機能</title>
</head>
<body>

<?php
	// フレンド申請
	$dsn = 'mysql:dbname=subcall;host=localhost;charset=utf8';
	$user = 'root';
	// XAMPP用のmysql
    $password = '';
	//$password = 'kcsf';
	$dbh = new PDO($dsn,$user,$password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	// フレンド申請の数を取得
	$sql = 'SELECT count(user_number) FROM friendlist WHERE user_number=? and flag=false';

	$stmt = $dbh->prepare($sql);
	$data[] = $user_num;
	$stmt->execute($data);

	$rec = $stmt->fetch(PDO::FETCH_ASSOC);

	$count_user = $rec['count(user_number)'];

	if($count_user >0){
		// フレンド申請があった場合
		print 'フレンド申請が';
		print $count_user;
		print ' 件あります。';
		print '<br />';
	}else{
		print 'フレンド申請はありません。';
		print '<br />';
	}

	// フレンド数
	// フレンドの数を取得
	$sql = 'SELECT count(user_number) FROM friendlist WHERE user_number=? and flag=true';

	$stmt = $dbh->prepare($sql);
	// $data[]は申請時の時と同じものを使用するため不要
	$stmt->execute($data);

	$dbh = null;

	$rec = $stmt->fetch(PDO::FETCH_ASSOC);

	$count_user = $rec['count(user_number)'];

	print 'フレンド数：　';
	print $count_user;
	print '　／　１０';
	print '</br>';

?>

<a href="../index.php">トップ画面へ</a>

</body>
</html>
