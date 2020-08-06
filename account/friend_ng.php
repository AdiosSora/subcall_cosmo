<!--不正にページを読み込んだ方が行き着く画面-->
<?php
session_start();
session_regenerate_id(true);
if(isset($_SESSION['bool']) == false)
{
	print 'ゲストユーザは機能が制限されています。<br />';
	print '<a href="../index.php">トップ画面へ</a>';
	exit();
}
else
{
	print $_SESSION['regist_name'];
	print '様ログイン中<br />';
	print '<br />';
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>フレンド機能</title>
</head>
<body>
	不正な動作のため、この機能は使えません。</br>
<form>
  <input type="button" onclick="history.back()" value="戻る">
</form>

</body>
</html>
