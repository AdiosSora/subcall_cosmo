<!--届いたフレンド申請に対して行動の完了-->

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>フレンド機能</title>
<?php
  include('../../header.php');
?>
</head>
<body>
  <?php include('../../nav.php'); ?>
	<?php
	include('../db/dbConnecter.php');
	if(isset($_SESSION['bool']) == false)
	{
		header('Location: /account/login/login.php');
		exit();
	}else
	{
	  // 変数の定義
	  $user_num = $_SESSION['regist_number'];    	// ユーザー番号取得
		$user_name = $_SESSION['regist_name'];    	// ユーザー名取得
		$search_done_num = $_POST['search_num'];		// 選択した会員番号取得
	  $search_done_name = $_POST['search_name'];   // 選択した名前取得

	?>
		<main>
    <div class="container">
      <div class="section no-pad-bot">
        <div class="row" style="margin:10vh 0;">
          <div class="col offset-s2 s8 center">
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
	$data_account[] = $search_done_num;
	$stmt_account->execute($data_account);

	$rec_account = $stmt_account->fetch(PDO::FETCH_ASSOC);

	if($rec_account['name'] == false)
	{
		// すでに退会している場合
		print $search_done_name.'様はすでに退会しています。'.'<br />';

	}
	else
	{
		// 退会していない場合
		// 申請する相手のフレンド数取得
		$sql_count_y = 'SELECT count(user_number) FROM friendlist
						WHERE (user_number=? or friend_number=?) and flag=true
						FOR UPDATE';

		$stmt_count_y = $dbh->prepare($sql_count_y);
		$data_count_y[] = $search_done_num;
		$data_count_y[] = $search_done_num;
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

		//テスト用、(x)秒待機
		// sleep(3);

		if($rec_count_y['count(user_number)'] < 10 &&
				$rec_count_m['count(user_number)'] < 10)
		{
			// 申請処理中に、自分・相手がフレンド上限に達していない場合
			// 更新処理中にすでに更新されていないかチェック
			$sql_check = 'SELECT count(user_number) FROM friendlist
							WHERE user_number in(?,?) AND friend_number in(?,?)
							FOR UPDATE';

			$stmt_check = $dbh->prepare($sql_check);
			$data_check[] = $search_done_num; // 申請する相手番号
			$data_check[] = $user_num;   // 申請した（自身の）番号
			$data_check[] = $search_done_num; // 申請する相手番号
			$data_check[] = $user_num;   // 申請した（自身の）番号
			$stmt_check->execute($data_check);

			$rec = $stmt_check->fetch(PDO::FETCH_ASSOC);

			if($rec['count(user_number)'] == 0){
				// 申請が重複しない場合
				// friendlist から条件に合う番号の名前を account から取得
				$sql_comit = 'INSERT INTO friendlist VALUES (?,?,false)';

				$stmt_comit = $dbh->prepare($sql_comit);
				$data_comit[] = $search_done_num; // 申請する相手番号
				$data_comit[] = $user_num;   // 申請した（自身の）番号
				$stmt_comit->execute($data_comit);

				print '<h4>申請が完了しました。</h4>';
				print '<br />';
				print '会員番号：'.$search_done_num.'　　会員名：'.$search_done_name.'</br>';
				print '</br>';
			}else{
				// 申請が重複した場合
				print '申請処理中に、'.$search_done_name.'様から申請されています。';
			}
		}
		else
		{
			// 登録処理中に、自分か相手がフレンド上限に達した場合
			if($rec_count_y['count(user_number)'] >= 10 && $rec_count_m['count(user_number)'] >= 10)
			{
				// 自分・相手ともにフレンド上限に達した場合
				print '申請処理中に、'.$search_done_name.'様（相手）と'.$user_name.'様（ご自身）がフレンド上限に達したため、処理を中断しました。'.'</br>';
			}
			else if($rec_count_y['count(user_number)'] >= 10)
			{
				// 相手がフレンド上限に達した場合
				print '申請処理中に、'.$search_done_name.'様がフレンド上限に達したため、処理を中断しました。'.'</br>';
			}
			else if($rec_count_m['count(user_number)'] >= 10)
			{
				// 自身がフレンド上限に達した場合
				print '申請処理中に、'.$user_name.'様がフレンド上限に達したため、処理を中断しました。'.'</br>';
			}
		}
	}

	// 悲観的排他制御の終了
	$dbh -> commit();

	$dbh = null;
}
?>
<a href="friend.php" class="waves-effect waves-light btn-large grey darken-1">戻る</a>
</main>
<?php include('../../footer.php'); ?>
</body>
</html>
