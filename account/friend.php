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
	print 'ようこそ';
	print $_SESSION['regist_name'];
	print '様　';
	print '<br />';
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
	$dsn = 'mysql:dbname=subcall;host=localhost;charset=utf8';
	$user = 'root';
	$password = 'kcsf';
	$dbh = new PDO($dsn,$user,$password);
	$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	// 送ったフレンド申請
	// 送ったフレンド申請の数を取得
	$sql = 'SELECT count(friend_number) FROM friendlist WHERE friend_number=? and flag=false';

	$stmt = $dbh->prepare($sql);
	$data[] = $user_num;
	$stmt->execute($data);

	$rec = $stmt->fetch(PDO::FETCH_ASSOC);

	$count_send = $rec['count(friend_number)'];

	print '送ったフレンド申請：';
	print $count_send.'件';

	if($count_send > 0){
		print '<a href="friend_get.php">申請の詳細へ</a>';
	}

	print '</br>';


	// 届いたフレンド申請
	// 届いたフレンド申請の数を取得
	$sql = 'SELECT count(user_number) FROM friendlist WHERE user_number=? and flag=false';

	$stmt = $dbh->prepare($sql);
	// $data[]は不要
	$stmt->execute($data);

	$rec = $stmt->fetch(PDO::FETCH_ASSOC);

	$count_get = $rec['count(user_number)'];

	print '届いたフレンド申請：';
	print $count_get.'件';

	if($count_get > 0){
		print '<a href="friend_get.php">登録の可否へ(画面未作成)</a>';
	}

	print '</br>';


	// フレンド数
	// フレンドの数を取得
	$sql = 'SELECT count(user_number) FROM friendlist WHERE user_number=? and flag=true';

	$stmt = $dbh->prepare($sql);
	// $data[]は不要
	$stmt->execute($data);

	$dbh = null;

	$rec = $stmt->fetch(PDO::FETCH_ASSOC);

	$count_user = $rec['count(user_number)'];

	print 'フレンド数：　';
	print $count_user;
	print '　／　１０';
	print '<a href="friend_list.php">フレンドリストへ(画面未作成)</a>';
	print '</br>';

?>
	<!--フレンド申請、指定の名前を検索する-->
	<form method='POST' action="friend_search.php" enctype="multipart/form-data">
		<div class="form_title">
			<label for="name" class="form_name">フレンドを探す</label>
		</div>
        <input type="text" name="name" id="name" size="30" maxlength="20" placeholder="フレンド名" autocomplete="off">
        <br>

        <div>
			<button type="submit">検索(画面未作成）</button>
        </div>
	</form>

	<a href="../index.php">トップ画面へ</a>
<?php
}
?>
</body>
</html>
