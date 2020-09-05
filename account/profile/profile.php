<!DOCTYPE html>
<html lang="ja">
  <head>
<?php
include('../db/dbConnecter.php');
include '../../header.php';
?>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>マイページ - Stable</title>
  </head>
  <body>
    <?php
      include '../../nav.php';
      if(isset($_SESSION['bool'])==false){
        header('Location: /account/login/login.php');
      exit();
      }
    ?>
    <div class="container">
      <div class="section no-pad-bot">
        <div class="row">
          <div class="col s3 center">
            <?php
                $dbh = get_DBobj();
                $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

                $regist_address = $_SESSION['regist_address'];
                $data[] = $regist_address;

                $sql = 'SELECT image FROM account WHERE mail_address=?';
                $stmt = $dbh->prepare($sql);
                $stmt->execute($data);
                $rec = $stmt->fetch(PDO::FETCH_ASSOC);

                $img = $rec['image'];
                print'<img src="'.$img.'" style="width:80%"><br><br>';

              ?>
          </div>
          <div class="col offset-s1 s7 center">
            <table class="centered">
              <?php
                  print '<thead><tr><td>会員番号</td><td>'.$_SESSION['regist_number'].'</td></tr></thead>';
                  print'<thead><tr><td>ユーザ名</td><td>'.$_SESSION['regist_name'].'</td></tr></thead>';
                  print'<thead><tr><td>E-mail</td><td>'.$_SESSION['regist_address'].'</td></tr></thead>';



                  print'<thead><tr><td>生年月日</td><td>';
                  $sql = 'SELECT bone FROM account WHERE mail_address=?';
                  $stmt = $dbh->prepare($sql);
                  $stmt->execute($data);
                  $rec = $stmt->fetch(PDO::FETCH_ASSOC);

                  if(empty($rec['bone']) || strcmp($rec['bone'], "―/―/―") == 0){
                     print'未設定';
                      $_SESSION['regist_bone'] = "";
                  }else{
                     print $rec['bone'];
                     $_SESSION['regist_bone'] = $rec['bone'];
                  }
                  print '</td></tr></thead>';
                  print'<thead><tr><td>居住国</td><td>';
                  $sql = 'SELECT country FROM account WHERE mail_address=?';
                  $stmt = $dbh->prepare($sql);
                  $stmt->execute($data);

                  $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                  if(empty($rec['country']) || strcmp($rec['country'] , "―") == 0){
                     print'未設定';
                  }else{
                     print $rec['country'];
                     $_SESSION['regist_country'] = $rec['country'];
                  }
                  print '</td></tr></thead>';
                  print'<thead><tr><td>性別</td><td> ';
                  $sql = 'SELECT gender FROM account WHERE mail_address=?';
                  $stmt = $dbh->prepare($sql);
                  $stmt->execute($data);

                  $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                  if(empty($rec['gender']) || strcmp($rec['gender'], "―") == 0){
                     print'未設定';
                  }else{
                     print $rec['gender'];
                     $_SESSION['regist_gender'] = $rec['gender'];
                  }
                  print '</td></tr></thead>';
                  $dbh = null;
              ?>
          </table>
          <a class="btn waves-effect waves-light btn-large" href="../register/register_update.php">編集</a><br><br>
          <a href="../delete/delete.php">退会</button></a>
          <a href="../../">トップページに戻る</a>
        </div>
      </div>
    </div>
  </body>
</html>
