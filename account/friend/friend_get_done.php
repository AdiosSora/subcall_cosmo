<!--選択したフレンド申請の取り下げの完了-->
<?php
session_start();
session_regenerate_id(true);
include('../db/dbConnecter.php');
if(isset($_SESSION['bool']) == false)
{
	print 'ゲストユーザーではこの機能は使えません';
	print '<a href="../../index.php">top画面へ</a><br />';
	print '<br />';
}
// 選択されているか,不正に入ったかチェック
else if(isset($_POST['get_done']) == false)
{
  header('Location: friend_ng.php');
  exit();
}
else
{
	print $_SESSION['regist_name'];
	print '様の申請取り消し完了';
	print '<br />';
  // 変数の定義、初期化
	$get_done_num = $_POST['get_done_num'];	// 選択した者の会員番号
  $get_done_name = $_POST['get_done_name'];
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
  // DB接続(mysql, xampp)
	$dbh = get_DBobj();
	$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  // friendlist から条件に合う番号の名前を account から取得
  $sql = 'DELETE FROM friendlist where user_number=? AND friend_number=? AND flag=false';

	$stmt = $dbh->prepare($sql);
	$data[] = $get_done_num; // 申請された番号
  $data[] = $user_num;   // 申請した（自身の）番号
	$stmt->execute($data);

  $dbh = null;

  print '会員番号：'.$get_done_num.'　　会員名：'.$get_done_name.'</br>';
  print '申請を取り下げました';
  print '</br>';

  print '<a href="friend.php">フレンド管理画面へ(friend.phpへ)</a></br>';
  print '<a href="../../index.php">トップ画面へ</a>';
	}
  ?>
</body>
</html>
