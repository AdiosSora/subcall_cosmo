
<?php
try{

session_start();
include('../db/dbConnecter.php');

if(isset($_SESSION['bool'])==false){
  print'ログインされていません。<br/>';
  print'<a href="../login/login.php">ログイン画面へ</a>';
  exit();
}

} catch (Exception $e) {
  print $e;
}
include '../../header.php';
?>
<!DOCTYPE html>
<html lang="ja">

  <head>
    <meta charset="utf-8"/>
  </head>
  <body>
    <div class="container">
    <div class="section no-pad-bot">
    <br><br>
    <div class="row">
    <div class="col col s10 offset-m1 m8 offset-m2 center">
    <h2 style="color:black !important;">プロフィール</h2><br/>

  <?php
      $dbh = get_DBobj();
      $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

      $regist_address = $_SESSION['regist_address'];
      $data[] = $regist_address;

      $sql = 'SELECT image FROM account WHERE mail_address=?';
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);
      $rec = $stmt->fetch(PDO::FETCH_ASSOC);

      if(empty($rec['image'])){
           print'<image src="../../download/default.png"><br><br>';
      }else{
          $sql = 'SELECT image FROM account WHERE mail_address=?';
          $stmt = $dbh->prepare($sql);
          $stmt->execute($data);
          $rec = $stmt->fetch(PDO::FETCH_ASSOC);
          $img = $rec['image'];

          print'<image src="../../download/'; print $img.'"><br><br>';

      }

      print '会員番号：'.$_SESSION['regist_number'].'<br/><br/>';
      print'ユーザ名：'.$_SESSION['regist_name'].'<br/><br/>';
      print'E-mail：'.$_SESSION['regist_address'].'<br/><br/>';



      print'生年月日 : ';
      $sql = 'SELECT bone FROM account WHERE mail_address=?';
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);
      $rec = $stmt->fetch(PDO::FETCH_ASSOC);

      if(empty($rec['bone']) || strcmp($rec['bone'], "―/―/―") == 0){
         print'未設定<br><br>';
          $_SESSION['regist_bone'] = "";
      }else{
         print $rec['bone'].'<br><br>';
         $_SESSION['regist_bone'] = $rec['bone'];
      }

      print'居住国 : ';
      $sql = 'SELECT country FROM account WHERE mail_address=?';
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

      $rec = $stmt->fetch(PDO::FETCH_ASSOC);
      if(empty($rec['country']) || strcmp($rec['country'] , "―") == 0){
         print'未設定<br><br>';
      }else{
         print $rec['country'].'<br><br>';
         $_SESSION['regist_country'] = $rec['country'];
      }

      print'性別 : ';
      $sql = 'SELECT gender FROM account WHERE mail_address=?';
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

      $rec = $stmt->fetch(PDO::FETCH_ASSOC);
      if(empty($rec['gender']) || strcmp($rec['gender'], "―") == 0){
         print'未設定<br><br>';
      }else{
         print $rec['gender'].'<br><br>';
         $_SESSION['regist_gender'] = $rec['gender'];
      }

      $dbh = null;
  ?>
    <a class="btn waves-effect waves-light btn-large" href="../register/register_update.php">編集</a><br><br>
    <a href="../delete/delete.php">退会</button></a>
    <a href="../../">トップページに戻る</a>
  </form>
  </body>

</html>
