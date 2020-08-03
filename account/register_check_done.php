<!DOCTYPE html>

<html lang="ja">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="/js/jquery.validate.js"></script>
  <script src="/js/jquery.validate.min.js"></script>
  <script src="/js/register.js"></script>
<title>会員登録完了 - Stable</title>
</head>
<body>
	<!DOCTYPE html>

	<html lang="ja">
	<head>
	  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	  <meta name="viewport" content="width=device-width, initial-scale=1"/>
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	  <script src="/js/jquery.validate.js"></script>
	  <script src="/js/jquery.validate.min.js"></script>
	  <script src="/js/register.js"></script>

	  <title>会員登録 - Stable </title>
	  <?php include '../header.php'; ?>
	  </head>
	  <body>
	    <?php include '../nav.php'; ?>

	    <div id="index-banner" class="parallax-container">
	      <div class="container">
	        <div class="section no-pad-bot">
	          <br><br>
	          <div class="row">
	            <div class="col col s10 offset-m1 m8 offset-m2 center">

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


	print '<h2 style="color:black;">会員登録完了</h2> <br />';

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

<a class="waves-effect waves-light btn" href="../index.php">トップページへ</a>
						</div>
					</div>
				<br><br>
				</div>
			</div>
		</div>
		<?php include '../footer.php'; ?>
	</body>
</html>
