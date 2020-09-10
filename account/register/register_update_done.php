<?php


try{
  //ログインしているかの確認
  session_start();
  session_regenerate_id(true);
  include('../db/dbConnecter.php');
  if(isset($_SESSION['bool'])==false){
    print'ログインされていません。<br/>';
    print'<a href="../login/login.php">ログイン画面へ</a>';
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
if(!empty($file['tmp_name'])) {
//if(!empty($file)) {
  //トリミング時の画像の高さ・幅を取得

  // $size = getimagesize($tmp_file_name);
  // $src_w = 100;
  // $src_h = 100;

  //画像タイプを判定し、それに対応した読み込みを行う
  // $baseImage = null;
  // unlink($tmp_file_name);


  // 読み込んだ画像を加工・保存
  // if ($baseImage != null){
      list($width, $hight) = getimagesize($file['tmp_name']); // 元の画像名を指定してサイズを取得
      // 元の画像から新しい画像を作る準備
      move_uploaded_file($file['tmp_name'],'../../download/'.$file['name']);
      $tmp_file_name = '../../download/'.$file['name'];

      if (exif_imagetype($tmp_file_name) == IMAGETYPE_PNG){
          $baseImage = imagecreatefrompng($tmp_file_name);// PNG
      }
      elseif (exif_imagetype($tmp_file_name) == IMAGETYPE_JPEG){
          $baseImage = imagecreatefromjpeg($tmp_file_name);// JPEG
      }
      elseif (exif_imagetype($tmp_file_name) == IMAGETYPE_GIF){
          $baseImage = imagecreatefromgif($tmp_file_name); // GIF
      }else{
        print'この画像形式には対応していません';
        exit();
      }
      $image = imagecreatetruecolor($width,$hight); // サイズを指定して新しい画像のキャンバスを作成

      // 画像のコピーと伸縮
      imagecopyresampled($image, $baseImage, 0, 0, 0, 0, $width, $hight, $width, $hight);
      // 保存先パスを作る
      $img_path = '../../download/'.$_SESSION['regist_number'].'.jpg';

      // コピーした画像を出力する
      imagejpeg($image , $img_path);
    // // アルファブレンディングを無効にします
    // imagealphablending($baseImage, false);
    //
    // // 真ん中が透過色のマスク画像を用意
    // $mask = imagecreatetruecolor($src_w, $src_h);
    // // 背景色に緑(0, 255, 0)を指定して塗りつぶし(色は任意)
    // $green = imagecolorallocate($mask, 0, 255, 0);
    // imagefill($mask, 0, 0, $green);
    //
    // // マスクの透過色を指定(255, 0, 255)
    // $mask_transparent = imagecolorallocate($mask, 255, 0, 255);
    // imagecolortransparent($mask, $mask_transparent);
    // // 中央の円を透過色で塗りつぶし
    // imagefilledellipse($mask, $src_w/2, $src_h/2, $src_w-20, $src_h-20, $mask_transparent);
    // // imagearc($mask, $src_w/2, $src_h/2, $src_w, $src_h, 0, 360, $mask_transparent);
    // // 元画像とマスク画像を重ね合わせ
    // imagecopymerge($baseImage, $mask, 0, 0, 0, 0, $src_w, $src_h, 100);
    //
    // // 余分な背景色の緑(0, 255, 0)を透過色に指定
    // $src_transparent = imagecolorallocate($baseImage, 0, 255, 0);
    // imagecolortransparent($baseImage, $src_transparent);
    // imagefill($baseImage, 0, 0, $src_transparent);

    // imagecolorallocatealpha($baseImage, 0, 255, 0, 100);


      // // アルファフラグを設定します
      // // imagesavealpha($baseImage, true);
      // // 生成した画像を保存する
      //
      // imagepng($baseImage, $img_path);
      // imagedestroy($baseImage);

      $dbh = get_DBobj();
      $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

      $data[] = $mail_address;
      $data[] = $name;
      $data[] = $bone;
      $data[] = $country;
      $data[] = $gender;
      $data[] = $img_path;
      $data[] = $_SESSION['regist_address'];

      $sql = 'UPDATE account SET  mail_address=?,name=?,bone=?,country=?,gender=?,image=? WHERE mail_address=?';
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);
      $dbh = null;



}else{
  $dbh = get_DBobj();
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  $data[] = $mail_address;
  $data[] = $name;
  $data[] = $bone;
  $data[] = $country;
  $data[] = $gender;
  //$data[] = null;
  $data[] = '../../download/default.png';
  $data[] = $_SESSION['regist_address'];

  $sql = 'UPDATE account SET  mail_address=?,name=?,bone=?,country=?,gender=?,image=? WHERE mail_address=?';
  $stmt = $dbh->prepare($sql);
  $stmt->execute($data);
  $dbh = null;

}
$_SESSION['regist_name'] = $name;
$_SESSION['regist_address'] = $mail_address;
print'<a href="../profile/profile.php">プロフィール画面に戻る</a>';
?>
