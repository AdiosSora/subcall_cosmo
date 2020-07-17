
<!DOCTYPE htmel>
<html>
<head>
  <meta charset="utf-8">
</head>
<title>Register check</title>
<body>

<?php
$regist_name=$_POST['name']; //前の画面から入力値を受け取り、$regist_nameに格納
$regist_pass=$_POST['pass']; //前の画面から入力値を受け取り、$regist_passに格納
$regist_address=$_POST['address'];

$regist_name=htmlspecialchars($regist_name,ENT_QUOTES,'UTF-8'); //文字列に変換（セキュリティ対策）
$regist_pass=htmlspecialchars($regist_pass,ENT_QUOTES,'UTF-8'); //文字列に変換（セキュリティ対策）
$regist_address=htmlspecialchars($regist_address,ENT_QUOTES,'UTF-8');

//
if(empty($regist_name) || empty($regist_pass) || empty($regist_address)){
  print'error';
  exit();
}else

  $dsn = 'mysql:dbname=subcall;host=localhost;charset=utf8';
  $user = 'root';
  $password = 'kcsf';
  $dbh = new PDO($dsn,$user,$password);
  $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

  $sql = 'SELECT name FROM account WHERE mail_address=?';
  $stmt = $dbh->prepare($sql);
  $data[] = $regist_address;
  $stmt->execute($data);

  $dbh = null;

  $rec = $stmt->fetch(PDO::FETCH_ASSOC);

  if($rec == false){
  //$regist_nameがカラならエラーメッセージを表示する
  //$regist_nameが入力されていれば、$regist_nameを表示する
    print 'ユーザ名：';
    print $regist_name;
    print '<br />';
    print '<br />';

    print 'パスワード：';
    print $regist_pass;
    print '<br />';
    print '<br />';

    print 'メールアドレス：';
    print $regist_address;
    print '<br />';
    print '<br />';
    print '上記の内容で登録します。よろしいですか？';

    $regist_pass = hash('sha256' , $regist_pass); //パスワードをMD5規約に則って32桁のランダム値に変換

    print '<form method="post" action="register_check_done.php">';
    print '<input type="hidden" name="name" value="'.$regist_name.'">'; //'<input type="hidden" name="name" value="'と$regist_nameをドットで連結
    print '<input type="hidden" name="pass" value="'.$regist_pass.'">';
    print '<input type="hidden" name="address" value="'.$regist_address.'">';  //hiddenにすることで画面に表示することなく次の画面に値を引き渡せる
    print '<br />';
    print '<button type="button" onclick="history.back()" value="戻る">戻る</button>';
    print '<button type="submit" value="登録">登録</button>';
    print '</form>';
  }else{
    //メールアドレスが重複しています。
    print'error';
  }

?>
</body>
</html>
