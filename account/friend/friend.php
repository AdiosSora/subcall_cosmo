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
else
{
	print 'ようこそ';
	print $_SESSION['regist_name'];
	print '様　';
	print '<br /><br />';
	// ユーザー番号取得
	$user_num = $_SESSION['regist_number'];

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>フレンド機能</title>
</head>
<body>

<?php
	// 変数の定義、初期化
	$count_send = 0;	// 送ったフレンド申請
	$count_get = 0;		// 届いたフレンド申請
	$count_user = 0;	// フレンド総数

	// DB接続(mysql, xampp)
	$dbh = get_DBobj();
	$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	// フレンド数取得
	$sql = 'SELECT count(user_number) FROM friendlist
					WHERE (user_number=? or friend_number=?) and flag=true';

	$stmt = $dbh->prepare($sql);
	$data_count[] = $user_num;
	$data_count[] = $user_num;
	$stmt->execute($data_count);



	$rec = $stmt->fetch(PDO::FETCH_ASSOC);

	$count_user = $rec['count(user_number)'];

	// 送ったフレンド申請
	// 送ったフレンド申請の数を取得
	$sql = 'SELECT count(friend_number) FROM friendlist WHERE friend_number=? and flag=false';

	$stmt = $dbh->prepare($sql);
	$data[] = $user_num;
	$stmt->execute($data);

	$rec = $stmt->fetch(PDO::FETCH_ASSOC);

	$count_send = $rec['count(friend_number)'];

	print '<form method="post" action="friend_get.php">';
	print '送ったフレンド申請：';
	print $count_send.'件　　　';

	if($count_send > 0){
		print '<input type="hidden" name="count_friend" value="'.$count_user.'">';
		print '<input type="submit" name="get" value="申請の詳細へ">';
	}

	print '</form>';

	// 届いたフレンド申請
	// 届いたフレンド申請の数を取得
	$sql = 'SELECT count(user_number) FROM friendlist WHERE user_number=? and flag=false';

	$stmt = $dbh->prepare($sql);
	// $data[]は不要
	$stmt->execute($data);

	$rec = $stmt->fetch(PDO::FETCH_ASSOC);

	$count_get = $rec['count(user_number)'];

	$dbh = null;

	print '<form method="post" action="friend_add.php">';
	print '届いたフレンド申請：';
	print $count_get.'件　　　';

	if($count_get > 0){
		print '<input type="hidden" name="count_friend" value="'.$count_user.'">';
		print '<input type="submit" name="add" value="登録の可否へ">';
	}

	print '</form>';

	// フレンド数

	print '<form method="post" action="friend_list.php">';
	print 'フレンド数：　';
	print $count_user;
	print '　／　10　　';
	if($count_user > 0){
		print '<input type="submit" name="list" value="フレンドリストへ">';
	}
	print '</form>';
?>
	<!--フレンド申請、指定の名前を検索する-->
	<form method='POST' action="friend_search.php" enctype="multipart/form-data">
		<div class="form_title">
			<label for="name" class="form_name">フレンドを探す</label>
		</div>
        <input type="text" name="search_name" id="name" size="30" maxlength="20" placeholder="フレンド名" autocomplete="off">
				<br>
        <div>
			<input type="submit" name="search" value="検索">
        </div>
	</form>

	<a href="../../index.php">トップ画面へ</a>
<?php
}
?>
</body>
</html>
