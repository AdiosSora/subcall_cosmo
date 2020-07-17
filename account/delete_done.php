<!DOCTYPE html>
<html lang="ja">
<head>
<title>退会完了</title>
</head>
<body>

<?php

try
{

  require_once('../common.php');

  $post = sanitize($_POST);

  $name = $post['name'];
  $pass = $post['pass'];

	$dsn = 'mysql:dbname=subcall;host=localhost;charset=utf8';
	$user = 'root';
	$password = 'kcsf';
	$dbh = new PDO($dsn,$user,$password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	$sql = 'DELETE FROM account WHERE name=? AND pass=?';
	$stmt = $dbh->prepare($sql);
	$data[] = $name;
  $data[] = $pass;
	$stmt->execute($data);

	$dbh = null;

}
catch (Exception $e)
{
	print'ただいま障害により大変ご迷惑をお掛けしております。';
	exit();
}

?>

削除しました。<br />
<br />
<a href="../index.php">戻る</a>

</body>
</html>
