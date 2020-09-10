<!DOCTYPE html>
<html lang="ja">
<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js">
	</script>
	<script src="/js/jquery.validate.min.js">
	</script>
	<script src="/js/jquery.validate.min.js">
	</script>
	<script src="/js/register.js">
	</script>
	<title>会員登録確認 - Stable</title><?php include '../../header.php';
</head>
<body>
	<?php include '../../nav.php'; ?>
	<main>
		<div class="parallax-container" id="index-banner">
			<div class="container">
				<div class="section no-pad-bot">
					<div class="row">
						<div class="col col s10 offset-m1 m8 offset-m2 center" style="color:black !important;">
							<?php
	              $regist_name=$_POST['name']; //前の画面から入力値を受け取り、$regist_nameに格納
	              $regist_pass=$_POST['pass']; //前の画面から入力値を受け取り、$regist_passに格納
	              $regist_pass2=$_POST['pass2']; //前の画面から入力値を受け取り、$regist_passに格納
	              $regist_address=$_POST['address'];

	              $regist_name=htmlspecialchars($regist_name,ENT_QUOTES,'UTF-8'); //文字列に変換（セキュリティ対策）
	              $regist_pass=htmlspecialchars($regist_pass,ENT_QUOTES,'UTF-8'); //文字列に変換（セキュリティ対策）
	              $regist_address=htmlspecialchars($regist_address,ENT_QUOTES,'UTF-8');

	              if(empty($regist_name) || empty($regist_pass) || empty($regist_address)){
	                header('Location: register.php?check=empty_error');
	                exit();
	              }else if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,30}$/' ,$regist_pass)||$regist_pass != $regist_pass2){
	                header('Location: register.php?check=missmatch_error');
	                exit();
	              }else if(!preg_match("/^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/",$regist_address)){
	                header('Location: register.php?check=mailaddress_error');
	                exit();
	              }else

	              $dbh = get_DBobj();
	              $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

	              $sql = 'SELECT number FROM account WHERE name=?';
	              $stmt = $dbh->prepare($sql);
	              $data[] = $regist_name;
	              $stmt->execute($data);

	              $dbh = null;

	              $rec = $stmt->fetch(PDO::FETCH_ASSOC);

	              if($rec == false){
	              //$regist_nameが入力されていれば、$regist_nameを表示する
              ?>
							<h2 style="color:black !important;">登録情報確認</h2><br>
							<div class="form_title">
								<label class="form_name" for="name">ユーザ名</label> <input class="validate" disabled id="disabled" style="text-align:center; color:black;" type="text" value="<?php print $regist_name; ?>">
							</div><br>
							<div class="form_title">
								<label class="form_name" for="pass">パスワード</label> <input class="validate" disabled id="disabled" style="text-align:center; color:black;" type="text" value="非表示">
							</div><br>
							<div class="form_title">
								<label class="form_name" for="address">メールアドレス</label> <input class="validate" disabled id="disabled" style="text-align:center; color:black;" type="text" value="<?php print $regist_address;?>">
							</div>
							<?php print '<p>上記の内容で登録します。よろしいですか？</p>';
              $regist_pass = hash('sha256' , $regist_pass); //パスワードをMD5規約に則って32桁のランダム値に変換

					    print '<form method="post" name="ragister_check_form" action="register_check_done.php">';
					    print '<input type="hidden" id="name" name="name" value="'.$regist_name.'">'; //'<input type="hidden" name="name" value="'と$regist_nameをドットで連結
					    print '<input type="hidden" id="pass" name="pass" value="'.$regist_pass.'">';
					    print '<input type="hidden" id="address" name="address" value="'.$regist_address.'">';  //hiddenにすることで画面に表示することなく次の画面に値を引き渡せる
					    print '<br />';
					    print '<div id="button_box" style="margin: 20px;">';
					    print '<a class="waves-effect waves-light btn-large grey darken-1 btn-margin" href="register.php">戻る</a>';
					    print '<a class="waves-effect waves-light btn-large btn-margin" id="btn" href="javascript:ragister_check_form.submit()">登録</a>';
					    print '</div>';
					    print '</form>';
					  }
						else{
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
  <?php include '../../footer.php'; ?>
	</body>
</html>
