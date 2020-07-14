<?php

try
{

	require_once('common.php');

	$post = sanitize($_POST);
	$regist_name = $post['name'];
	$regist_pass = $post['pass'];

	$regist_pass = hash('sha256' , $regist_pass);

	$dsn = 'mysql:dbname=subcall;host=localhost;charset=utf8';
	$user = 'root';
	$password = 'kcsf';
	$dbh = new PDO($dsn,$user,$password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	$sql = 'SELECT name FROM account WHERE name=? AND password=?';
	$stmt = $dbh->prepare($sql);
	$data[] = $regist_name;
	$data[] = $regist_pass;
	$stmt->execute($data);

	$dbh = null;

	$rec = $stmt->fetch(PDO::FETCH_ASSOC);

	if($rec == false)
	{
		print 'ユーザ名かパスワードが間違っています。<br />' ;
		print '<a href="login.php">戻る</a>' ;
	}
	else
	{
		session_start();
		$_SESSION['login']=1;
		$_SESSION['staff_name']=$regist_name;
		$_SESSION['staff_name']=$rec['name'];
		header('Location: staff_top.php');
		exit();
	}

}
catch (Exception $e)
{
	print 'ただいま障害により大変ご迷惑をおかけしております。';
	exit();
}

?>
