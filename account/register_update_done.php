
<?php

try{
session_start();
session_regenerate_id(true);

if(isset($_SESSION['bool'])==false){
  print'ログインされていません。<br/>';
  print'<a href="login.php">ログイン画面へ</a>';
  exit();
}

$image = $_FILES['image'];

require_once('../common.php');
$post = sanitize($_POST);

$name = $post['name'];
$mail_address = $post['mail_address'];
$year = $post['year'];
$month = $post['month'];
$day = $post['day'];
$country = $post['country'];
$gender = $post['gender'];
$_SESSION['img'] = $image['name'];
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

// ファイルがアップロードされているかと、POST通信でアップロードされたかを確認
if( !empty($_FILES['image']['tmp_name']) ) {

	// ファイルを指定したパスへ保存する
	if(move_uploaded_file($image['tmp_name'],'../download/'.$image['name'])) {
		print 'アップロードされたファイルを保存しました。';
	} else {
		print 'アップロードされたファイルの保存に失敗しました。';
    print'<a href="profile.php">戻る</a>';
    exit();
	}
}

// 縦横、51pxに収まるように縮小したい
$width = 512;
$height = 512;
header('Content-type: image/png')
$icon = new Imagick('無題.png');
// オリジナルのサイズ取得
$width_org = $icon->getImageWidth();
$height_org = $icon->getImageHeight();
// 縮小比率を計算
$ratio = $width_org / $height_org;
if ($width / $height > $ratio) {
    $width = $height * $ratio;
} else {
    $height = $width / $ratio;
}
// 縮小実行
$icon->scaleImage($width, $height);
// 保存
$icon->setCompressionQuality(80);
$icon->writeImage('../download/'.time().$image['name']);
$icon->destroy();

print'<a href="profile.php">戻る</a>';



} catch (Exception $e) {
  print $e;
}
?>
