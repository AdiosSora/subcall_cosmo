<!--届いたフレンド申請に対して行動のチェック-->
<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['bool']) == false)
{
	print 'ゲストユーザーではこの機能は使えません';
	print '<a href="../index.php">top画面へ</a><br />';
	print '<br />';
}
// 選択されているか、不正に入ったかチェック
else if(isset($_POST['add_num']) == false)
{
  header('Location: friend_ng.php');
  exit();
}
else
{
	$user_num = $_SESSION['regist_number'];    	// ユーザー番号取得
	$add_num = $_POST['add_num'];		// 選択した会員番号取得
	$add_name = $_POST['add_name'];		// 選択した会員名取得

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>フレンド機能</title>
</head>
<body>
  <?php
	// DB接続(mysql, xampp)
	$dsn = 'mysql:dbname=subcall;host=localhost;charset=utf8';
	$user = 'root';
	$password = 'kcsf';
	$dbh = new PDO($dsn,$user,$password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	print '<form method="post" action="friend_add_done.php">';
	if(isset($_POST['add_yes']) == true)
 	{
	 	print $_SESSION['regist_name'];
	 	print '様に届いた申請を許可します'.'</br>';
		print '会員番号：'.$add_num;
	  print '　　会員名：'.$add_name.'</br>';

	  print '<input type="hidden" name="add_done_num" value="'.$add_num.'">';
	  print '<input type="hidden" name="add_done_name" value="'.$add_name.'">';
	  print '<br />';
	  print '<input type="submit" name="add_done_yes" value="はい">';
	}
	else if(isset($_POST['add_no']) == true)
	{
		print $_SESSION['regist_name'];
		print '様に届いた申請を却下します'.'</br>';
		print '会員番号：'.$add_num;
		print '　　会員名：'.$add_name.'</br>';

		print '<input type="hidden" name="add_done_num" value="'.$add_num.'">';
		print '<input type="hidden" name="add_done_name" value="'.$add_name.'">';
		print '<br />';
		print '<input type="submit" name="add_done_no" value="はい">';
	}
	print '<button type="button" onclick="history.back()" value="no">いいえ</button>';
	print '</form>';
	print '<br />';
}
?>
<a href="friend.php">フレンド画面へ</a></br>
<a href="../index.php">トップ画面へ</a>
</body>
</html>
