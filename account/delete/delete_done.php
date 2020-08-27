<?php
try
{
  session_start();
  $_SESSION=array();
  include('../db/dbConnecter.php');
  if(isset($_COOKIE[session_name()]) == true)
    {
    	setcookie(session_name(),'',time()-42000,'/');
    }
    session_destroy();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<title>退会完了</title>
</head>
<body>

<?php
    $number = $_POST['number'];


  	$dbh = get_DBobj();
  	$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  	$sql = 'DELETE FROM account WHERE number=?';
  	$stmt = $dbh->prepare($sql);
  	$data[] = $number;
  	$stmt->execute($data);

    $sql = 'DELETE FROM friendlist WHERE user_number=? OR friend_number=?';
  	$stmt = $dbh->prepare($sql);
  	$data[] = $number;
  	$stmt->execute($data);

  	$dbh = null;

}
catch (Exception $e)
{
	print'ただいま障害により大変ご迷惑をお掛けしております。';
	exit();
}

?>

削除しました。<br />
<br />
<a href="../../index.php">戻る</a>

</body>
</html>