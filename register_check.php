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
$regist_pass2=$_POST['pass2']; //前の画面から入力値を受け取り、$regist_pass2に格納

$regist_name=htmlspecialchars($regist_name,ENT_QUOTES,'UTF-8'); //文字列に変換（セキュリティ対策）
$regist_pass=htmlspecialchars($regist_pass,ENT_QUOTES,'UTF-8'); //文字列に変換（セキュリティ対策）
$regist_pass2=htmlspecialchars($regist_pass2,ENT_QUOTES,'UTF-8'); //文字列に変換（セキュリティ対策）

//$regist_nameがカラならエラーメッセージを表示する
//$regist_nameが入力されていれば、$regist_nameを表示する
if($regist_name==''){
  print 'アカウント名が入力されていません。<br />';
}
else
{
  print 'アカウント名：';
  print $regist_name;
  print '<br />';
}

//$regist_passがカラならエラーメッセージを表示する
if($regist_pass==''){
  print 'パスワードが入力されていません。<br />';
}

//$regist_pass、$regist_pass2が一致しなければ、エラーメッセージを表示する
if($regist_pass!=$regist_pass2){ //もしパスワード1とパスワード2の値が異なるなら
  print 'パスワードが一致しません。<br />';
}

//$regist_name、$regist_pass、$regist_pass2がカラなら、または、$regist_pass、$regist_pass2が一致しなければ、戻るボタンのみを表示する
//入力項目が適切なら、戻るボタンとOKボタンを表示する。
if($regist_name==''|| $regist_pass=='' || $regist_pass2=='' || $regist_pass!=$regist_pass2){
  print '<form>';
  print '<input type="button" onclick="history.back()" value="戻る">';
  print '<form>';
}
else
{
  $regist_pass=md5($regist_pass); //パスワードをMD5規約に則って32桁のランダム値に変換
  print '<form method="post" action="register_check_done.php">';
  print '<input type="hidden" name="name" value="'.$regist_name.'">'; //'<input type="hidden" name="name" value="'と$regist_nameをドットで連結
  print '<input type="hidden" name="pass" value="'.$regist_pass.'">'; //hiddenにすることで画面に表示することなく次の画面に値を引き渡せる
  print '<br />';
  print '<input type="button" onclick="history.back()" value="戻る">';
  print '<input type="submit" value="OK">';
  print '</form>';
}
?>
</body>
</html>
