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
else
{
  require_once('../common.php');

	$post = sanitize($_POST);
  $search_name = $post['search_name'];
	print $_SESSION['regist_name'];
	print '様が検索した結果を表示します';
	print '<br /><br />';

  // 変数の定義、初期化
	$user_num = $_SESSION['regist_number'];    	// ユーザー番号取得
	$flag_friend = 1;		// フレンド上限フラグ

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

	// フレンド数取得(自分自身)
	$sql_friend = 'SELECT count(user_number) FROM friendlist
					WHERE (user_number=? or friend_number=?) and flag=true';

	$stmt_friend = $dbh->prepare($sql_friend);
	$data_friend[] = $user_num;
	$data_friend[] = $user_num;
	$stmt_friend->execute($data_friend);

	$rec_friend = $stmt_friend->fetch(PDO::FETCH_ASSOC);

	$count_friend = $rec_friend['count(user_number)'];

  // 入力された名前をもとに、会員番号と会員名を取得(完全一致)
  $sql_search = 'SELECT number,name FROM account WHERE name=? ';
	$stmt_search = $dbh->prepare($sql_search);
	$data_search[] = $search_name;
	$stmt_search->execute($data_search);

	$rec_search = $stmt_search->fetch(PDO::FETCH_ASSOC);

	print '現在のフレンド数：　';
	print $count_friend;
	print '　／　10　　';
	print '<br /><br />';

	if($count_friend >= 10){
		$flag_friend = 0;
		print '<form method="post" action="friend_list.php">';
		print '※'.$_SESSION['regist_name'];
		print '様のフレンド数が上限に達しているためフレンド申請はできません。※　　';
		print '<input type="submit" name="list" value="フレンドリストへ">';
		print '</form>';
		print '<br />';
	}
  if($rec_search == false){
		// 入力された名前がない場合
    print $search_name;
    print '　は登録されていません。'.'<br />';
  }else{
		// 入力された名前がある場合
    print '検索結果一覧'.'<br /><br />';
    while(true){

      if($rec_search == false){
        break;
      }

      print '<form method="post" action="friend_search_check.php">';
      print '会員番号：'.$rec_search['number'];
      print '　　会員名：'.$rec_search['name'];

			// 一致した入力された名前のフレンド登録件数を取得
		  $sql_count = 'SELECT count(user_number) FROM friendlist
											WHERE (user_number=? or friend_number=?) and flag=true';
			$stmt_count = $dbh->prepare($sql_count);
			$data_count[0] = $rec_search['number'];
			$data_count[1] = $rec_search['number'];

			$stmt_count->execute($data_count);

			$rec_count = $stmt_count->fetch(PDO::FETCH_ASSOC);

			// 入力された名前がすでにフレンドかを取得
			$sql_comit = 'SELECT count(user_number) FROM friendlist
											WHERE user_number IN(?,?) AND friend_number IN(?,?) AND flag=true';
			$stmt_comit = $dbh->prepare($sql_comit);
			$data_comit[0] = $rec_search['number'];
			$data_comit[1] = $user_num;
			$data_comit[2] = $rec_search['number'];
			$data_comit[3] = $user_num;

			$stmt_comit->execute($data_comit);

			$rec_comit = $stmt_comit->fetch(PDO::FETCH_ASSOC);


			print '　　フレンド数：　';
			print $rec_count['count(user_number)'];
			print '　／　10　　';

			if($rec_search['number'] == $user_num && $rec_search['name'] == $_SESSION['regist_name']){
				// 入力した名前が自分自身である場合
				print '自分自身です。';
				print '</form>';

				$rec_search = $stmt_search->fetch(PDO::FETCH_ASSOC);
			}else{
				// 入力した名前が自分自身ではない場合
				if($rec_comit['count(user_number)'] < 1){
					// フレンド同士でない場合
					if($flag_friend == 1){
						// 自身のフレンドが上限未満(申請できる)
						if($rec_count['count(user_number)'] >= 10){
							// 相手のフレンドが上限の場合、申請のボタン出さない
							print 'フレンドが上限に達しているため申請できません。';
							print '</form>';

			      	$rec_search = $stmt_search->fetch(PDO::FETCH_ASSOC);
						}else{
							// 相手のフレンドが上限に満たない場合、申請ボタン出す
		      		print '<input type="hidden" name="search_num" value="'.$rec_search['number'].'">';
		      		print '<input type="hidden" name="search_name" value="'.$rec_search['name'].'">';
		      		print '<input type="submit" name="search_check" value="フレンド申請" >'.'</br>';
		      		print '</form>';

		      		$rec_search = $stmt_search->fetch(PDO::FETCH_ASSOC);
						}
					}else{
						// 自身のフレンドが上限の場合（申請不可）
						print '</form>';
						print '</br>';

						$rec_search = $stmt_search->fetch(PDO::FETCH_ASSOC);
					}
				}else{
					// フレンド同士の場合
					print 'すでにフレンド同士です。';
					print '</form>';

					$rec_search = $stmt_search->fetch(PDO::FETCH_ASSOC);
				}
			}
    }
		$dbh = null;
  }

	print '<a href="friend.php">フレンド画面へ</a></br>';
	print '<a href="../index.php">トップ画面へ</a>';

}
?>
</body>
</html>
