<!--届いたフレンド申請の管理-->
<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['bool']) == false)
{
	print 'ゲストユーザーではこの機能は使えません';
	print '<a href="../index.php">top画面へ</a><br />';
	print '<br />';
}
else if(isset($_POST['add']) == false){
	// フレンド申請が届いてないユーザの分岐
	header('Location: friend_ng.php');
	exit();
}
else
{
	print $_SESSION['regist_name'];
	print '様に届いた申請を管理します';
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
    SELECT friend_number FROM friendlist where user_number=? and flag=false)';

	$stmt = $dbh->prepare($sql);
	$data[] = $user_num;
	$stmt->execute($data);

  $dbh = null;

	print '届いた申請者一覧'.'</br>';
  print '選択後、「許可」「不可」を選んでください'.'</br>';
  print '<form method="post" action="friend_add_check.php">';
	while(true){

		$rec = $stmt->fetch(PDO::FETCH_ASSOC);

  	if($rec == false){
			break;
		}

		print '<input type="radio" name="send_num" value="'.$rec['number'].'" >'.'会員番号：'.$rec['number'].
					'　　会員名：'.$rec['name'].'</br>';
		}
  print '<input type="submit" name="add_yes" value="許可">';
  print '<input type="submit" name="add_no" value="不可">';
  print '</form>';
  print '</br>';

	print '<a href="friend.php">フレンド画面へ</a></br>';
	print '<a href="../index.php">トップ画面へ</a>';

}
?>
</body>
</html>
