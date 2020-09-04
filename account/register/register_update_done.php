<?php


try{
  //ログインしているかの確認
  session_start();
  session_regenerate_id(true);
  include('../db/dbConnecter.php');
  if(isset($_SESSION['bool'])==false){
    print'ログインされていません。<br/>';
    print'<a href="login.php">ログイン画面へ</a>';
    exit();
  }

} catch (Exception $e) {
  print $e;
}
//POSTデータのサニタイジング
require_once('../../common.php');
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

//register_updateから送られてきたFILESを一時保存
$file = $_FILES['triming_image'];

//ファイルがアップロードされているかの確認
if(!empty($file)) {
  print'aiueo';

  //トリミング時の画像の高さ・幅を取得
  $tmp_file_name = $file['type'];
  $x             = $_POST['image_x'];
  $y             = $_POST['image_y'];
  $size          = $_POST['image_w'];

  //画像タイプを判定し、それに対応した読み込みを行う
  $base_img = null;
  if ($tmp_file_name == IMAGETYPE_PNG){
      $base_img = imagecreatefrompng($file);  // PNG
  }
  elseif ($tmp_file_name == IMAGETYPE_JPEG){
      $base_img = imagecreatefromjpeg($file); // JPEG
  }
  elseif ($tmp_file_name == IMAGETYPE_GIF){
      $base_img = imagecreatefromgif($file);  // GIF
  }

  // 読み込んだ画像を加工・保存
  if ($base_img !== null){
      // 新しい画像を作成し、縮小・トリミングした画像を貼り付ける
      $new_img = imagecreatetruecolor(200, 200);
      imagecopyresampled($new_img, $base_img, 0, 0, $x, $y, 200, 200, $size, $size);

      // 一時的な保存先パスを作る
      $img = $_SESSION['regist_number'].$file['name'];

      // 生成した画像をpng化して保存する
      // imagepng($new_img, $tmp_path);

      // ファイルを指定したパスへ保存する
      if(move_uploaded_file($new_img,'../../download/'.$img)) {
        print 'プロフィール情報を保存しました。';
      }else{
        print 'プロフィール情報の保存に失敗しました。';
        print'<a href="profile.php">戻る</a>';
        exit();
      }

        $dbh = get_DBobj();
        $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        $data[] = $mail_address;
        $data[] = $name;
        $data[] = $bone;
        $data[] = $country;
        $data[] = $gender;
        $data[] = $img;
        $data[] = $_SESSION['regist_address'];

        $sql = 'UPDATE account SET  mail_address=?,name=?,bone=?,country=?,gender=?,image=? WHERE mail_address=?';
        $stmt = $dbh->prepare($sql);
        $stmt->execute($data);
        $dbh = null;

  }


}else{
  $dbh = get_DBobj();
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  $data[] = $mail_address;
  $data[] = $name;
  $data[] = $bone;
  $data[] = $country;
  $data[] = $gender;
  $data[] = 'default.png';
  $data[] = $_SESSION['regist_address'];

  $sql = 'UPDATE account SET  mail_address=?,name=?,bone=?,country=?,gender=?,image=? WHERE mail_address=?';
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  $dbh = null;

  $_SESSION['regist_name'] = $name;
  $_SESSION['regist_address'] = $mail_address;
}
print'<a href="../profile/profile.php">プロフィール画面に戻る</a>';
?>
