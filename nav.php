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
      <div>
        <object id="front-page-logo" class="responsive-img" width="170px" type="image/svg+xml" data="STABLE_logo.svg">
          Your browser does not support SVG.
        </object>
      </div>
    </a>
    <ul class="right hide-on-med-and-down">
     <li><a href="#">Stableとは？</a></li>
     <li><a href="#">使い方</a></li>
      <?php
        // セッション名は統一
        if(isset($_SESSION['bool']) == false)
        {
          print '<li><a href="/account/login.php">Log in</a></li>';
          print '<li><a href="/account/register.php"Sign up</a></li>';
          print '<br />';
        }
        else
        {
          print '<li><a href="#">ようこそ';
          print $_SESSION['regist_name'];
          print '様</a></li>';
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
