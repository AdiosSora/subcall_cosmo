<!--フレンド検索の結果-->

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
	  // 変数の定義、初期化
		$user_num = $_SESSION['regist_number'];    	// ユーザー番号取得
	  $search_num = $_POST['search_num'];   // 申請する相手番号取得
	  $search_name = $_POST['search_name'];   // 申請する相手名取得

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

  // すでに申請されているか確認
	$sql_add = 'SELECT count(user_number) FROM friendlist
					WHERE flag=false AND user_number=? AND friend_number=?';

	$stmt_add = $dbh->prepare($sql_add);
	$data[] = $user_num;
	$data[] = $search_num;
	$stmt_add->execute($data);

	$rec_add = $stmt_add->fetch(PDO::FETCH_ASSOC);

  $dbh = null;

	if($rec_add['count(user_number)'] >0){
	   // すでに相手から申請されている、friend_add_check.php に飛ばせるようにする
   	print 'すでに　'.$search_name.'　様から申請されています。'.'<br />';
	  print '申請を許可しますか？'.'<br />';
	  print '<form method="post" action="friend_add_check.php">';
   	print '<input type="hidden" name="add_num" value="'.$search_num.'">';
		print '<input type="hidden" name="add_name" value="'.$search_name.'">'.'</br>';
	  print '<input type="submit" class="waves-effect waves-light" name="add_yes" value="許可">';
    print '<input type="submit" class="waves-effect waves-light" name="add_no" value="不可">';
	 	print '<button type="button" onclick="history.back()" value="no">戻る</button>';
	  print '</form>';

 	}
	else
	{
	   // それ以外
	   print '以下の方に申請します。'.'<br />';
	   print '<form method="post" name="friend_search_checkform" action="friend_search_done.php">';
	   print '会員番号：'.$search_num;
	   print '　　会員名：'.$search_name;
	   print '<input type="hidden" name="search_done_num" value="'.$search_num.'">';
	   print '<input type="hidden" name="search_done_name" value="'.$search_name.'">'.'</br>';
		 print '<a name="search_done" class="waves-effect waves-light btn" href="javascript:friend_search_checkform.submit()">申請する</a>';
	   print '</form>';

	 }
	 print '</br>';

}
?>
<a href="friend.php" class="waves-effect waves-light btn-large grey darken-1">戻る</a>
</div>
</div>
</div>
</div>
</main>
<?php include('../../footer.php'); ?>
</body>
</html>
