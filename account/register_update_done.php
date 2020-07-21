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
$image = $_FILES['image'];
/*
//改良１ここから
$h = 200; // リサイズしたい大きさを指定
$w = 200;

//$file = $request->$_FILES['image']; // 加工したいファイルを指定

// 加工前の画像の情報を取得
list($original_w, $original_h, $type) = getimagesize($image['tmp_name']);

// 加工前のファイルをフォーマット別に読み出す（この他にも対応可能なフォーマット有り）
switch ($type) {
    case IMAGETYPE_JPEG:
        $original_image = imagecreatefromjpeg($image);
        break;
    case IMAGETYPE_PNG:
        $original_image = imagecreatefrompng($image['tmp_name']);
        break;
    case IMAGETYPE_GIF:
        $original_image = imagecreatefromgif($image);
        break;
    default:
        throw new RuntimeException('対応していないファイル形式です。: ', $type);
}

// 新しく描画するキャンバスを作成
$canvas = imagecreatetruecolor($w, $h);
imagecopyresampled($canvas, $original_image, 0,0,0,0, $w, $h, $original_w, $original_h);

$resize_path = public_path('../download/new.jpg'); // 保存先を指定

switch ($type) {
    case IMAGETYPE_JPEG:
        imagejpeg($canvas, $resize_path);
        break;
    case IMAGETYPE_PNG:
        imagepng($canvas, $resize_path, 9);
        break;
    case IMAGETYPE_GIF:
        imagegif($canvas, $resize_path);
        break;
}
// ファイルがアップロードされているかと、POST通信でアップロードされたかを確認
if( !empty($canvas['image']['tmp_name']) ) {

	// ファイルを指定したパスへ保存する
	if(move_uploaded_file($canvas['tmp_name'],'../download/'.$canvas['name'])) {
		print 'アップロードされたファイルを保存しました。';
	} else {
		print 'アップロードされたファイルの保存に失敗しました。';
    print'<a href="profile.php">戻る</a>';
    exit();
	}
}
// 読み出したファイルは消去
imagedestroy($original_image);
imagedestroy($canvas);
//改良１ここまで
*/

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

print'<a href="profile.php">戻る</a>';



} catch (Exception $e) {
  print $e;
}
