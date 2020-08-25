<!--現在のフレンドリストの管理-->
<?php
session_start();
session_regenerate_id(true);
include('dbConnecter.php');
if(isset($_SESSION['bool']) == false)
{
	print 'ゲストユーザーではこの機能は使えません';
	print '<a href="../index.php">top画面へ</a><br />';
	print '<br />';
}
else if(isset($_POST['list']) == false){
	// 不正に入った際の対応
	header('Location: friend_ng.php');
	exit();
}
else
{
	print $_SESSION['regist_name'];
	print '様のフレンドを管理します';
	print '<br />';

  // 変数の定義、初期化
	$user_num = $_SESSION['regist_number'];    	// ユーザー番号取得

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>フレンド機能</title>
</head>
<body>
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
  $data[] = $user_num;
  $data[] = $user_num;
  $data[] = $user_num;
  $data[] = $user_num;
  $data[] = $user_num;
  $stmt->execute($data);

  $dbh = null;

  print 'フレンド一覧'.'</br>'.'</br>';

  while(true){

    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

    if($rec == false){
      break;
    }
    print '<form method="post" action="friend_list_check.php">';
    print '会員番号：'.$rec['number'];
    print '　　会員名：'.$rec['name'];
    print '<input type="hidden" name="list_num" value="'.$rec['number'].'">';
    print '<input type="hidden" name="list_name" value="'.$rec['name'].'">'.'</br>';
    print '<input type="submit" name="list_check" value="フレンド削除" >'.'</br>'.'</br>';
    print '</form>';
    }

	print '<a href="friend.php">フレンド画面へ</a></br>';
	print '<a href="../index.php">トップ画面へ</a>';

}
?>
</body>
</html>
