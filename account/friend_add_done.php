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
else if(isset($_POST['send_num']) == false)
{
  header('Location: friend_ng.php');
  exit();
}
else
{
  // 変数の定義
  $user_num = $_SESSION['regist_number'];    	// ユーザー番号取得
	$send_num = $_POST['send_num'];		// 選択した会員番号取得
  $send_name = $_POST['send_name'];   // 選択した名前取得

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

  if(isset($_POST['add_done_yes']) == true)
 	{
    // フレンド申請を許可する場合
	 	print $_SESSION['regist_name'];
	 	print '様に届いた申請を許可しました'.'</br>';

    // friendlist から条件に合う行を更新
    $sql = 'UPDATE friendlist SET flag=true
            WHERE user_number=? and friend_number=? AND flag=false';

  	$stmt = $dbh->prepare($sql);
    $data[] = $user_num;   // 申請された（自身の）番号
    $data[] = $send_num; // 申請が来た（相手の）番号
  	$stmt->execute($data);

    $dbh = null;

		print '会員番号：'.$send_num;
	  print '　　会員名：'.$send_name.'</br>';
	 	print '<br />';
	}
	else if(isset($_POST['add_done_no']) == true)
	{
		print $_SESSION['regist_name'];
		print '様に届いた申請を却下しました'.'</br>';

    // friendlist から条件に合う行を削除
    $sql = 'DELETE FROM friendlist
            WHERE user_number=? and friend_number=? AND flag=false';

  	$stmt = $dbh->prepare($sql);
    $data[] = $user_num;   // 申請された（自身の）番号
    $data[] = $send_num; // 申請が来た（相手の）番号
  	$stmt->execute($data);

    $dbh = null;

		print '会員番号：'.$send_num;
		print '　　会員名：'.$send_name.'</br>';
		print '<br />';
	}
}
?>
<a href="friend.php">フレンド画面へ</a></br>
<a href="../index.php">トップ画面へ</a>
</body>
</html>
