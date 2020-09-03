
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
// $file = $_FILES['image'];

        // $_FILESで受け取れます。
        $file = $_FILES['triming_image'];
        // ファイルがアップロードされているかの確認
        if(!empty($_FILES['triming_image']['tmp_name']) ) {
            	// ファイルを指定したパスへ保存する
            	if(move_uploaded_file($file['tmp_name'],'../../download/'.$file['name'])) {
              		print 'プロフィール情報を保存しました。';
            	} else {
              		print 'プロフィール情報の保存に失敗しました。';
                  print'<a href="profile.php">戻る</a>';
                  exit();
            	}
        }else{
            print 'プロフィール情報を保存しました。';
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

$dbh = get_DBobj();
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$data[] = $mail_address;
$data[] = $name;
$data[] = $bone;
$data[] = $country;
$data[] = $gender;
$data[] = $file['name'];
$data[] = $_SESSION['regist_address'];

$sql = 'UPDATE account SET  mail_address=?,name=?,bone=?,country=?,gender=?,image=? WHERE mail_address=?';
$stmt = $dbh->prepare($sql);
$stmt->execute($data);
$dbh = null;

$_SESSION['regist_name'] = $name;
$_SESSION['regist_address'] = $mail_address;

print'<a href="../profile/profile.php">プロフィール画面に戻る</a>';


} catch (Exception $e) {
  print $e;
}

?>
