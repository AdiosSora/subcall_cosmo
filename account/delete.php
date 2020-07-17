<!DOCTYPE html>
<html lang="ja">
<head>
<title>退会画面</title>
</head>
<body>

<form method="post" action="./delete_check.php">
  お客様のお名前、パスワードを入力してください。<br>
  <input type="text" name="name" id="name" size="30" maxlength="20" placeholder="お名前" autocomplete="off"><br>
  <input type="password" name="pass" id="pass" size="30" maxlength="20" placeholder="パスワード" autocomplete="off"><br>
	<a href="../index.php">戻る</a><br>
	<input type="submit" value="OK">
</form>

</body>
</html>
