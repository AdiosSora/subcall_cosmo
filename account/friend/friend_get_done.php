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

	// 更新処理中にすでに更新されていないかチェック
	$sql_check = 'SELECT count(user_number) FROM friendlist
					WHERE user_number in(?,?) AND friend_number in(?,?) AND flag=true';

	$stmt_check = $dbh->prepare($sql_check);
	$data_check[] = $get_done_num; // 申請する相手番号
  $data_check[] = $user_num;   // 申請した（自身の）番号
	$data_check[] = $get_done_num; // 申請する相手番号
  $data_check[] = $user_num;   // 申請した（自身の）番号
	$stmt_check->execute($data_check);

	$rec = $stmt_check->fetch(PDO::FETCH_ASSOC);

	if($rec['count(user_number)'] < 1){
		// 自身が先に更新した
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

	}else{
		// 相手が先に更新した場合
		print '申請の取り下げ処理中に、'.$search_done_name.'様が申請を許可したため、処理を中断しました。';

		// 以下、8/25以降修正
		print '<br />';
		print '申請を許可しますか？'.'<br />';
    print '<form method="post" action="friend_add_check.php">';
    print '<input type="hidden" name="add_num" value="'.$search_done_num.'">';
		print '<input type="hidden" name="add_name" value="'.$search_done_name.'">'.'</br>';
    print '<input type="submit" name="add_yes" value="許可">';
    print '<input type="submit" name="add_no" value="不可">';
  	print '<button type="button" onclick="history.back()" value="no">戻る</button>';
    print '</form>';
	}
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

<<<<<<< HEAD:account/friend_get_done.php
  print '<a href="friend.php">フレンド管理画面へ</a></br>';
  print '<a href="../index.php">トップ画面へ</a>';
=======
  print '<a href="friend.php">フレンド管理画面へ(friend.phpへ)</a></br>';
  print '<a href="../../index.php">トップ画面へ</a>';
>>>>>>> df7142abbf1909cf4807d122de63396e35da49d1:account/friend/friend_get_done.php
	}
  ?>
</body>
</html>
