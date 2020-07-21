<!--開発者用、セッション破棄-->

<?php
session_start();
$_SESSION=array();
if(isset($_COOKIE[session_name()]) == true)
{
	setcookie(session_name(),'',time()-42000,'/');
}
session_destroy();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<title>セッション破棄</title>
</head>
<body>
セッションを破棄しました。<br />
<br />
<a href="../index.php">戻る</a>

</body>
</html>
