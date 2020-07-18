<?php
try{
session_start();
session_regenerate_id(true);

if(isset($_SESSION['bool'])==false){
  print'ログインされていません。<br/>';
  print'<a href="login.php">ログイン画面へ</a>';
  exit();
}

require_once('../common.php');
$post = sanitize($_POST);
$year = $post['year'];
$month = $post['month'];
$day = $post['day'];
$country = $post['country'];
//$gender = $post['gender[]'];



$borne = $year.$month.$day;

	$dsn = 'mysql:dbname=subcall;host=localhost;charset=utf8';
	$user = 'root';
	$password = 'kcsf';
	$dbh = new PDO($dsn,$user,$password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	$data[] = $borne;
	$data[] = $country;
	$data[] = $gender;
	$sql = 'INSERT INTO account(borne,country,gender) VALUES (?,?,?)';
	$stmt = $dbh->prepare($sql);
	$stmt->execute($data);

	$dbh = null;

} catch (Exception $e) {
  print $e;
}
