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
  // DB接続
	$dbh = get_DBobj();
	$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	// 悲観的排他制御の開始
	$dbh->beginTransaction();

	// 更新処理中にすでに更新されていないかチェック
	$sql_check = 'SELECT count(user_number) FROM friendlist
					WHERE user_number in(?,?) AND friend_number in(?,?) AND flag=true
					FOR UPDATE';

	$stmt_check = $dbh->prepare($sql_check);
	$data_check[] = $get_done_num; // 申請する相手番号
  $data_check[] = $user_num;   // 申請した（自身の）番号
	$data_check[] = $get_done_num; // 申請する相手番号
  $data_check[] = $user_num;   // 申請した（自身の）番号
	$stmt_check->execute($data_check);

	$rec = $stmt_check->fetch(PDO::FETCH_ASSOC);

	//テスト用、(x)秒待機
	// sleep(3);

	if($rec['count(user_number)'] == 0){
		// 自身が先に申請を取り下げた or 相手が先にフレンド登録を不可にした
		// 該当する行を削除、ない場合は0行を削除（DBは変化なし）
	  $sql = 'DELETE FROM friendlist where user_number=? AND friend_number=? AND flag=false';

		$stmt = $dbh->prepare($sql);
		$data[] = $get_done_num; // 申請された番号
	  $data[] = $user_num;   // 申請した（自身の）番号
		$stmt->execute($data);

	  print '会員番号：'.$get_done_num.'　　会員名：'.$get_done_name.'</br>';
	  print '申請を取り下げました';
	  print '</br>';

	}else{
		// 相手が先にフレンド登録した場合
		print '申請の取り下げ処理中に、'.$get_done_name.'様が申請を許可したため、処理を中断しました。';

		print '<br />';
		print 'フレンドリストから削除しますか？'.'<br />';
    print '<form method="post" action="friend_list_check.php">';
    print '<input type="hidden" name="list_num" value="'.$get_done_num.'">';
		print '<input type="hidden" name="list_name" value="'.$get_done_name.'">'.'</br>';
    print '<input type="submit" name="list_check" value="削除する">';
		print '</form>';
		print '<form method="post" action="friend.php">';
    print '<input type="submit" name="add_no" value="削除しない">';
		print '</form>';
	}

	// 悲観的排他制御の終了
	$dbh -> commit();

  $dbh = null;

  print '<a href="friend.php">フレンド管理画面へ</a></br>';
  print '<a href="../index.php">トップ画面へ</a>';
}
?>
</body>
</html>
