<?php
try
{
  session_start();
  $_SESSION=array();

  if(isset($_COOKIE[session_name()]) == true)
    {
    	setcookie(session_name(),'',time()-42000,'/');
    }
    session_destroy();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<title>退会完了</title>
</head>
<body>

<?php
    require_once('../common.php');

    $post = sanitize($_POST);

    $name = $post['name'];
    $pass = $post['pass'];

    $regist_pass = hash('sha256' , $pass);

  	$dsn = 'mysql:dbname=subcall;host=localhost;charset=utf8';
  	$user = 'root';
  	$password = 'kcsf';
  	$dbh = new PDO($dsn,$user,$password);
  	$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  	$sql = 'DELETE FROM account WHERE name=? AND pass=?';
  	$stmt = $dbh->prepare($sql);
  	$data[] = $name;
    $data[] = $regist_pass;
  	$stmt->execute($data);

  	$dbh = null;

    print $name.'　様の情報を削除しました。';

}
catch (Exception $e)
{
	print'ただいま障害により大変ご迷惑をお掛けしております。';
	exit();
}

?>

<br />
<a href="../index.php">戻る</a>

</body>
</html>
