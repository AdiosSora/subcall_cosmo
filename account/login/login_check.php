<?php
try
{
	require_once('../../common.php');
	include('../db/dbConnecter.php');
	$post = sanitize($_POST);
	$regist_name = $post['name'];
	$regist_pass = $post['pass'];
	$regist_pass = hash('sha256' , $regist_pass);

	$dbh = get_DBobj();
	$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	// �o�^�ԍ����擾
	$sql = 'SELECT number, name, mail_address FROM account WHERE name=? AND pass=?';
	//$sql = 'SELECT name, mail_address FROM account WHERE name=? AND pass=?';

	$stmt = $dbh->prepare($sql);
	$data[] = $regist_name;
	$data[] = $regist_pass;
	$stmt->execute($data);

	$dbh = null;

	$rec = $stmt->fetch(PDO::FETCH_ASSOC);

	if($rec == true){
		session_start();
		$_SESSION['bool']=1;
		// �o�^�ԍ��擾
		$_SESSION['regist_number']=$rec['number'];

		$_SESSION['regist_name']=$rec['name'];
		$_SESSION['regist_address']=$rec['mail_address'];
		header('Location: ../../index.php');
		exit();
	}else{

			header('Location: ../login/login.php?check=error');
			exit();
	}

}
catch (Exception $e)
{
	header('Location: ../login/login.php?check=error');
	exit();
}


?>
