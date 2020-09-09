<!--現在のフレンドリストの削除確認-->


<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>フレンド機能</title>
<?php  include('../../header.php');?>
</head>
<body>
  <?php include('../../nav.php'); ?>
		<main>
    <div class="container">
      <div class="section no-pad-bot">
        <div class="row" style="margin:10vh 0;">
          <div class="col offset-s2 s8 center"><?php
					if(isset($_SESSION['bool']) == false)
					{
						header('Location: /account/login/login.php');
						exit();
					}
					// else if(isset($_POST['list_check']) == false){
					// 	header('Location: friend_ng.php');
					// 	exit();}
					else
					{
						print '<h3>';
						print 'フレンドを削除しますか？';
						print '</h3>';
					  // 変数の定義、初期化
						$user_num = $_SESSION['regist_number'];    	// ユーザー番号取得
					  $list_num = $_POST['list_num'];   // フレンド削除する会員番号取得
					  $list_name = $_POST['list_name'];   // フレンド削除する会員名取得
					  print '<form method="post" action="friend_list_done.php">';
					  print '会員番号：'.$list_num;
					  print '　　会員名：'.$list_name;
					  print '<input type="hidden" name="list_done_num" value="'.$list_num.'">';
					  print '<input type="hidden" name="list_done_name" value="'.$list_name.'">'.'</br>';
					  print '<input type="submit" name="list_done" value="フレンド削除" >';
					  print '<button type="button" onclick="history.back()" value="no">削除しない</button>';
					  print '</form>';
					}
					?>
				</div>
			</div>
		</div>
	</div>
</main>
<?php include('../../footer.php'); ?>
</body>
</html>
