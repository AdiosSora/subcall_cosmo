<link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
<link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>

<!DOCTYPE>
<html>
	<body>
		<div class="container">
			<div class="section no-pad-bot">
				<br><br>
				<div class="row">
					<div class="col s12 m6 offset-m3 center">
					<div class="alert  error">[error - 334] <br/>IDかパスワードが間違っています、もう一度入力してください。
						<a class="button" href="login.php">戻る</a></div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
<?php

try
{

	require_once('../common.php');

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

	if($rec == true){
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
