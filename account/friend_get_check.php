<!--選択したフレンド申請の取り下げの確認-->
<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['bool']) == false)
{
	print 'ゲストユーザーではこの機能は使えません';
	print '<a href="../index.php">top画面へ</a><br />';
	print '<br />';
}
else if($_POST['cancel_num'] == false){
  print '申請を取り下げる方を選択していません'.'</br>';
  print '<a href="friend_get.php">戻る</a></br>';
}
else
{
	print $_SESSION['regist_name'];
	print '様の申請取り消し';
	print '<br />';
  // 変数の定義、初期化
	$cancel_num = $_POST['cancel_num'];	// 選択した者の会員番号
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
	$dsn = 'mysql:dbname=subcall;host=localhost;charset=utf8';
	$user = 'root';
	$password = 'kcsf';
	$dbh = new PDO($dsn,$user,$password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  // account から選択した番号の名前を取得
  $sql = 'SELECT name FROM account WHERE number=? ';

	$stmt = $dbh->prepare($sql);
	$data[] = $cancel_num;
	$stmt->execute($data);

  $dbh = null;

  $rec = $stmt->fetch(PDO::FETCH_ASSOC);

  $cancel_name = $rec['name'];

  print '以下の方への申請を取り下げますか？'.'</br>';
  print '会員番号：'.$cancel_num;
  print '　　会員名：'.$cancel_name.'</br>';
  print '<form method="post" action="friend_get_done.php">';
  print '<input type="hidden" name="cancel_num" value="'.$cancel_num.'">';
  print '<input type="hidden" name="cancel_name" value="'.$cancel_name.'">';
  print '<br />';
  print '<button type="submit" value="yes">はい</button>';
  print '<button type="button" onclick="history.back()" value="no">いいえ</button>';
  print '</form>';
	}
  ?>
</body>
</html>
