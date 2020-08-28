
<?php

//ログインしているかの確認
try{
session_start();
session_regenerate_id(true);
include('dbConnecter.php');
if(isset($_SESSION['bool'])==false){
  print'ログインされていません。<br/>';
  print'<a href="login.php">ログイン画面へ</a>';
  exit();
}

//register_updateから送られてきたFILESを一時保存
$image = $_FILES['image'];

//POSTデータのサニタイジング
require_once('../common.php');
$post = sanitize($_POST);

//SQLに使用する変数の準備
$name = $post['name'];
$mail_address = $post['mail_address'];
$year = $post['year'];
$month = $post['month'];
$day = $post['day'];
$country = $post['country'];
$gender = $post['gender'];

$bone = $year.'/'.$month.'/'.$day;

$dbh = get_DBobj();
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$data[] = $mail_address;
$data[] = $name;
$data[] = $bone;
$data[] = $country;
$data[] = $gender;
$data[] = $image['name'];
$data[] = $_SESSION['regist_address'];

$sql = 'UPDATE account SET  mail_address=?,name=?,bone=?,country=?,gender=?,image=? WHERE mail_address=?';
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$dbh = null;

$file_path = '';
// ファイルがアップロードされているかの確認
if(!empty($_FILES['image']['tmp_name']) ) {
    	// ファイルを指定したパスへ保存する
    	if(move_uploaded_file($image['tmp_name'],'../download/'.$image['name'])) {
      		print 'プロフィール情報を保存しました。';
          // ファイルの読み込み
          $file_path = 'C:/xampp/htdocs/download/'.$image['name'];
    	} else {
      		print 'プロフィール情報の保存に失敗しました。';
          print'<a href="profile.php">戻る</a>';
          exit();
    	}
}else{
    print 'プロフィール情報を保存しました。';
    $file_path = 'C:/xampp/htdocs/download/default.png';
}

$icon = new Imagick($file_path);

// 縦横、最大512pxに収まるように縮小したい
$width = 100;
$height = 100;

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
// 圧縮率
$icon->setCompressionQuality(50);
// 保存
clearstatcache();
$icon->writeImage($file_path);
// 破棄
$icon->destroy();

print'<a href="../">トップページに戻る</a>';


} catch (Exception $e) {
  print $e;
}

?>
