<!--ようこそゲスト様or○○（ログインユーザー）様-->
<?php
session_start();
session_regenerate_id(true);
// test用データ、削除予定
//$_SESSION['bool']= null; // 「null」,「1」いずれか代入で分岐可能
//$_SESSION['regist_name'] = '太郎';
// test用、ここまで
<<<<<<< HEAD
?>
<!--ここまで、ようこそ○○様-->



=======

// セッション名は統一
if(isset($_SESSION['bool']) == false)
{
	print 'ようこそゲスト様<br />';
  print '<a href="login.php">会員ログイン</a><br />';
  print '<a href="register.php">新規会員登録</a><br />';
	print '<br />';
}
else
{
	print 'ようこそ';
	print $_SESSION['regist_name'];
	print '様　';
	print '<br />';
}
?>
<!--ここまで、ようこそ○○様-->

>>>>>>> 328c7551208c8557ee9a13f64e855196cb2c1da9
<nav class="white" role="navigation">
  <div class="nav-wrapper container">
    <a id="logo-container" href="./index.php" class="brand-logo">
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
          print '<li><a href="login.php">Log in</a></li>';
          print '<li><a href="register.php"Sign up</a></li>';
          print '<br />';
        }
        else
        {
          print 'ようこそ';
          print $_SESSION['regist_name'];
          print '様　';
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
