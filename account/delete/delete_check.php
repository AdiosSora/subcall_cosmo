<!DOCTYPE html>
<html lang="ja">
<head>
<title>退会画面</title>
</head>
<body>

<?php
try
{
    require_once('../../common.php');

    $post = sanitize($_POST);

  	$name = $post['name'];
    $pass = $post['pass'];
    $address = $post['address'];

    $regist_pass = hash('sha256' , $pass);

  	$dsn = 'mysql:dbname=subcall;host=localhost;charset=utf8';
  	$user = 'root';
    $password = 'kcsf';
  	$dbh = new PDO($dsn,$user,$password);
  	$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  	$sql = 'SELECT name FROM account WHERE name=? AND pass=? AND mail_address=?';
  	$stmt = $dbh->prepare($sql);
  	$data[] = $name;
    $data[] = $regist_pass;
    $data[] = $address;
  	$stmt->execute($data);

  	$dbh = null;

    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

  	if($rec == true){
      print '本当に削除しますか？'.'<br>';
      print 'お名前：'.$name.'<br>';
      print 'メールアドレス：'.$address;
      print'<form method="post" action="./delete_done.php">';
    	print'<input type="hidden" name="name" value="'.$name.'">';
    	print'<input type="hidden" name="pass" value="'.$pass.'">';
    	print'<input type="submit" value="はい">';
    	print'</form>';
      print '<a href="../../index.php">いいえ</a>';
    }else{
      print 'パスワードが間違っています。'.'<br>';
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
