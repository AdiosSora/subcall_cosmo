<!DOCTYPE html>
<html lang="ja">
  <head>
      <meta charset="utf-8"/>
      <title>Acount regist</title>
  </head>
  <body>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="js/jquery.validate.js"></script>
      <script src="js/jquery.validate.min.js"></script>
      <script src="js/register.js"></script>

      <h1>会員登録画面</h1><br/>
      <form method="post" action="register_check.php" id="check">

          ユーザ名<br/>
          <input type="text" name="name" id="name" size="30" maxlength="20"> <br/><br/>

          パスワード<br/>
          <input type="password" name="pass" id="pass" size="30" maxlength="20"> <br/><br/>

          パスワード(確認用)<br/>
          <input type="password" name="pass2" id="pass2" size="30" maxlength="20"> <br/><br/>

          メールアドレス<br/>
          <input type="email" name="address" id="address" size="30" maxlength="50"> <br><br>

          <button type="button" onclick="history.back()">戻る</button>
          <button type="submit" name="regist" value="登録">確認</button>

      </form>
  </body>
</html>
