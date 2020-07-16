<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>アカウント登録完了</title>
</head>
<body>

<?php

try
{
	require_once('../common.php');

	$post = sanitize($_POST);
	$regist_address = $post['address'];
	$regist_name = $post['name'];
	$regist_pass = $post['pass'];

	$dsn = 'mysql:dbname=subcall;host=localhost;charset=utf8';
	$user = 'root';
	$password = 'kcsf';
	$dbh = new PDO($dsn,$user,$password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	$data[] = $regist_address;
	$data[] = $regist_name;
	$data[] = $regist_pass;
	$sql = 'INSERT INTO account(mail_address,name,pass) VALUES (?,?,?)';
	$stmt = $dbh->prepare($sql);
	$stmt->execute($data);

	$dbh = null;

	print 'アカウントの登録が完了しました。 <br />';

}
catch (Exception $e)
{
	print$regist_address;
	print$regist_name;
	print$regist_pass;
	print$e;
	print'ただいま障害により大変ご迷惑をお掛けしております。';
	exit();
}


?>

<a href="../index.php">戻る</a>

</body>
</html>
