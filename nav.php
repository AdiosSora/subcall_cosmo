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
          print '<li style="color:#111111 !important;margin:0 10px;">'.$_SESSION['regist_name'].'さん</li>';
          print '<li><a href="#">Stableとは？</a></li>';
          print '<li><a href="#">使い方</a></li>';
          print '<li><a href="/account/profile/profile.php">マイページ</a></li>';
          print '<li><a href="/account/logout/logout.php">ログアウト</a></li>';
        }
       ?>
    </ul>
    <ul id="nav-mobile" class="sidenav">
      <li><a href="#">Stableとは？</a></li>
      <li><a href="#">使い方</a></li>
    </ul>
    <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
  </div>
</nav>
