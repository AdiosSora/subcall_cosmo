<!DOCTYPE html>
<html lang="ja">
<head>
<title>退会画面</title>
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

	$sql = 'SELECT name, mail_address FROM account WHERE name=? AND pass=?';
	$stmt = $dbh->prepare($sql);
	$data[] = $name;
  $data[] = $pass;
	$stmt->execute($data);

	$dbh = null;

  $rec = $stmt->fetch(PDO::FETCH_ASSOC);

	if($rec == true){
    foreach ($rec as $value) {
      print $value.'<br>';
    }
    print '本当に削除しますか？'.'<br>';
    print'<form method="post" action="delete_done.php">';
  	print'<input type="hidden" name="name" value="'.$name.'">';
  	print'<input type="hidden" name="pass" value="'.$pass.'">';
  	print'<br />';
  	print'<input type="submit" value="はい">';
  	print'</form>';
    print '<a href="../index.php">いいえ</a>';
  }else{
    print '名前かパスワードが間違っています。'.'<br>';
    print '<a href="./delete.php">戻る</a>';
  }

}
catch (Exception $e)
{
	print'ただいま障害により大変ご迷惑をお掛けしております。';
	exit();
}

?>

</body>
</html>
