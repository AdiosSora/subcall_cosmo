<!DOCTYPE html>
<html lang="ja">
<head>
<title>退会 - Stable</title>
<?php
  include('../../header.php');
?>
</head>
<body>
  <?php include('../../nav.php'); ?>
  <main>
    <div class="container">
      <div class="section no-pad-bot">
        <div class="row" style="margin: 20vh 0;">
          <div class="col offset-s2 s8 center">
            <?php
            if(isset($_SESSION['bool']) == false)
            {
              print 'お客様はゲストユーザーか、ログインしていないため、退会はできません。'.'<br>';
              print '<a href="../../index.php">戻る</a>';
              print '<br />';
            }
            else
            {
              print '<form method="post" name="destroy_form" action="delete_check.php">';
              print $_SESSION['regist_name'].'　様の退会処理を開始します。';
              print'<input type="hidden" name="name" value="'.$_SESSION['regist_name'].'">';
              print'<input type="hidden" name="address" value="'.$_SESSION['regist_address'].'">';
              print '<input type="password" name="pass" id="pass" size="30" maxlength="20" placeholder="パスワード" autocomplete="off">';
              print '<a class="waves-effect waves-light2 btn-large" href="javascript:destroy_form.submit();" style="margin:5px;">退会</a>';
              print '<a class="waves-effect waves-light2 btn-large" href="javascript:history.back();" style="background-color:#dddddd;color:#111111;margin:5px;">戻る</a>';
              print '</form>';
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </main>
  <?php include('../../footer.php'); ?>
</body>
</html>
