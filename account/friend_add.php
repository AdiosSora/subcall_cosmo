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
	print '現在のフレンド数：';
	print $_POST['count_friend'];
	print '　／　10';
	if($_POST['count_friend'] >=10){
		print '<br />'.'※10人までしか登録できません※';
	}
	print '</br></br>';

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

	print '</br>';

	while(true){

		$rec = $stmt->fetch(PDO::FETCH_ASSOC);

  	if($rec == false){
			break;
		}

		print '<form method="post" action="friend_add_check.php">';
		print '会員番号：'.$rec['number'];
		print '　　会員名：'.$rec['name'];
		print '<input type="hidden" name="add_num" value="'.$rec['number'].'">';
		print '<input type="hidden" name="add_name" value="'.$rec['name'].'">'.'</br>';
		if($_POST['count_friend'] < 10){
			print '<input type="submit" name="add_yes" value="許可">';
		}
	  print '<input type="submit" name="add_no" value="不可">';
		print '</form>';

		}

  print '</br>';

	print '<a href="friend.php">フレンド画面へ</a></br>';
	print '<a href="../index.php">トップ画面へ</a>';

}
?>
</body>
</html>
