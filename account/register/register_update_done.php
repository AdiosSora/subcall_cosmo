<?php

//ログインしているかの確認
try{
  session_start();
  session_regenerate_id(true);
  include('../db/dbConnecter.php');
    if(isset($_SESSION['bool'])==false){
      print'ログインされていません。<br/>';
      print'<a href="login.php">ログイン画面へ</a>';
      exit();
    }

  //register_updateから送られてきたFILESを一時保存
  $file = $_FILES['triming_image'];

  // ファイルがアップロードされているかの確認
  if(!empty($_FILES['image']['tmp_name']) ) {
        $tmp_file_name = $file;
        $x             = $_POST['image_x'];
        $y             = $_POST['image_y'];
        $size          = $_POST['image_w'];

        // ファイルタイプを判定し、それに対応した読み込みを行う
        $base_img = null;
        if (exif_imagetype($tmp_file_name) == IMAGETYPE_PNG){
            $base_img = imagecreatefrompng($tmp_file_name);  // PNG
        }
        elseif (exif_imagetype($tmp_file_name) == IMAGETYPE_JPEG){
            $base_img = imagecreatefromjpeg($tmp_file_name); // JPEG
        }
        elseif (exif_imagetype($tmp_file_name) == IMAGETYPE_GIF){
            $base_img = imagecreatefromgif($tmp_file_name);  // GIF
        }

        // 読み込んだ画像を加工・保存
        if ($base_img !== null){
            // 新しい画像を作成し、縮小・トリミングした画像を貼り付ける
            $new_img = imagecreatetruecolor(200, 200);
            imagecopyresampled($new_img, $base_img, 0, 0, $x, $y, 200, 200, $size, $size);

            // 一時的な保存先パスを作る（あとで削除する）
            $tmp_path = "../../download/".$_SESSION['regist_number'].$file['name'];

            // 生成した画像をpng化して保存する
            imagepng($new_img, $tmp_path);

            // 保存した画像をbase64化する
            $img_base64 = base64_encode(file_get_contents($tmp_path));


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

              $dbh = get_DBobj();
              $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

              $data[] = $mail_address;
              $data[] = $name;
              $data[] = $bone;
              $data[] = $country;
              $data[] = $gender;
              $data[] = $img_base64;
              $data[] = $_SESSION['regist_address'];

              $sql = 'UPDATE account SET  mail_address=?,name=?,bone=?,country=?,gender=?,image=? WHERE mail_address=?';
              $stmt = $dbh->prepare($sql);
              $stmt->execute($data);
              $dbh = null;

              // 画像を削除する
              unlink($tmp_path);
              
              $_SESSION['regist_name'] = $name;
              $_SESSION['regist_address'] = $mail_address;
        }
  }
  // ファイルを指定したパスへ保存する
  // if(move_uploaded_file($file['tmp_name'],'../../download/'.$file['name'])) {
  // print 'プロフィール情報を保存しました。';
  // } else {
  // print 'プロフィール情報の保存に失敗しました。';
  // print'<a href="profile.php">戻る</a>';
  // exit();
  // }
  // }else{
  // print 'プロフィール情報を保存しました。';
  // }





  print'<a href="../profile/profile.php">プロフィール画面に戻る</a>';


} catch (Exception $e) {
print $e;
}

?>
