
<?php
try{

session_start();
if(isset($_SESSION['bool'])==false){
  print'ログインされていません。<br/>';
  print'<a href="login.php">ログイン画面へ</a>';
  exit();
}

} catch (Exception $e) {
  print $e;
}

?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8"/>
  </head>
  <body>
  <h1>Profile</h1>

  <?php
      $dsn = 'mysql:dbname=subcall;host=localhost;charset=utf8';
      $user = 'root';
      $password = 'kcsf';
      $dbh = new PDO($dsn,$user,$password);
      $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

      $regist_address = $_SESSION['regist_address'];
      $data[] = $regist_address;

      $sql = 'SELECT img FROM account WHERE mail_address=?';
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);
      $rec = $stmt->fetch(PDO::FETCH_ASSOC);

      if(empty($rec['img'])){
         print'<img src="/download/default.png"><br><br>';
      }else{
         print $rec['img'].'<br><br>';
      }


      print'ユーザ名：'.$_SESSION['regist_name'].'<br/><br/>';
      print'E-mail：'.$_SESSION['regist_address'].'<br/><br/>';



      print'生年月日 : ';
      $sql = 'SELECT borne FROM account WHERE mail_address=?';
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);
      $rec = $stmt->fetch(PDO::FETCH_ASSOC);

      if(empty($rec['borne'])){
         print'未設定<br><br>';
      }else{
         print $rec['borne'].'<br><br>';
      }

      print'国 : ';
      $sql = 'SELECT country FROM account WHERE mail_address=?';
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

      $rec = $stmt->fetch(PDO::FETCH_ASSOC);
      if(empty($rec['country'])){
         print'未設定<br><br>';
      }else{
         print $rec['country'].'<br><br>';
      }

      print'性別 : ';
      $sql = 'SELECT gender FROM account WHERE mail_address=?';
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);

      $rec = $stmt->fetch(PDO::FETCH_ASSOC);
      if(empty($rec['gender'])){
         print'未設定<br><br>';
      }else{
         print $rec['gender'].'<br><br>';
      }

      $dbh = null;
  ?>
    <a href="register_update.php"><button type="button">編集</button></a><br/><br/><br/>
    </form>
    <a href="delete.php">退会</a>
  </body>
</html>
