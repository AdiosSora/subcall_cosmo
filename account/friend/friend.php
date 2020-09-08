

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
        <div class="row">
          <div class="col offset-s2 s8 center">
						<!--フレンド申請、指定の名前を検索する-->
						<?php
						include('../db/dbConnecter.php');
						if(isset($_SESSION['bool']) == false)
						{
              header('Location: /account/login/login.php');
              exit();
						}
						else
            ?>
            <?php
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


							if($count_send > 0){
  							print '<div id="info_alert_sendfriend" class="alert info"><form method="post" action="friend_get.php">';
  							print '送ったフレンド申請：';
  							print $count_send.'件　　　';
								print '<input type="hidden" name="count_friend" value="'.$count_user.'">';
								print '<input type="submit" name="get" class="alert button z-depth-1" value="詳細">';
  							print '</form></div>';
							}


							// 届いたフレンド申請
							// 届いたフレンド申請の数を取得
							$sql = 'SELECT count(user_number) FROM friendlist WHERE user_number=? and flag=false';

							$stmt = $dbh->prepare($sql);
							// $data[]は不要
							$stmt->execute($data);

							$rec = $stmt->fetch(PDO::FETCH_ASSOC);

							$count_get = $rec['count(user_number)'];

							$dbh = null;

							if($count_get > 0){
                print '<div id="info_alert_getfriend" class="alert success">';
  							print '<form method="post" action="friend_add.php" style="text-align:center;">';
  							print '届いたフレンド申請：';
  							print $count_get.'件　　　';
								print '<input type="hidden" name="count_friend" value="'.$count_user.'">';
								print '<input type="submit" name="add" class="alert button z-depth-1" value="確認">';
                print '</div>';
  							print '</form>';
							}

							// フレンド数
            ?>
						<form class="col s12" name="friend_serch_form" method='POST' action="friend_search.php" enctype="multipart/form-data">
							<div class="form_title col s12">
								<label for="name" class="form_name">フレンドを探す</label>
							</div>
              <div class="col s10">
		            <input type="text" name="search_name" id="name" size="30" maxlength="20" placeholder="フレンド名" autocomplete="off">
              </div>
              <div class="col s2">
                <a class="waves-effect waves-light btn-large" id="btn" href="javascript:friend_serch_form.submit()">検索</a>
              </div>
						</form>
            <?php
							print 'フレンド数：　';
							print $count_user;
							print '　／　10　　';
						?>

              <?php
              // DB接続(mysql, xampp)
              $dbh = get_DBobj();
              $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

              // flag=true で自身以外の番号と名前を取得
              $sql = 'SELECT number,name,image FROM account
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
              <table border="1" style="margin:40px 0;">

                <thead>
                  <tr>
                      <th style="text-align:center;">会員番号</th>
                      <th style="text-align:center;">アイコン</th>
                      <th style="text-align:center;">名前</th>
                      <th style="text-align:center;"></th>
                  </tr>
                </thead>
                <tbody>
                <?php
                $friend_from_count = 1;
                while(true){
                  $rec = $stmt->fetch(PDO::FETCH_ASSOC);

                  if($rec == false){
                    break;
                  }
                  print '<tr>';
                  print '<td style="text-align:center;">No. '.$rec['number'].'</td>';
                  $img = $rec['image'];
                  if($img!=null){
                    print'<td><img src="'.$img.'" style="width:64px;"></td>';
                  }else{
                    print'<td style="text-align:center;"><img src="../../images/default_icon.png" style="width:48px";></td>';
                  }
                  print '<td style="text-align:center;"><strong>'.$rec['name'].'</strong></td>';
                  print '<input type="hidden" name="list_num" value="'.$rec['number'].'">';
                  print '<input type="hidden" name="list_name" value="'.$rec['name'].'">';
                  print '<td style="text-align:right;">';
                  print '<a class="waves-effect waves-light btn modal-trigger" href="#modal'.$friend_from_count.'" style="background-color:#dddddd;color:#111111;margin:5px;">解除</a>';
                  print '</td>';
                  print '</tr>';
                  print '<div id="modal'.$friend_from_count.'" class="modal" style="border: none;">';
                  print '<div class="modal-content">';
                  print '<h4>フレンドを解除しますか？</h4>';
      					  // 変数の定義、初期化
      						$user_num = $_SESSION['regist_number'];    	// ユーザー番号取得
      					  $list_num = $rec['number'];   // フレンド削除する会員番号取得
      					  $list_name = $rec['name'];   // フレンド削除する会員名取得
      					  print '<form method="post" name="friend_delete_form'.$friend_from_count.'" action="friend_list_done.php">';
      					  print '会員番号：'.$list_num;
      					  print '　　会員名：'.$list_name;
      					  print '<input type="hidden" name="list_done_num" value="'.$list_num.'">';
      					  print '<input type="hidden" name="list_done_name" value="'.$list_name.'">'.'</br>';
                  print '<div class="modal-footer">';
      					  print '<a class="waves-effect waves-light btn modal-trigger" href="javascript:friend_delete_form'.$friend_from_count.'.submit()">解除';
                  print '<a href="#!" class="waves-effect waves-light btn modal-trigger" style="background-color:#dddddd;color:#111111;margin:5px;">戻る</a>';
                  print '</div>';
      					  print '</form>';

                  print '</div>';
                  $friend_from_count += 1;
                  }
              print '</tbody></table>';
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
<script>
  $(document).ready(function(){
    $('.modal').modal();
  });
</script>
</html>
