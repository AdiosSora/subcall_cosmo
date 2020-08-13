<?php
  session_start();
  session_regenerate_id(true);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<title>退会画面</title>
</head>
<body>
  <?php
  if(isset($_SESSION['bool']) == false)
  {
    print 'お客様はゲストユーザーか、ログインしていないため、退会はできません。'.'<br>';
    print '<a href="../../index.php">戻る</a>';
    print '<br />';
  }
  else
  {
    print '<form method="post" action="./delete_check.php">';
    print $_SESSION['regist_name'].'　様の退会処理を開始します。';
    print'<input type="hidden" name="name" value="'.$_SESSION['regist_name'].'">';
    print'<input type="hidden" name="address" value="'.$_SESSION['regist_address'].'"><br>';
    print 'パスワードを入力してください。'.'<br>';
    print '<input type="password" name="pass" id="pass" size="30" maxlength="20" placeholder="パスワード" autocomplete="off"><br>';
    print '<a href="../../index.php">戻る</a><br>';
	  print '<input type="submit" value="OK">';
    print '</form>';
  }
  ?>

</body>
</html>
