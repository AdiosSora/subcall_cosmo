<!--送ったフレンド申請の管理-->
<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['bool']) == false)
{
	print 'ゲストユーザーではこの機能は使えません';
	print '<a href="../index.php">top画面へ</a><br />';
	print '<br />';
}
else
{
	print $_SESSION['regist_name'];
	print '様の出した申請を管理します';
	print '<br />';

  // 変数の定義、初期化
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

  // friendlist から条件に合う番号の名前を account から取得
  $sql = 'SELECT number,name FROM account WHERE number IN (
    SELECT user_number FROM friendlist where friend_number=? and flag=false)';

	$stmt = $dbh->prepare($sql);
	$data[] = $user_num;
	$stmt->execute($data);

  $dbh = null;

	print '申請した者一覧'.'</br>';

	while(true){

		$rec = $stmt->fetch(PDO::FETCH_ASSOC);

  	if($rec == false){
			break;
		}

		print '<form method="post" action="friend_get_check.php">';
		print '<input type="radio" name="cancel_num" value="'.$rec['number'].'" >'.'会員番号：'.$rec['number'].
					'　　会員名：'.$rec['name'].'</br>';
		}
		print '<input type="submit" value="選択した方の申請取り下げ"><br />';
		print '</form>';

		print '<a href="friend.php">戻る</a></br>';
		print '<a href="../index.php">トップ画面へ</a>';

	}
  ?>
</body>
</html>
