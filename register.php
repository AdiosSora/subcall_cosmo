<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8"/>

    <title>Acount regist</title>
    <link href="validationEngine.jquery.css" rel="stylesheet" type="text/css" /> <script src="jquery.validationEngine.js"></script> <script src="jquery.validationEngine-ja.js"></script>
      <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
      <script>
          jQuery(document).ready(function(){
          jQuery("#register").validationEngine();
          });
      </script>

  </head>

  <body>
    <h1>アカウント登録画面</h1>
    <form method="post" action="register_check.php" id="register">

      アカウント名<br>
     <input type="text" id="text3_1" class="validate[required] text-input" /><br><br>

      メールアドレス<br>
       <input type="text" id="text3_3_1" class="validate[required,custom[email]] text-input" /><br><br>

      パスワード<br>
      <input class="validate[required] text-input" type="password" id="passwd" /><br><br>

      パスワードをもう一度入力してください<br>
      <input class="validate[required,equals[passwd]] text-input" type="password" id="re_passwd" /><br><br>
      <!--<input type="password" name="pass" size="30" id="word" maxlength="30" class="validate[password] text-input" data-errormessage-value-missing="半角英数大文字１字以上で入力してください。" data-prompt-position="topLeft"><br><br>
      -->

    <!--input type="password" name="pass2" size="30" id="word2" maxlength="30" class="validate[password] text-input" data-errormessage-value-missing="半角英数大文字１字以上で入力してください。" data-prompt-position="topLeft"><br><br>
    -->

    <button type="button" onclick="history.back()">戻る</button>
    <button type="submit" onclick="return_test" id="b1" name="register" value="登録">確認</button>
  </form>


    <script>

          //function return_test()
          //{
            //if(document.getElementById("word").value != document.getElementById("word2").value)
            //{
              //alert("パスワードが一致していません");
              //return false;
            //}
            //else
            //{
              //return true;
            //}
          //}

    </script>



  </body>
</html>
