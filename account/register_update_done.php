<?php
try{
session_start();
session_regenerate_id(true);

if(isset($_SESSION['bool'])==false){
  print'ログインされていません。<br/>';
  print'<a href="login.php">ログイン画面へ</a>';
  exit();
}

<<<<<<< HEAD
// リサイズ前画像ファイル名
$imageFile1 = $_FILES['image'];

// リサイズ後画像ファイル名
$imageFile2 = $_FILES['image'];

// コピー先画像サイズ指定
$dst_w = 512;
$dst_h = 512;

// コピー先画像作成
$dst_image = imagecreate($dst_w, $dst_h);

// コピー元画像読み込み
$src_image = imagecreatefromjpeg($imageFile1['tmp_name']);

// コピー元画像のサイズ取得
$imagesize = getimagesize($imageFile1['tmp_name']);
$src_w = $imagesize[0];
$src_h = $imagesize[1];

// リサイズしてコピー
imagecopyresampled(
	$dst_image, // コピー先の画像
	$src_image, // コピー元の画像
	0,          // コピー先の x 座標
	0,          // コピー先の y 座標。
	0,          // コピー元の x 座標
	20,          // コピー元の y 座標
	$dst_w,     // コピー先の幅
	$dst_h,     // コピー先の高さ
	$src_w,     // コピー元の幅
	$src_h
); // コピー元の高さ

// 画像をファイルに出力
imagejpeg($dst_image, $imageFile2['name']);
=======
$image = $_FILES['image'];

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

//$img = ImageCreateFromJPEG('../download/'.$_FILES['image']['name']);

//$width = ImageSx($img);
//$height = ImageSy($img);

//$out = ImageCreateTrueColor($width/2, $height/2);
//ImageCopyResampled($out, $img,
    //0,0,0,0, $width/4, $height/4, $width, $height);

//move_uploaded_file($out,'../download/'.$image['name']);



>>>>>>> 4730eefbc3656ccd70ca0dde56bb24350da2c430

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
=======
>>>>>>> 4599f400af9505a8abe80e5364ecee2926225487

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
