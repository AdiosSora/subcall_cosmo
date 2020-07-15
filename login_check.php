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

	$sql = 'SELECT name FROM account WHERE name=? AND pass=?';
	$stmt = $dbh->prepare($sql);
	$data[] = $regist_name;
	$data[] = $regist_pass;
	$stmt->execute($data);

	$dbh = null;

	$rec = $stmt->fetch(PDO::FETCH_ASSOC);

	if($rec == false)
	{
		session_start();
		$_SESSION['bool']=$rec;
		header('Location: login.php');
		exit();
	}
	else
	{
		session_start();
		$_SESSION['bool']=1;
		//$_SESSION['regist_name']=$regist_name;
		$_SESSION['regist_name']=$rec['name'];
		header('Location: index.php');
		exit();
	}

}
catch (Exception $e)
{
	print$e;
	print 'Sorry!!Connection lost!!';
	exit();
}


?>
