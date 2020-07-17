
<?php
try{
session_start();
if(isset($_SESSION['bool'])==false){
  print'ログインされていません。<br/>';
  print'<a href="login.php">ログイン画面へ</a>';
  exit();
}
} catch (Exception $e) {
}

?>
<!DOCTYPE html>
<html lang="ja">
        <head>
            <meta charset="utf-8"/>
        </head>
        <body>
          <h1>Profile</h1>

            名前：<?php print $_SESSION['regist_name'];?> <br/><br/>
            E-mail： <?php print $_SESSION['regist_address'];?> <br/><br/>

              <?php
               print'生年月日 : ';
                 if(isset($_SESSION['borne'])==false){
                     print '未設定<br><br>';
                 }else {
                     print $_SESSION['borne'];
                 }

               print'国 : ';
                 if(isset($_SESSION['country'])==false){
                   print '未設定<br><br>';
                 }else {
                   print $_SESSION['country'];
                 }

               print'性別 : ';
                 if(isset($_SESSION['gender'])==false){
                   print '未設定<br><br>';
                 }else {
                   print $_SESSION['gender'];
                 }

              ?>

              <a href="register_update.php">
                <button type="button">編集</button>
              </a>
              <br>
              <br>
              <br>
              <a href="delete.php">退会</a>
          </form>

        </body>
</html>
