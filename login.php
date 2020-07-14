<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <title>Login</title>
  </head>
  <body>
    <h1>ログイン画面</h1>
    <form method="post" action="login_check.php">

    ユーザ名<br/>
    <input type="text" name="name" size="30" maxlength="30" autocomplete="off"> <br/><br/>

    パスワード<br/>
    <input type="password" name="pass" size="30" maxlength="30" autocomplete="off"> <br/><br/>


    <button type="button" onclick="history.back()">戻る</button>
    <button type="submit" value="ログイン">ログイン</button>

    </form>
  </body>
</html>
