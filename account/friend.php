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
	$dsn = 'mysql:dbname=shop;host=localhost;charset=utf8';
	$user = 'root';
	$password = '';
	$dbh = new PDO($dsn,$user,$password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	$sql = 'SELECT FriendNumber FROM friendlist
		WHERE UserNumber = ? AND flag = false';
	$stmt = $dbh->prepare($sql);
	$data[] =
	$data[] =
	$data[] = 
	$stmt->execute($data);

	$dbh = null;

?>

</body>
</html>
