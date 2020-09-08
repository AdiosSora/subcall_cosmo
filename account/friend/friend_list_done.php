<!--現在のフレンドリストの削除完了-->
<?php
session_start();
session_regenerate_id(true);
include('../db/dbConnecter.php');
if(isset($_SESSION['bool']) == false)
{
	header('Location: /account/login/login.php');
	exit();
}
else
{
  // 変数の定義、初期化
	$user_num = $_SESSION['regist_number'];    	// ユーザー番号取得
  $list_done_num = $_POST['list_done_num'];   // フレンド削除する会員番号取得
  $list_done_name = $_POST['list_done_name'];   // フレンド削除する会員名取得
  // DB接続(mysql, xampp)
	$dbh = get_DBobj();
	$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  // friendlist から条件に合う行を削除
	// ない場合（相手が先に削除した）は、該当する0行を更新（実質更新されないためDBに影響なし）
  $sql = 'DELETE FROM friendlist WHERE flag=true
          AND user_number IN (?,?)
          AND friend_number IN (?,?)';

  $stmt = $dbh->prepare($sql);
  $data[] = $user_num;   // 自身の番号
  $data[] = $list_done_num; // フレンド削除する番号
  $data[] = $user_num;   // 自身の番号
  $data[] = $list_done_num; // フレンド削除する番号

  $stmt->execute($data);

  $dbh = null;
	header('Location: ../friend/friend.php');
}
?>
