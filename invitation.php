<?php
session_start();
session_regenerate_id(true);

$rogin_flg=isset($_SESSION['bool']);

if($rogin_flg=='true'){//ログイン時の処理
  $user_num = $_SESSION['regist_number'];
  $hostName =$_SESSION['regist_name'];
  include('./account/db/dbConnecter.php');
  $dbh = get_DBobj();
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  if(isset($_POST['inv_name'])){//招待ボタンが押された判定
    $InvName=$_POST['inv_name'];
    $HostName=$_POST['host_name'];
    $ROOMid=$_POST['ROOMID'];

    $sql='Insert Into invitation(host_name,inv_name,room_name) values(?,?,?);';
    $stmt = $dbh->prepare($sql);
    $data[]=$HostName;
    $data[]=$InvName;
    $data[]=$ROOMid;
    $stmt->execute($data);

    $sql='UPDATE account SET invFlag=1 WHERE name=?;';
    $stmt = $dbh->prepare($sql);
    $data2[]=$InvName;
    $stmt->execute($data2);
  }
  else{//最初の訪問
    $ROOMid=$_GET['ROOMname'];
    $sql='UPDATE account SET invFlag=0;';
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
  }

  $sql = 'SELECT number, name ,invFlag FROM account
          WHERE (number IN(
          SELECT user_number FROM friendlist
          WHERE flag=true AND (user_number='.$user_num.' OR friend_number='.$user_num.')
        ) OR number IN(
          SELECT friend_number FROM friendlist
          WHERE flag=true AND (user_number='.$user_num.' OR friend_number='.$user_num.')
        )) AND number NOT LIKE '.$user_num.'
          ORDER BY number';

  $stmt = $dbh->prepare($sql);
  $stmt->execute();

  $dbh = null;
  ?>
  <table border="1">
    <tr>
      <th>会員番号</th>
      <th>会員名</th>
      <th>招待</th>
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
      print '<form method="post" action="invitation.php">';
      print '<input type="hidden" name="inv_num" value="'.$rec['number'].'">';
      print '<input type="hidden" name="inv_name" value="'.$rec['name'].'">';
      print '<input type="hidden" name="host_name" value="'.$hostName.'">';
      print '<input type="hidden" name="ROOMID" value="'.$ROOMid.'">';

      print '<td align="center">';

      if($rec['invFlag']==0){
        print '<input type="submit" value="招待" >';
      }
      else{
        print '招待済み';
      }

      print '</form>';
      print '</td>';
      print '</tr>';
      }
  print '</table>';
}
else{
  print "ログインしてフレンド機能開放";
}

// flag=true で自身以外の番号と名前を取得

?>
