<!--フレンド検索の結果-->
<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['bool']) == false)
{
	print 'ゲストユーザーではこの機能は使えません';
	print '<a href="../index.php">top画面へ</a><br />';
	print '<br />';
}
else if(isset($_POST['search_check']) == false)
{
  // 不正な動作でたどり着いた
  header('Location: friend_ng.php');
  exit();
}
else
{
  print $_SESSION['regist_name'];
  print '様の出す申請を管理します。';
	print '<br /><br />';
  // 変数の定義、初期化
	$user_num = $_SESSION['regist_number'];    	// ユーザー番号取得
  $search_num = $_POST['search_num'];   // 申請する相手番号取得
  $search_name = $_POST['search_name'];   // 申請する相手名取得

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

  // すでに申請されているか確認
	$sql_add = 'SELECT count(user_number) FROM friendlist
					WHERE flag=false AND user_number=? AND friend_number=?';

	$stmt_add = $dbh->prepare($sql_add);
	$data[] = $user_num;
	$data[] = $search_num;
	$stmt_add->execute($data);

	$rec_add = $stmt_add->fetch(PDO::FETCH_ASSOC);

  // すでに申請しているか確認
	$sql_get = 'SELECT count(user_number) FROM friendlist
					WHERE flag=false AND friend_number=? AND user_number=?';

	$stmt_get = $dbh->prepare($sql_get);
	$stmt_get->execute($data);

	$rec_get = $stmt_get->fetch(PDO::FETCH_ASSOC);

  $dbh = null;

  if($rec_add['count(user_number)'] >0){
    // すでに相手から申請されている、friend_add_check.php に飛ばせるようにする
    print 'すでに　'.$search_name.'　様から申請されています。'.'<br />';
    print '申請を許可しますか？'.'<br />';
    print '<form method="post" action="friend_add_check.php">';
    print '<input type="hidden" name="add_num" value="'.$search_num.'">';
		print '<input type="hidden" name="add_name" value="'.$search_name.'">'.'</br>';
    print '<input type="submit" name="add_yes" value="許可">';
    print '<input type="submit" name="add_no" value="不可">';
  	print '<button type="button" onclick="history.back()" value="no">戻る</button>';
    print '</form>';

  }else if($rec_get['count(user_number)'] >0){
    // すでに相手に申請している、friend_get_check.php に飛ばせるようにする
    print 'すでに　'.$search_name.'　様へ申請しています。'.'<br />';
    print '申請を取り下げますか？'.'<br />';
    print '<form method="post" action="friend_get_check.php">';
    print '<input type="hidden" name="get_num" value="'.$search_num.'">';
    print '<input type="hidden" name="get_name" value="'.$search_name.'">'.'</br>';
    print '<input type="submit" name="get_check" value="取り下げる" >';
    print '<button type="button" onclick="history.back()" value="no">戻る</button>';
    print '</form>';

  }else{
    // それ以外
    print '以下の方に申請します。'.'<br />';
    print '<form method="post" action="friend_search_done.php">';
    print '会員番号：'.$search_num;
    print '　　会員名：'.$search_name;
    print '<input type="hidden" name="search_done_num" value="'.$search_num.'">';
    print '<input type="hidden" name="search_done_name" value="'.$search_name.'">'.'</br>';
    print '<input type="submit" name="search_done" value="申請する" >';
    print '<button type="button" onclick="history.back()" value="no">申請しない</button>';
    print '</form>';

  }

}
?>
<a href="friend.php">フレンド画面へ</a></br>
<a href="../index.php">トップ画面へ</a>
</body>
</html>
