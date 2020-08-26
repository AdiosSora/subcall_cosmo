<!--届いたフレンド申請に対して行動の完了-->
<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['bool']) == false)
{
	print 'ゲストユーザーではこの機能は使えません';
	print '<a href="../index.php">top画面へ</a><br />';
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
  $dsn = 'mysql:dbname=subcall;host=localhost;charset=utf8';
  $user = 'root';
  $password = 'kcsf';
  $dbh = new PDO($dsn,$user,$password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	//テスト用、3秒待機
	//sleep(3);

	// friendlist から条件に合う番号の名前を account から取得
	$sql_comit = 'INSERT INTO friendlist VALUES (?,?,false)';

	$stmt_comit = $dbh->prepare($sql_comit);
	$data_comit[] = $search_done_num; // 申請する相手番号
  $data_comit[] = $user_num;   // 申請した（自身の）番号
	$stmt_comit->execute($data_comit);

	// 更新処理中にすでに更新されていないかチェック
	$sql_check = 'SELECT count(user_number) FROM friendlist
					WHERE user_number in(?,?) AND friend_number in(?,?)';

	$stmt_check = $dbh->prepare($sql_check);
	$data_check[] = $search_done_num; // 申請する相手番号
  $data_check[] = $user_num;   // 申請した（自身の）番号
	$data_check[] = $search_done_num; // 申請する相手番号
  $data_check[] = $user_num;   // 申請した（自身の）番号
	$stmt_check->execute($data_check);

	$rec = $stmt_check->fetch(PDO::FETCH_ASSOC);

	if($rec['count(user_number)'] < 2){
		// 申請が重複しない場合
		print $_SESSION['regist_name'];
		print '様の以下の方への申請が完了しました。';
		print '<br />';
	  print '会員番号：'.$search_done_num.'　　会員名：'.$search_done_name.'</br>';
	  print '</br>';
	}else{
		// 申請が重複した場合
		$sql_delete = 'DELETE FROM friendlist WHERE user_number=? AND friend_number=?';

	  $stmt_delete = $dbh->prepare($sql_delete);
		$data_delete[] = $search_done_num; // 申請する相手番号
	  $data_delete[] = $user_num;   // 申請した（自身の）番号

	  $stmt_delete->execute($data_delete);

		print '申請処理中に、'.$search_done_name.'様からの申請が完了したため、処理を中断しました。';
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

	$dbh = null;
}
?>
<a href="friend.php">フレンド画面へ</a></br>
<a href="../index.php">トップ画面へ</a>
</body>
</html>
