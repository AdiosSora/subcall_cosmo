<!DOCTYPE html>

<html lang="ja">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="js/jquery.validate.js"></script>
  <script src="js/jquery.validate.min.js"></script>
  <script src="js/register.js"></script>

  <title>Stable - ビデオ会議</title>
  <?php include('./header.php'); ?>
</head>
<body>
  <?php include('./nav.php'); ?>

  <div id="index-banner" class="parallax-container">
    <div class="container">
      <div class="section no-pad-bot">
        <br><br>
        <div class="row">
          <div class="col offset-s2 s8 center">
            <div class="card">
              <div class="card-content">
                <form method="post" action="register_check.php" id="check" class="pw-form-container">
                    <h1>会員登録画面</h1><br/>
                    <label for="name"><span class="required_mark">必須</span> お名前</label>
                    <input type="text" name="name" id="name" size="30" maxlength="20" placeholder="UserName" autocomplete="off"></p>

                    <input type="password" name="pass" id="pass" size="30" maxlength="20" placeholder="Password" autocomplete="off">
                    <span class="helper-text" data-error="wrong" data-success="right"><i toggle="#password-field" class="mdi mdi-eye toggle-password"></i></span></p>

                    <p><input type="password" name="pass2" id="pass2" size="30" maxlength="20" placeholder="Password  (check)" autocomplete="off">
                    <span class="helper-text" data-error="wrong" data-success="right"><i toggle="#password-field" class="mdi mdi-eye toggle-password"></i></span></p>
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

                    <a class="waves-effect waves-light btn-large grey darken-1" href="javascript:form1.submit()">戻る</a>
                    <a class="waves-effect waves-light btn-large" href="javascript:form1.submit()">確認</a>
                </form>
              </div>
            </div>
          </div>
        </div>
        <br><br>

      </div>
    </div>
    <div class="parallax" style="background:#999999;"></div>
  </div>


  <?php include('./footer.php'); ?>

  </body>
</html>
