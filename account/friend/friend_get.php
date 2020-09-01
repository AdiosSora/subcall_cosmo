<!--送ったフレンド申請の管理-->
<?php
session_start();
session_regenerate_id(true);
include('../db/dbConnecter.php');
if(isset($_SESSION['bool']) == false)
{
	// ゲストユーザ分岐
	print 'ゲストユーザーではこの機能は使えません';
	print '<a href="../../index.php">top画面へ</a><br />';
	print '<br />';
}
else if(isset($_POST['get']) == false){
	// フレンド申請をしていないユーザの分岐
	header('Location: friend_ng.php');
	exit();
}
else
{
	print $_SESSION['regist_name'];
	print '様の出した申請を管理します';
	print '<br />';

  // 変数の定義、初期化
	$user_num = $_SESSION['regist_number'];    	// ユーザー番号取得
	$count_friend = $_POST['count_friend'];		// 現在のフレンド数取得

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
  $sql = 'SELECT number,name FROM account WHERE number IN (
    SELECT user_number FROM friendlist where friend_number=? and flag=false)';

	$stmt = $dbh->prepare($sql);
	$data[] = $user_num;
	$stmt->execute($data);

  $dbh = null;

	print '現在のフレンド数：　';
	print $count_friend;
	print '　／　10　　';
	print '<br /><br />';

	?>
	<table border="1">
		<caption>申請した者一覧</caption>
    <tr>
      <th>会員番号</th>
      <th>会員名</th>
			<th>取り下げの実行</th>
    </tr>

	<?php

	while(true){

		$rec = $stmt->fetch(PDO::FETCH_ASSOC);

  	if($rec == false){
			break;
		}
		print '<tr>';
    print '<td>'.$rec['number'].'</td>';
    print '<td>'.$rec['name'].'</td>';
		print '<form method="post" action="friend_get_check.php">';
    print '<input type="hidden" name="get_num" value="'.$rec['number'].'">';
    print '<input type="hidden" name="get_name" value="'.$rec['name'].'">';
		print '<td align="center">';
    print '<input type="submit" name="get_check" value="申請取り下げ" >';
    print '</form>';
		print '</td>';
		print '</tr>';
		}
		print '</table>';

		print '<a href="friend.php">フレンド画面へ</a></br>';
		print '<a href="../../index.php">トップ画面へ</a>';

	}
  ?>
</body>
</html>
