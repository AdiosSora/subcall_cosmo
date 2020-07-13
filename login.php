<!DOCTYPE html>
<html>
  <head>
    <title>Acount regist</title>
  </head>
  <body>
    <h1>アカウント登録画面</h1>
    <form action="regist_check.php">

    アカウント名<input type="text" name="name" size="30" maxlength="20"> <br><br>
    パスワード<input type="password" name="pass" size="6" maxlength="20"> <br><br>
    パスワードをもう一度入力してください<input type="password" name="pass" size="6" maxlength="20"> <br/>


    <button type="button" onclick="history.back()">戻る</button>
    <button type="submit" value="登録"></button>
    </form>

  </body>
</html>
