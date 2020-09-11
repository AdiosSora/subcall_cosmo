<!DOCTYPE html>
<html lang="ja">
  <head>
<?php
include('../../header.php');
?>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>マイページ - Stable</title>
  </head>
  <main>
  <body>
    <?php
      include '../../nav.php';
      if (isset($_SESSION['bool']) == false) {
          header('Location: /account/login/login.php');
          exit();
      }
    ?>
    <div class="container">
      <div class="section no-pad-bot">
        <div class="row">
          <div class="col s4 m2 offset-s1 offset-m1 center">
            <div class="profile_icon">
              <?php
                $dbh = get_DBobj();
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $regist_address = $_SESSION['regist_address'];
                $data[] = $regist_address;
                $sql = 'SELECT image FROM account WHERE mail_address=?';
                $stmt = $dbh->prepare($sql);
                $stmt->execute($data);
                $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                $img = $rec['image'];
                if($img!=null){
                  print'<img src="'.$img.'">';
                }else{
                  print'<img src="../../images/default_icon.png">';
                }
              ?>
            </div>
          </div>
          <div class="col s7 m9 left profile_title">
            <div class="profie_title_left">
              <span class="profile_number"><?php print 'No.'.$_SESSION['regist_number']?></span>
              <span class="profile_name"><?php print $_SESSION['regist_name']?></span>
            </div>
            <div class="profile_title_right">
              <a class="btn waves-effect waves-light" href="../register/register_update.php" style="margin:5px 0px;"><i class="material-icons left">create</i>編集</a>
              <a class="btn waves-effect waves-light" href="/account/friend/friend.php" style="margin:5px 0px;"><i class="material-icons left">group</i>フレンド一覧</a>
              <a class="btn waves-effect waves-light modal-trigger" href="#modal_icon" style="margin:5px 0px;"><i class="material-icons left">image</i>画像変更</a></a>
            </div>
          </div>
        </div>
        <div class="row" style="margin-bottom: 40px;">
          <div class="col offset-m1 m7 s12 center">
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

                  if (empty($rec['bone']) || strcmp($rec['bone'], '―/―/―') == 0) {
                      print'未設定';
                      $_SESSION['regist_bone'] = '';
                  } else {
                      print $rec['bone'];
                      $_SESSION['regist_bone'] = $rec['bone'];
                  }
                  print '</td></tr></thead>';
                  print'<thead><tr><td>居住国</td><td>';
                  $sql = 'SELECT country FROM account WHERE mail_address=?';
                  $stmt = $dbh->prepare($sql);
                  $stmt->execute($data);

                  $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                  if (empty($rec['country']) || strcmp($rec['country'], '―') == 0) {
                      print'未設定';
                  } else {
                      print $rec['country'];
                      $_SESSION['regist_country'] = $rec['country'];
                  }
                  print '</td></tr></thead>';
                  print'<thead><tr><td>性別</td><td> ';
                  $sql = 'SELECT gender FROM account WHERE mail_address=?';
                  $stmt = $dbh->prepare($sql);
                  $stmt->execute($data);

                  $rec = $stmt->fetch(PDO::FETCH_ASSOC);
                  if (empty($rec['gender']) || strcmp($rec['gender'], '―') == 0) {
                      print'未設定';
                  } else {
                      print $rec['gender'];
                      $_SESSION['regist_gender'] = $rec['gender'];
                  }
                  print '</td></tr></thead>';
                  $dbh = null;
              ?>
            </table>
          </div>
          <div class="col s12 m4 center">
            <h5>フレンド一覧</h5>
            <div class="friend_list">
              <?php
                // 変数の定義、初期化
                $user_num = $_SESSION['regist_number'];    	// ユーザー番号取得
                // DB接続(mysql, xampp)
                // flag=true で自身以外の番号と名前を取得

                $dbh = get_DBobj();
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $dbh->prepare($sql);
                $stmt->execute($data);
                $sql = 'SELECT number, name, image FROM account
                        WHERE (number IN(
                        SELECT user_number FROM friendlist
                        WHERE flag=true AND (user_number=? OR friend_number=?)
                      ) OR number IN(
                        SELECT friend_number FROM friendlist
                        WHERE flag=true AND (user_number=? OR friend_number=?)
                      )) AND number NOT LIKE ?
                        ORDER BY number ';
                $stmt = $dbh->prepare($sql);
                $data2[] = $user_num;
                $data2[] = $user_num;
                $data2[] = $user_num;
                $data2[] = $user_num;
                $data2[] = $user_num;
                $stmt->execute($data2);
                $count = 0;
                while(true){
                  $count+=1;
                  print '<div class="friend_col">';
            	    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
            	    if($rec == false){
            	      break;
            	    }
                  if (empty($rec['image'])){
                    print '<img src="../../images/default_icon.png" style="width:80%">';
                  }else{
                      $img = $rec['image'];
                      print '<img src="'.$img.'">';
                  }
            	    print '<span class="friend_row">'.$rec['name'].'</span>';
                  print '</div>';
          	    }
              ?>
            </div>
          </div>
        </div>
      </div>
      <div id="modal_icon" class="modal">
        <div class="modal-content" style="width:60vw;height:50vh;">
          <iframe id="inlineFrameExample"
            width="100%"
            height="100%"
            src="../crop/crop.php">
          </div>
        <div class="modal-footer">
          <a href="#!" class="modal-close waves-effect waves-green btn-flat">Agree</a>
        </div>
      </div>
  </body>
  </main>
  <footer class="page-footer teal">
    <div class="container">
      <div class="row">
        <div class="col l3 s12">
          <h5 class="white-text">概要</h5>
          <ul>
            <li><a class="white-text" href="#!">トップページ</a></li>
            <li><a class="white-text" href="#!">Stableとは？</a></li>
            <li><a class="white-text" href="#!">使い方</a></li>
            <li><a class="white-text" href="/index.php">会議に参加する</a></li>
          </ul>
        </div>
        <div class="col l3 s12">
          <h5 class="white-text"></h5>
          <ul>
            <li><a class="white-text" href="../delete/delete.php">退会</a></li>
            <li><a class="white-text" href="#!">Link 2</a></li>
            <li><a class="white-text" href="#!">Link 3</a></li>
            <li><a class="white-text" href="#!">Link 4</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <div class="container">
      Copyright ©2020 Stable Inc. All rights reserved.
      </div>
    </div>
  </footer>
</html>
