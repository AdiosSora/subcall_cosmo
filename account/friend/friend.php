

<!DOCTYPE html>
<html lang="ja">
<head>
<title>フレンド一覧</title>
<?php
  include('../../header.php');
?>
</head>
<body>
  <?php include('../../nav.php'); ?>
		<main>
    <div class="container">
      <div class="section no-pad-bot">
        <div class="row" style="margin: 10vh 0;">
          <div class="col offset-s2 s8 center">
						<?php
						include('../db/dbConnecter.php');
						if(isset($_SESSION['bool']) == false)
						{
							print 'ゲストユーザーではこの機能は使えません';
							print '<a href="../../index.php">top画面へ</a><br />';
							print '<br />';
						}
						else
						{
							// ユーザー番号取得
							$user_num = $_SESSION['regist_number'];

						?>
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
								<div class="form_title col s12">
									<label for="name" class="form_name">フレンドを探す</label>
								</div>
                <div class="col s10">
			            <input type="text" name="search_name" id="name" size="30" maxlength="20" placeholder="フレンド名" autocomplete="off">
                </div>
                <div class="col s2">
									<input type="submit" name="search" value="検索">
				        </div>
							</form>

              <?php
              // DB接続(mysql, xampp)
              $dbh = get_DBobj();
              $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

              // flag=true で自身以外の番号と名前を取得
              $sql = 'SELECT number, name FROM account
                      WHERE (number IN(
                      SELECT user_number FROM friendlist
                      WHERE flag=true AND (user_number=? OR friend_number=?)
                    ) OR number IN(
                      SELECT friend_number FROM friendlist
                      WHERE flag=true AND (user_number=? OR friend_number=?)
                    )) AND number NOT LIKE ?
                      ORDER BY number ';

              $stmt = $dbh->prepare($sql);
              $data2[] = $user_num;
              $data2[] = $user_num;
              $data2[] = $user_num;
              $data2[] = $user_num;
              $data2[] = $user_num;
              $stmt->execute($data2);

              $dbh = null;

              ?>
              <table border="1">
                <caption>フレンド一覧</caption>
                <tr>
                  <th>会員番号</th>
                  <th>会員名</th>
                  <th>削除の実行</th>
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
                  print '<form method="post" action="friend_list_check.php">';
                  print '<input type="hidden" name="list_num" value="'.$rec['number'].'">';
                  print '<input type="hidden" name="list_name" value="'.$rec['name'].'">';
                  print '<td align="center">';
                  print '<input type="submit" name="list_check" value="フレンド削除" >';
                  print '</form>';
                  print '</td>';
                  print '</tr>';
                  }
              print '</table>';
						}
						?>
            <a class="waves-effect waves-light2 btn-large" href="../../index.php" style="background-color:#dddddd;color:#111111;margin:5px;">戻る</a>
				</div>
			</div>
		</div>
	</div>
</main>
<?php include('../../footer.php'); ?>
</body>
</html>
