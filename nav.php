<!--ようこそゲスト様or○○（ログインユーザー）様-->
<?php
try{
session_start();
session_regenerate_id(true);

} catch (Exception $e) {
}
// test用データ、削除予定
//$_SESSION['bool']= null; // 「null」,「1」いずれか代入で分岐可能
//$_SESSION['regist_name'] = '太郎';
// test用、ここまで
?>
<nav class="white" role="navigation">
  <div class="nav-wrapper container">
    <a id="logo-container" href="/index.php" class="brand-logo">
      <img src="/images/STABLE_logo.png">
    </a>
    <ul class="right hide-on-med-and-down">
      <?php
        // セッション名は統一
        if(isset($_SESSION['bool']) == false)
        {
          print '<li><a href="#">Stableとは？</a></li>';
          print '<li><a href="#">使い方</a></li>';
          print '<li><a href="/account/login/login.php">ログイン</a></li>';
          print '<li><a href="/account/register/register.php">会員登録</a></li>';
          print '<br />';
        }
        else
        {
          include('account/db/dbConnecter.php');
          $dbh = get_DBobj();
          $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $regist_name = $_SESSION['regist_name'];
          $data_invite[] = $regist_name;
          $sql = 'SELECT host_name,room_name,count(inv_name) FROM invitation WHERE inv_name=?';
          $stmt = $dbh->prepare($sql);
          $stmt->execute($data_invite);
          $flaginvite = false;
          while(true){
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
            $count_invite = $rec['count(inv_name)'];
            if($flaginvite == false){
              print '<div id="modal_friend_invite" class="modal col s10 offset-s1" style="color:black !important;overflow:hidden;">';
              print '<div class="modal-content">';
              print '<h4>申請済みリスト</h4>';
              print '<table border="1" >';
              print '<tr><th style="text-align:center">招待した人</th><th style="text-align:center">入室ボタン</th><th></th></tr>';
              $flaginvite = true;
            }
            if($rec == false){
              print '</table></div><div class="modal-footer">';
              print '<a href="#!" class="modal-close waves-effect waves-green btn-flat">閉じる</a>';
              print '</div></div>';
              if($count_invite == 0){
                print '<li><a class="waves-effect waves-light btn modal-trigger" href="#modal_friend_invite">新着</a></li>';
              }
              break;
            }
            print '<tr><td style="text-align:center;font-size:40px;">'.$rec['host_name'].'</td><td style="text-align:center"><a class="waves-effect waves-light btn" href="/join.php?room_ID='.$rec['room_name'].'">入室</a></td></tr>';
          }

          print '<li style="color:#111111 !important;margin:0 10px;">'.$_SESSION['regist_name'].'さん</li>';
          print '<li><a href="#">Stableとは？</a></li>';
          print '<li><a href="#">使い方</a></li>';
          print '<li><a href="/account/profile/profile.php">マイページ</a></li>';
          print '<li><a href="/account/logout/logout.php">ログアウト</a></li>';
        }
       ?>
    </ul>
    <ul id="nav-mobile" class="sidenav">
      <?php
        // セッション名は統一
        if(isset($_SESSION['bool']) == false)
        {
          print '<li><a href="#">Stableとは？</a></li>';
          print '<li><a href="#">使い方</a></li>';
          print '<li><a href="/account/login/login.php">ログイン</a></li>';
          print '<li><a href="/account/register/register.php">会員登録</a></li>';
          print '<br />';
        }
        else
        {
          print '<li style="color:#111111 !important;margin:0 10px;">'.$_SESSION['regist_name'].'さん</li>';
          print '<li><a href="#">Stableとは？</a></li>';
          print '<li><a href="#">使い方</a></li>';
          print '<li><a href="/account/profile/profile.php">マイページ</a></li>';
          print '<li><a href="/account/logout/logout.php">ログアウト</a></li>';
        }
       ?>
    </ul>
    <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
  </div>
</nav>
<script>
  $(document).ready(function(){
    $('.modal').modal();
  });
</script>
