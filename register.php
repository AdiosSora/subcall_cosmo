<!DOCTYPE html>
<html lang="ja">
  <head>
<<<<<<< HEAD
    <meta charset="utf-8"/>

    <title>Acount regist</title>
    <link href="validationEngine.jquery.css" rel="stylesheet" type="text/css" /> <script src="jquery.validationEngine.js"></script> <script src="jquery.validationEngine-ja.js"></script>
      <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
      <script>
          jQuery(document).ready(function(){
          jQuery("#register").validationEngine();
          });
      </script>

=======
      <meta charset="utf-8"/>
      <link rel="stylesheet" href="css/register.css">
      <title>Acount regist</title>
>>>>>>> ba7d378b58faf8effc1e88f8dfa5cee43c77d837
  </head>

  <body>
<<<<<<< HEAD
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



=======
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="js/jquery.validate.js"></script>
      <script src="js/jquery.validate.min.js"></script>
      <script src="js/register.js"></script>


      <div class="pw-form">
          <form method="post" action="register_check.php" id="check" class="pw-form-container">
              <h1>会員登録画面</h1><br/>

              <p><input type="text" name="name" id="name" size="30" maxlength="20" placeholder="UserName" autocomplete="off"></p>

              <p><input type="password" name="pass" id="pass" size="30" maxlength="20" placeholder="Password" autocomplete="off"></p>
                 <span class="field-icon">
                   <i toggle="#password-field" class="mdi mdi-eye toggle-password"></i>
                 </span>

              <p><input type="password" name="pass2" id="pass2" size="30" maxlength="20" placeholder="Password  (check)" autocomplete="off"></p>
                 <span class="field-icon">
                   <i toggle="#password-field" class="mdi mdi-eye toggle-password"></i>
                 </span>

              <script>
                $(".toggle-password").click(function() {
                  $(this).toggleClass("mdi-eye mdi-eye-off");

                  var input = $(this).parent().prev("input");
                  if (input.attr("type") == "password") {
                    input.attr("type", "text");
                  } else {
                    input.attr("type", "password");
                  }
                });
              </script>

              <p><input type="email" name="address" id="address" size="30" maxlength="50" placeholder="E-mail" autocomplete="off"></p>

              <p><button type="button" onclick="history.back()">戻る</button></p>
              <p><button type="submit" name="regist" value="登録">確認</button></p>
          </form>
      </div>
>>>>>>> ba7d378b58faf8effc1e88f8dfa5cee43c77d837
  </body>
</html>
