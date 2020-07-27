
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
<<<<<<< HEAD
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

      $sql = 'SELECT image FROM account WHERE mail_address=?';
      $stmt = $dbh->prepare($sql);
      $stmt->execute($data);
      $rec = $stmt->fetch(PDO::FETCH_ASSOC);

      if(empty($rec['image'])){
         print'<image src="../download/default.png"><br><br>';
      }else{

          $sql = 'SELECT image FROM account WHERE mail_address=?';
          $stmt = $dbh->prepare($sql);
          $stmt->execute($data);
          $rec = $stmt->fetch(PDO::FETCH_ASSOC);
          $img = $rec['image'];


          print'<image src="../download/'; print $img.'"><br><br>';

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

      print'居住国 : ';
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
  </body>
=======
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <!--<script src="./js/login.js"></script>-->

  <title>Stable - ビデオ会議</title>
  <?php include '../header.php'; ?>
</head>
<body>

  <?php include '../nav.php'; ?>

  <div id="index-banner" class="parallax-container">
    <div class="container">
      <div class="section no-pad-bot">
        <br><br>
        <div class="row" style="color:black;">
          <div class="col offset-s2 s8 center" >
            <h2>ユーザー情報</h2>
          </div>
        </div>
        <div class="row" style="color:black;">
          <div class="col offset-s2 s2 center" >
            <?php
              try{

              if(isset($_SESSION['bool'])==false){
                print'ログインされていません。<br/>';
                print'<a href="login.php">ログイン画面へ</a>';
                exit();
              }

              } catch (Exception $e) {
                print $e;
              }
              $dsn = 'mysql:dbname=subcall;host=localhost;charset=utf8';
              $user = 'root';
              $password = 'kcsf';
              $dbh = new PDO($dsn,$user,$password);
              $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

              $regist_address = $_SESSION['regist_address'];
              $data[] = $regist_address;

              $sql = 'SELECT image FROM account WHERE mail_address=?';
              $stmt = $dbh->prepare($sql);
              $stmt->execute($data);
              $rec = $stmt->fetch(PDO::FETCH_ASSOC);
              if(empty($rec['image'])){
                 print'<image src="../download/default.png"><br><br>';
              }else{

                  $sql = 'SELECT image FROM account WHERE mail_address=?';
                  $stmt = $dbh->prepare($sql);
                  $stmt->execute($data);
                  $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                  $img = $rec['image'];


                  print'<image src="../download/'; print $img.'"><br><br>';

              }
            ?>
          </div>
          <div class="col s6 center">
            <?php
              print'<p>ユーザ名：'.$_SESSION['regist_name'].'</p><br/><br/>';
              print'<p>E-mail：'.$_SESSION['regist_address'].'</p><br/><br/>';



              print'<p>生年月日 : ';
              $sql = 'SELECT borne FROM account WHERE mail_address=?';
              $stmt = $dbh->prepare($sql);
              $stmt->execute($data);
              $rec = $stmt->fetch(PDO::FETCH_ASSOC);

              if(empty($rec['borne'])){
                 print'未設定</p><br><br>';
              }else{
                 print $rec['borne'].'</p><br><br>';
              }

              print'<p>居住国 : ';
              $sql = 'SELECT country FROM account WHERE mail_address=?';
              $stmt = $dbh->prepare($sql);
              $stmt->execute($data);

              $rec = $stmt->fetch(PDO::FETCH_ASSOC);
              if(empty($rec['country'])){
                 print'未設定</p><br><br>';
              }else{
                 print $rec['country'].'</p><br><br>';
              }

              print'<p>性別 : ';
              $sql = 'SELECT gender FROM account WHERE mail_address=?';
              $stmt = $dbh->prepare($sql);
              $stmt->execute($data);

              $rec = $stmt->fetch(PDO::FETCH_ASSOC);
              if(empty($rec['gender'])){
                 print'未設定</p><br><br>';
              }else{
                 print $rec['gender'].'</p><br><br>';
              }

              $dbh = null;
              ?>
              <a href="register_update.php"><button type="button">編集</button></a><br/><br/><br/>
        </div>
      </div>
      <br><br>
    </div>
    </div>
  </div>
  <?php include '../footer.php'; ?>
</body>
>>>>>>> 05f5a88d047b13a0cd0fea2d28b19e8c99aca08f
</html>
