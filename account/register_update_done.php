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

$name = $post['name'];
$mail_address = $post['mail_address'];
$year = $post['year'];
$month = $post['month'];
$day = $post['day'];
$country = $post['country'];
$gender = $post['gender'];
<<<<<<< HEAD
$image = $_FILES['image'];//['tmp_name'];

// ファイルがアップロードされているかと、POST通信でアップロードされたかを確認
if( !empty($_FILES//['image']
['tmp_name']
) && is_uploaded_file($_FILES//['image']
['tmp_name']
)) {

	// ファイルを指定したパスへ保存する
	if(move_uploaded_file($_FILES//['image']
  ['tmp_name']
  ,'../download/'.$_FILES//['image']
  ['tmp_name']
)){
=======
$image = $_FILES['image'];



// ファイルがアップロードされているかと、POST通信でアップロードされたかを確認
if( !empty($_FILES['image']['tmp_name']) ) {

	// ファイルを指定したパスへ保存する
	if(move_uploaded_file($image['tmp_name'],'../download/'.$image['name'])) {
>>>>>>> 2d55e6931377c658f57f3ee45a5109c0e9e49ea1
		print 'アップロードされたファイルを保存しました。';
	} else {
		print 'アップロードされたファイルの保存に失敗しました。';
    print'<a href="profile.php">戻る</a>';
    exit();
	}
}

<<<<<<< HEAD
=======
$_SESSION['img'] = $image['name'];
>>>>>>> 2d55e6931377c658f57f3ee45a5109c0e9e49ea1

$borne = $year.'/'.$month.'/'.$day;

$dsn = 'mysql:dbname=subcall;host=localhost;charset=utf8';
$user = 'root';
$password = 'kcsf';
$dbh = new PDO($dsn,$user,$password);
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$data[] = $mail_address;
$data[] = $name;
$data[] = $borne;
$data[] = $country;
$data[] = $gender;
$data[] = $image['name'];
$data[] = $_SESSION['regist_address'];

$sql = 'UPDATE account SET  mail_address=?,name=?,borne=?,country=?,gender=?,image=? WHERE mail_address=?';
$stmt = $dbh->prepare($sql);
$stmt->execute($data);

$dbh = null;

print'<a href="profile.php">戻る</a>';



} catch (Exception $e) {
  print $e;
}
