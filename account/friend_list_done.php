<!--現在のフレンドリストの削除完了-->
<?php
session_start();
session_regenerate_id(true);
include('dbConnecter.php');
if(isset($_SESSION['bool']) == false)
{
	print 'ゲストユーザーではこの機能は使えません';
	print '<a href="../index.php">top画面へ</a><br />';
	print '<br />';
}
else if(isset($_POST['list_done']) == false){
	// 不正に入ったユーザの分岐
	header('Location: friend_ng.php');
	exit();
}
else
{
	print $_SESSION['regist_name'];
	print '様の以下のフレンドを削除しました';
	print '<br />';

  // 変数の定義、初期化
	$user_num = $_SESSION['regist_number'];    	// ユーザー番号取得
  $list_done_num = $_POST['list_done_num'];   // フレンド削除する会員番号取得
  $list_done_name = $_POST['list_done_name'];   // フレンド削除する会員名取得

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

  // friendlist から条件に合う行を削除
  $sql = 'DELETE FROM friendlist WHERE flag=true
          AND user_number IN (?,?)
          AND friend_number IN (?,?)';

  $stmt = $dbh->prepare($sql);
  $data[] = $user_num;   // 自身の番号
  $data[] = $list_done_num; // フレンド削除する番号
  $data[] = $user_num;   // 自身の番号
  $data[] = $list_done_num; // フレンド削除する番号

  $stmt->execute($data);

  $dbh = null;

  print '会員番号：'.$list_done_num;
  print '　　会員名：'.$list_done_name;

  print '</br>';
  print '<a href="friend.php">フレンド画面へ</a></br>';
  print '<a href="../index.php">トップ画面へ</a>';
}
?>

</body>
</html>
