<!--届いたフレンド申請に対して行動の完了-->
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
// 不正に入ったかチェック
else if(isset($_POST['add_done_num']) == false)
{
  header('Location: friend_ng.php');
  exit();
}
else
{
  // 変数の定義
  $user_num = $_SESSION['regist_number'];    	// ユーザー番号取得
	$user_name = $_SESSION['regist_name'];    	// ユーザー名取得
	$add_done_num = $_POST['add_done_num'];		// 選択した会員番号取得
  $add_done_name = $_POST['add_done_name'];   // 選択した名前取得

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

	// 悲観的排他制御の開始
	$dbh->beginTransaction();

	// すでに退会しているかチェック
	$sql_account = 'SELECT name FROM account WHERE number=?
									FOR UPDATE';

	$stmt_account = $dbh->prepare($sql_account);
	$data_account[] = $add_done_num;
	$stmt_account->execute($data_account);

	$rec_account = $stmt_account->fetch(PDO::FETCH_ASSOC);


	//テスト用、(x)秒待機
	// sleep(3);

	if($rec_account['name'] == false)
	{
		// すでに退会している場合
		print $add_done_name.'様はすでに退会しています。'.'<br />';

	}
	else
	{
		// 退会していない場合
		// 登録する相手のフレンド数取得
		$sql_count_y = 'SELECT count(user_number) FROM friendlist
						WHERE (user_number=? or friend_number=?) and flag=true
						FOR UPDATE';

		$stmt_count_y = $dbh->prepare($sql_count_y);
		$data_count_y[] = $add_done_num;
		$data_count_y[] = $add_done_num;
		$stmt_count_y->execute($data_count_y);

		$rec_count_y = $stmt_count_y->fetch(PDO::FETCH_ASSOC);

		// 自身のフレンド数取得
		$sql_count_m = 'SELECT count(user_number) FROM friendlist
						WHERE (user_number=? or friend_number=?) and flag=true
						FOR UPDATE';

		$stmt_count_m = $dbh->prepare($sql_count_m);
		$data_count_m[] = $user_num;
		$data_count_m[] = $user_num;
		$stmt_count_m->execute($data_count_m);

		$rec_count_m = $stmt_count_m->fetch(PDO::FETCH_ASSOC);

		if($rec_count_y['count(user_number)'] < 10 &&
				$rec_count_m['count(user_number)'] < 10)
		{
			// 登録処理中に、自分・相手がフレンド上限に達していない場合
			// 更新処理中にすでに更新されていないかチェック
			$sql_check = 'SELECT count(user_number) FROM friendlist
							WHERE user_number in(?,?) AND friend_number in(?,?) AND flag=false
							FOR UPDATE';

			$stmt_check = $dbh->prepare($sql_check);
			$data_check[] = $add_done_num; // 申請する相手番号
		  $data_check[] = $user_num;   // 申請した（自身の）番号
			$data_check[] = $add_done_num; // 申請する相手番号
		  $data_check[] = $user_num;   // 申請した（自身の）番号
			$stmt_check->execute($data_check);

			$rec = $stmt_check->fetch(PDO::FETCH_ASSOC);

			if($rec['count(user_number)'] == 0){
				// 相手が先に更新した（申請を取り下げた）場合
				if(isset($_POST['add_done_yes']) == true)
				{
					// 許可を押していた場合
					print '申請の許可の処理中に、'.$add_done_name.'様が申請を取り下げたため、処理を中断しました。'.'</br>';
				}
				else if(isset($_POST['add_done_no']) == true)
				{
					// 不可を押していた場合
					print $_SESSION['regist_name'];
					print '様に届いた申請を却下しました'.'</br>';
				}
			}else{
				// 自身が先に更新した場合
				if(isset($_POST['add_done_yes']) == true)
			 	{
			    // フレンド申請を許可する場合
			    // friendlist から条件に合う行を更新
			    $sql = 'UPDATE friendlist SET flag=true
			            WHERE user_number=? and friend_number=? AND flag=false';

			  	$stmt = $dbh->prepare($sql);
			    $data[] = $user_num;   // 申請された（自身の）番号
			    $data[] = $add_done_num; // 申請が来た（相手の）番号
			  	$stmt->execute($data);

					print $_SESSION['regist_name'];
				 	print '様に届いた申請を許可しました'.'</br>';
					print '会員番号：'.$add_done_num;
				  print '　　会員名：'.$add_done_name.'</br>';
				 	print '<br />';
				}
				else if(isset($_POST['add_done_no']) == true)
				{
					// フレンド申請を不可する場合
			    // friendlist から条件に合う行を削除
			    $sql = 'DELETE FROM friendlist
			            WHERE user_number=? and friend_number=? AND flag=false';

			  	$stmt = $dbh->prepare($sql);
			    $data[] = $user_num;   // 申請された（自身の）番号
			    $data[] = $add_done_num; // 申請が来た（相手の）番号
			  	$stmt->execute($data);

					print $_SESSION['regist_name'];
					print '様に届いた申請を却下しました'.'</br>';
					print '会員番号：'.$add_done_num;
					print '　　会員名：'.$add_done_name.'</br>';
					print '<br />';
				}
			}
		}
		else
		{
			// 登録処理中に、自分か相手がフレンド上限に達した場合
			if(isset($_POST['add_done_yes']) == true)
			{
				// 「許可」ボタンが押された
				if($rec_count_y['count(user_number)'] >= 10 && $rec_count_m['count(user_number)'] >= 10)
				{
					// 自分・相手ともにフレンド上限に達した場合
					print '登録処理中に、'.$add_done_name.'様（相手）と'.$user_name.'様（ご自身）がフレンド上限に達したため、処理を中断しました。'.'</br>';
				}
				else if($rec_count_y['count(user_number)'] >= 10)
				{
					// 相手がフレンド上限に達した場合
					print '登録処理中に、'.$add_done_name.'様がフレンド上限に達したため、処理を中断しました。'.'</br>';
				}
				else if($rec_count_m['count(user_number)'] >= 10)
				{
					// 自身がフレンド上限に達した場合
					print '登録処理中に、'.$user_name.'様がフレンド上限に達したため、処理を中断しました。'.'</br>';
				}
			}
			else
			{
				// 「不可」ボタンが押された
				// friendlist から条件に合う行を削除
				$sql = 'DELETE FROM friendlist
								WHERE user_number=? and friend_number=? AND flag=false';

				$stmt = $dbh->prepare($sql);
				$data[] = $user_num;   // 申請された（自身の）番号
				$data[] = $add_done_num; // 申請が来た（相手の）番号
				$stmt->execute($data);

				print $_SESSION['regist_name'];
				print '様に届いた申請を却下しました'.'</br>';
				print '会員番号：'.$add_done_num;
				print '　　会員名：'.$add_done_name.'</br>';
				print '<br />';
			}
		}
	}

	// 悲観的排他制御の終了
	$dbh -> commit();

  $dbh = null;
}
?>
<a href="friend.php">フレンド画面へ</a></br>
<a href="../../index.php">トップ画面へ</a>
</body>
</html>
