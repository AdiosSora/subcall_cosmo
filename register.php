<!DOCTYPE html>
<html lang="ja">
  <head>
      <meta charset="utf-8"/>
      <link rel="stylesheet" href="css/register.css">
      <title>Acount regist</title>
  </head>
  <body>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="js/jquery.validate.js"></script>
      <script src="js/jquery.validate.min.js"></script>
      <script src="js/register.js"></script>


      <div class="pw-form">
          <form method="post" action="register_check.php" id="check" class="pw-form-container">
              <h1>会員登録画面</h1><br/>


              <p><input type="text" name="name" id="name" size="30" maxlength="20" placeholder="UserName"></p>

              <p><input type="password" name="pass" id="pass" size="30" maxlength="20" placeholder="Password"></p>
                 <span class="field-icon">
                   <i toggle="#password-field" class="mdi mdi-eye toggle-password"></i>
                 </span>
              <p><input type="password" name="pass2" id="pass2" size="30" maxlength="20" placeholder="Password  (check)"></p>
                 <span class="field-icon">
                   <i toggle="#password-field" class="mdi mdi-eye toggle-password"></i>
                 </span>
              <p><input type="email" name="address" id="address" size="30" maxlength="50" placeholder="E-mail"></p>

              <p><button type="button" onclick="history.back()">戻る</button></p>
              <p><button type="submit" name="regist" value="登録">確認</button></p>

          </form>
  </body>
</html>
