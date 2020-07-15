function login_check(){
  session_start();
  if($_SESSION['bool']){
    submit();
  }
  else{
    print('<span style="color:black !important;">ユーザ名またはパスワードが間違っています</span>');
  }
}
