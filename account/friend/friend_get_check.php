<!--選択したフレンド申請の取り下げの確認-->
<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['bool']) == false)
{
	print 'ゲストユーザーではこの機能は使えません';
	print '<a href="../../index.php">top画面へ</a><br />';
	print '<br />';
}
// 選択されているか,不正に入ったかチェック
else if(isset($_POST['get_check']) == false)
{
  header('Location: friend_ng.php');
  exit();
}
else
{
	print $_SESSION['regist_name'];
	print '様の以下の申請を取り消します';
	print '<br />';
  // 変数の定義、初期化
	$get_num = $_POST['get_num'];	// 選択した者の会員番号
	$get_name = $_POST['get_name']; // 選択した者の名前
	$user_num = $_SESSION['regist_number'];    	// ユーザー番号取得

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>フレンド機能</title>
</head>
<body>
  <?php
	print '<form method="post" action="friend_get_done.php">';
  print '会員番号：'.$get_num;
  print '　　会員名：'.$get_name;
  print '<input type="hidden" name="get_done_num" value="'.$get_num.'">';
  print '<input type="hidden" name="get_done_name" value="'.$get_name.'">'.'</br>';
  print '<input type="submit" name="get_done" value="申請取り下げ" >';
  print '<button type="button" onclick="history.back()" value="no">取り下げない</button>';
  print '</form>';

  print '<a href="../../index.php">トップ画面へ</a>';
	}
  ?>
</body>
</html>
