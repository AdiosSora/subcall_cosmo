<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8"/>
    <title>Acount regist</title>
  </head>
  <body>
    <h1>アカウント登録画面</h1>

    <form method="post" action="register_check.php">

    アカウント名
    <input type="text" name="name" size="30" maxlength="20" required> <br><br>

    メールアドレス
    <input type="text" name="address" size="30" maxlength="100" required> <br><br>

    パスワード
    <input type="password" name="pass" id="word" size="30" maxlength="30"><br><br>

    パスワードをもう一度入力してください
    <input type="password" name="pass2" id="word2" size="30" maxlength="30"><br><br>

    <button type="button" onclick="history.back()">戻る</button>
    <button type="submit" onclick="return_test" id="b1" name="register" value="登録">確認</button>

    <script>

          function return_test()
          {
            if(document.getElementById("word").value != document.getElementById("word2").value)
            {
              alert("パスワードが一致していません");
              return false;
            }
            else
            {
              return true;
            }
          }

    </script>

    </form>

  </body>
</html>
