<!--現在のフレンドリストの削除確認-->
<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['bool']) == false)
{
	print 'ゲストユーザーではこの機能は使えません';
	print '<a href="../index.php">top画面へ</a><br />';
	print '<br />';
}
else if(isset($_POST['list_check']) == false){
	// 不正に入ったユーザの分岐
	header('Location: friend_ng.php');
	exit();
}
else
{
	print $_SESSION['regist_name'];
	print '様の以下のフレンドを削除します';
	print '<br />';

  // 変数の定義、初期化
	$user_num = $_SESSION['regist_number'];    	// ユーザー番号取得
  $list_num = $_POST['list_num'];   // フレンド削除する会員番号取得
  $list_name = $_POST['list_name'];   // フレンド削除する会員名取得

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>フレンド機能</title>
</head>
<body>
  <?php
  print '<form method="post" action="friend_list_done.php">';
  print '会員番号：'.$list_num;
  print '　　会員名：'.$list_name;
  print '<input type="hidden" name="list_done_num" value="'.$list_num.'">';
  print '<input type="hidden" name="list_done_name" value="'.$list_name.'">'.'</br>';
  print '<input type="submit" name="list_done" value="フレンド削除" >';
  print '<button type="button" onclick="history.back()" value="no">削除しない</button>';
  print '</form>';

  print '<a href="../index.php">トップ画面へ</a>';

}
?>

</body>
</html>
