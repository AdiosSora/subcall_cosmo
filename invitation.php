<?php
//session_start();
//session_regenerate_id(true);

//$login_flg=isset($_SESSION['bool']);
// if($login_flg=='true'){//ログイン時の処理
  // $user_num = $_SESSION['regist_number'];
  // $hostName =$_SESSION['regist_name'];
  include('./account/db/dbConnecter.php');

  if(isset($_POST['inv_name'])){//招待ボタンが押された判定

    $InvName=$_POST['inv_name'];
    $host_name=$_POST['host_name'];
    $ROOMid=$_POST['ROOMID'];
    $user_num=$_POST['inv_num'];

    $dbh = get_DBobj();
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $sql='Insert Into invitation(host_name,inv_name,room_name) values(?,?,?);';
    $stmt = $dbh->prepare($sql);
    $data[]=$host_name;
    $data[]=$InvName;
    $data[]=$ROOMid;
    $stmt->execute($data);
    $rec=NULL;
  }
  else{//最初の訪問

    $ROOMid=$_GET['ROOMname'];
    $host_name=$_GET['hostname'];
    $user_num=$_GET['usernum'];

    $dbh = get_DBobj();
    $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $sql='DELETE FROM invitation WHERE host_name=?';
    $stmt = $dbh->prepare($sql);
    $data3[]=$host_name;
    $stmt->execute($data3);

  }

?>
  <table border="1">
    <tr>
      <th>会員番号</th>
      <th>会員名</th>
      <th>招待</th>
    </tr>
    <?php
    $sql = 'SELECT number, name  FROM account
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


    while(true){
      $rec = $stmt->fetch(PDO::FETCH_ASSOC);
      if($rec == false){
        break;
      }

      $resultName=$rec['name'];
      print '<tr>';
      print '<form method="post" action="invitation.php">';
      print '<input type="hidden" name="inv_num" value="'.$user_num.'">';
      print '<input type="hidden" name="inv_name" value="'.$rec['name'].'">';
      print '<input type="hidden" name="host_name" value="'.$host_name.'">';
      print '<td>'.$rec['number'].'</td>';
      print '<td>'.$rec['name'].'</td>';
      print '<input type="hidden" name="ROOMID" value="'.$ROOMid.'">';
      print '<td align="center">';

      $sql='SELECT host_name from invitation where host_name=:HOSTname AND inv_name=:INVname;';
      $stat = $dbh->prepare($sql);
      $stat->execute(array("HOSTname"=>$host_name,
                          "INVname"=>$resultName));
      $result = $stat->fetch(PDO::FETCH_ASSOC);
      if($result==false){
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




// flag=true で自身以外の番号と名前を取得
$dbh = null;
?>
