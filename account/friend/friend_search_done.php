<!--届いたフレンド申請に対して行動の完了-->
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
// 不正に入ったかチェック
else if(isset($_POST['search_done']) == false)
{
  header('Location: friend_ng.php');
  exit();
}
else
{
  print $_SESSION['regist_name'];
	print '様の以下の方への申請が完了しました。';
	print '<br />';
  // 変数の定義
  $user_num = $_SESSION['regist_number'];    	// ユーザー番号取得
	$search_done_num = $_POST['search_done_num'];		// 選択した会員番号取得
  $search_done_name = $_POST['search_done_name'];   // 選択した名前取得

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
  $sql = 'INSERT INTO friendlist VALUES (?,?,false)';

	$stmt = $dbh->prepare($sql);
	$data[] = $search_done_num; // 申請する相手番号
  $data[] = $user_num;   // 申請した（自身の）番号
	$stmt->execute($data);

  $dbh = null;

  print '会員番号：'.$search_done_num.'　　会員名：'.$search_done_name.'</br>';
  print '</br>';


}
?>
<a href="friend.php">フレンド画面へ</a></br>
<a href="../../index.php">トップ画面へ</a>
</body>
</html>
