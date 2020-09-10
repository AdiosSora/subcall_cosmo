<!DOCTYPE html>
<html lang="ja">
<head>
<title>フレンド - Stable </title>
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
                print '<a class="alert button z-depth-1 modal-trigger" href="#modal_friend_send">詳細</a>';
  							print '</form></div>';

                // friendlist から条件に合う番号の名前を account から取得
                $sql = 'SELECT number,name FROM account WHERE number IN (
                  SELECT user_number FROM friendlist where friend_number=? and flag=false)';

                $stmt = $dbh->prepare($sql);
                $data_friendlist[] = $user_num;
                $stmt->execute($data_friendlist);
                ?>

                <div id="modal_friend_send" class="modal">
                  <div class="modal-content">
                    <h4>申請済みリスト</h4>
                <table border="1">
                  <tr>
                    <th>会員番号</th>
                    <th>会員名</th>
                    <th></th>
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
                  print '<form method="post" name="friend_send_form'.$rec['number'].'" action="friend_get_done.php">';
                  print '<input type="hidden" name="get_done_num" value="'.$rec['number'].'">';
                  print '<input type="hidden" name="get_done_name" value="'.$rec['name'].'">';
                  print '<td style="text-align:right">';
      					  print '<a class="waves-effect waves-light btn modal-trigger" href="javascript:friend_send_form'.$rec['number'].'.submit()">申請取り下げ</a>';
                  print '</form>';
                  print '</td>';
                  print '</tr>';
                  }
                  print '</table>';
                  ?>
                  </div>
                  <div class="modal-footer">
                    <a href="#!" class="modal-close waves-effect waves-green btn-flat">戻る</a>
                  </div>
                  </div>
                <?php
							}


							// 届いたフレンド申請
							// 届いたフレンド申請の数を取得
							$sql = 'SELECT count(user_number) FROM friendlist WHERE user_number=? and flag=false';

							$stmt = $dbh->prepare($sql);
							// $data[]は不要
							$stmt->execute($data);

							$rec = $stmt->fetch(PDO::FETCH_ASSOC);

							$count_get = $rec['count(user_number)'];

							if($count_get > 0){
                print '<div id="info_alert_getfriend" class="alert success">';
  							print '<form method="post" action="friend_add.php" style="text-align:center;">';
  							print '届いたフレンド申請：';
  							print $count_get.'件　　　';
								print '<input type="hidden" name="count_friend" value="'.$count_user.'">';
                print '<a class="alert button z-depth-1 modal-trigger" href="#modal_friend_get">詳細</a>';
                print '</div>';
  							print '</form>';
                ?>
                <div id="modal_friend_get" class="modal">
                  <div class="modal-content">
                    <?php
                  	$flag = 0;
                    // friendlist から条件に合う番号の名前を account から取得
                    $sql = 'SELECT number,name FROM account WHERE number IN (
                      SELECT friend_number FROM friendlist where user_number=? and flag=false)';

                  	$stmt = $dbh->prepare($sql);
                  	$data_friendget[] = $user_num;
                  	$stmt->execute($data_friendget);

                  	?>
                    <h4>受取申請一覧</h4>
                  	<table border="1">
                      <tr>
                        <th>会員番号</th>
                        <th>会員名</th>
                  			<th>フレンド数</th>
                  			<th></th>
                  			<th></th>
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
                  		print '<form method="post" name="friend_confirm_form'.$rec['number'].'" action="friend_add_check.php">';
                  		print '<input type="hidden" name="add_num" value="'.$rec['number'].'">';
                  		print '<input type="hidden" name="add_name" value="'.$rec['name'].'">';
                  		print '<td style="text-align:right;">';
                  		if($count_user < 10){
                  			// 自身のフレンドが上限に達していない場合
                  			if($rec_count['count(user_number)'] < 10){
                  				// 相手のフレンドが上限に達していない場合
                          print '<input type="submit" name="add_yes" value="許可" style="margin:5px;"></input>';
                  			}else{
                  				// 相手のフレンドが上限に達している場合
                  				print '許可できません。';
                  				$flag = 1;
                  			}
                  		}else{
                  			// 自身のフレンドが上限に達している場合
                  			print '許可できません。';
                  			$flag = 2;
                  		}

                      print '<input type="submit" name="add_no" value="拒否" style="margin:5px;"></input>';
                  		print '</td>';
                  		// print '<td>';
                  		// if($flag == 0){
                  		// 	print '許可・不可できます。';
                  		// }else{
                  		// 	if($flag == 1){
                  		// 		print '相手のフレンドが上限に達しているため、許可できません。';
                  		// 	}else{
                  		// 		print '自身のフレンドが上限に達しているため、許可できません。';
                  		// 	}
                  		// }
                  		// print '</td>';
                  		print '</tr>';
                  		print '</form>';

                  		$flag = 0;	// フラグの初期化
                  		}

                  	print '</table>';
                    print '</br>';
                    ?>
                  </div>
                  <div class="modal-footer">
                    <a href="#!" class="modal-close waves-effect waves-green btn-flat">戻る</a>
                  </div>
                </div>
              <?php
							}

							// フレンド数
            ?>
						<form class="col s12" name="friend_serch_form" method='POST' action="friend_search.php" enctype="multipart/form-data">
							<div class="form_title col s12">
								<label for="name" class="form_name">フレンドを探す</label>
							</div>
              <div class="col s9">
		            <input type="text" name="search_name" id="name" size="30" maxlength="20" placeholder="フレンド名" autocomplete="off">
              </div>
              <div class="col s3">
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
                  print '<a class="waves-effect waves-light btn modal-trigger" href="javascript:friend_delete_form'.$friend_from_count.'.submit()" style="margin:5px;">解除</a>';
                  print '<a href="#!" class="modal-close waves-effect waves-light btn modal-trigger" style="background-color:#dddddd;color:#111111;margin:5px;">戻る</a>';
                  print '</div>';
      					  print '</form>';

                  print '</div>';
                  $friend_from_count += 1;
                  }
              print '</tbody></table>';
						}
						?>
            <a class="waves-effect waves-light2 btn-large" href="../profile/profile.php" style="background-color:#dddddd;color:#111111;margin:5px;">戻る</a>
				</div>
			</div>
		</div>
	</div>
</main>
<?php include('../../footer.php'); ?>
</body>
</html>
