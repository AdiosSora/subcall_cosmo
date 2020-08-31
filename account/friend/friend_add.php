<!--届いたフレンド申請の管理-->
<?php
session_start();
session_regenerate_id(true);
include('../db/dbConnecter.php');
if(isset($_SESSION['bool']) == false)
{
	print 'ゲストユーザーではこの機能は使えません';
	print '<a href="../../index.php">top画面へ</a><br />';
	print '<a href=""../register/register.php">会員登録</a><br/>';
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
	// 備考に表示するフラグ
	// 0=「許可・不可できます」
	// 1=「相手のフレンドが上限に達しているため、許可できません」
	// 2=「自身のフレンドが上限に達しているため、許可できません」
	$flag = 0;
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
    SELECT friend_number FROM friendlist where user_number=? and flag=false)';

	$stmt = $dbh->prepare($sql);
	$data[] = $user_num;
	$stmt->execute($data);

	?>
	<table border="1">
		<caption>届いた申請一覧</caption>
    <tr>
      <th>会員番号</th>
      <th>会員名</th>
			<th>フレンド数</th>
			<th>許可の実行</th>
			<th>不可の実行</th>
			<th>備考</th>
    </tr>
	<?php

	while(true){

		$rec = $stmt->fetch(PDO::FETCH_ASSOC);

  	if($rec == false){
			break;
		}
		// 申請された相手のフレンド登録件数を取得
		$sql_count = 'SELECT count(user_number) FROM friendlist
										WHERE (user_number=? or friend_number=?) and flag=true';
		$stmt_count = $dbh->prepare($sql_count);
		$data_count[0] = $rec['number'];
		$data_count[1] = $rec['number'];

		$stmt_count->execute($data_count);

		$rec_count = $stmt_count->fetch(PDO::FETCH_ASSOC);

		print '<tr>';
    print '<td>'.$rec['number'].'</td>';
    print '<td>'.$rec['name'].'</td>';
		print '<td align="center">'.$rec_count['count(user_number)'].'　／　10</td>';
		print '<form method="post" action="friend_add_check.php">';
		print '<input type="hidden" name="add_num" value="'.$rec['number'].'">';
		print '<input type="hidden" name="add_name" value="'.$rec['name'].'">';
		print '<td align="center">';
		if($_POST['count_friend'] < 10){
			// 自身のフレンドが上限に達していない場合
			if($rec_count['count(user_number)'] < 10){
				// 相手のフレンドが上限に達していない場合
				print '<input type="submit" name="add_yes" value="申請の許可">';
			}else{
				// 相手のフレンドが上限に達している場合
				print '許可できません。';
				$flag = 1;
			}
			print '</td>';
		}else{
			// 自身のフレンドが上限に達している場合
			print '許可できません。';
			$flag = 2;
		}
		print '<td align="center">';
	  print '<input type="submit" name="add_no" value="申請の不可">';
		print '</td>';
		print '<td>';
		if($flag == 0){
			print '許可・不可できます。';
		}else{
			if($flag == 1){
				print '相手のフレンドが上限に達しているため、許可できません。';
			}else{
				print '自身のフレンドが上限に達しているため、許可できません。';
			}
		}
		print '</td>';
		print '</tr>';
		print '</form>';

		}
	$dbh = null;

	print '</table>';
  print '</br>';

	print '<a href="friend.php">フレンド画面へ</a></br>';
	print '<a href="../../index.php">トップ画面へ</a>';

}
?>
</body>
</html>
