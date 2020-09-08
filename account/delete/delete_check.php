<!DOCTYPE html>
<html lang="ja">
<head>
<title>退会確認 - Stable</title>
<?php include('../../header.php'); ?>
</head>
<body>
  <?php include('../../nav.php'); ?>
  <main>
    <div class="container">
      <div class="section no-pad-bot">
        <div class="row" style="margin: 20vh 0;">
          <div class="col offset-s2 s8 center">
            <?php
            try
            {
            if(isset($_SESSION['bool']) == false)
              {
                print 'お客様はゲストユーザーか、ログインしていないため、退会はできません。'.'<br>';
                print '<a class="waves-effect waves-light2 btn-large" href="javascript:history.back();" style="background-color:#dddddd;color:#111111;margin:5px;">戻る</a>';
                print '<br />';
              }
              else
              {

                require_once('../../common.php');

                $post = sanitize($_POST);

              	$name = $post['name'];
                $pass = $post['pass'];
                $address = $post['address'];

                $regist_pass = hash('sha256' , $pass);

                include('../db/dbConnecter.php');
              	$dbh = get_DBobj();
              	$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

              	$sql = 'SELECT name FROM account WHERE name=? AND pass=? AND mail_address=?';
              	$stmt = $dbh->prepare($sql);
              	$data[] = $name;
                $data[] = $regist_pass;
                $data[] = $address;
              	$stmt->execute($data);

              	$dbh = null;

                $rec = $stmt->fetch(PDO::FETCH_ASSOC);

              	if($rec == true){
                  print'本当に退会しますか？';
                  print'<table class="centered">';
                  print'<thead><tr><td style="text-align:center;">お名前</td><td style="text-align:center;">'.$name.'</td></tr></thead>';
                  print'<thead><tr><td style="text-align:center;">メールアドレス</td><td style="text-align:center;">'.$address.'</td></tr></thead>';
                  print'</table>';
                  print'<form method="post" name="destroy_confirm_form" action="delete_done.php">';
                  print'<input type="hidden" name="number" value="'.$_SESSION['regist_number'].'">';

                  print '<a class="waves-effect waves-light2 btn-large" href="javascript:destroy_confirm_form.submit();" style="margin:5px;">退会</a>';
                  print '<a class="waves-effect waves-light2 btn-large" href="javascript:history.back();" style="background-color:#dddddd;color:#111111;margin:5px;">戻る</a>';
                	print'</form>';
                }else{
                  print 'パスワードが間違っています。'.'<br>';
                  print '<a class="waves-effect waves-light2 btn-large" href="javascript:history.back();" style="background-color:#dddddd;color:#111111;margin:5px;">戻る</a>';
                }
              }
            }
            catch (Exception $e)
            {
            	print'ただいま障害により大変ご迷惑をお掛けしております。';
            	exit();
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
