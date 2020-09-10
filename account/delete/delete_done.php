<!DOCTYPE html>
<html lang="ja">
<head>
<title>退会完了 - Stable</title>
<?php include('../../header.php'); ?>
</head>
<body>
  <?php include('../../nav.php'); ?>
  <?php
  try
  {
    session_start();
    $_SESSION=array();
    if(isset($_COOKIE[session_name()]) == true)
      {
      	setcookie(session_name(),'',time()-42000,'/');
      }
      session_destroy();
  ?>
  <main>
    <div class="container">
      <div class="section no-pad-bot">
        <div class="row" style="margin: 20vh 0;">
          <div class="col offset-s2 s8 center">
            <?php
                $number = $_POST['number'];


              	$dbh = get_DBobj();
              	$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

                // 悲観的排他制御の開始
                $dbh->beginTransaction();

                // すでに退会しているかチェック
                $sql_account = 'SELECT name FROM account WHERE number=?
                                FOR UPDATE';

                $stmt_account = $dbh->prepare($sql_account);
                $data_account[] = $number;
                $stmt_account->execute($data_account);

                $rec_account = $stmt_account->fetch(PDO::FETCH_ASSOC);

                //テスト用、(x)秒待機
                // sleep(3);

              	$sql = 'DELETE FROM account WHERE number=?';
              	$stmt = $dbh->prepare($sql);
              	$data[] = $number;
              	$stmt->execute($data);

                $sql = 'DELETE FROM friendlist WHERE user_number=? OR friend_number=?';
              	$stmt = $dbh->prepare($sql);
              	$data[] = $number;
              	$stmt->execute($data);

                // 悲観的排他制御の終了
                $dbh -> commit();

              	$dbh = null;

            }
            catch (Exception $e)
            {
            	print'ただいま障害により大変ご迷惑をお掛けしております。';
            	exit();
            }

            ?>
            退会が完了しました。<br>
            <a class="waves-effect waves-light2 btn-large" href="../../index.php" style="background-color:#dddddd;color:#111111;margin:5px;">戻る</a>
          </div>
        </div>
      </div>
    </div>
  </main>
  <?php include('../../footer.php'); ?>
</body>
</html>
