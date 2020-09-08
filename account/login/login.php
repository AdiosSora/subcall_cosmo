<!DOCTYPE html>

<html lang="ja">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>

  <title>ログイン - Stable</title>
  <?php include '../../header.php'; ?>
</head>
<body>

  <?php include '../../nav.php'; ?>
  <main>
  <div id="index-banner" class="parallax-container">
    <div class="container">
      <div class="section no-pad-bot">
        <br><br>
        <div class="row">
          <div class="col offset-s2 s8 center">
            <form method="post" name="regiser_form" action="login_check.php" id="check" class="pw-form-container">
                <h2 style="color:black !important;">ログイン</h2><br/>
                <div id="error_alert" class="alert error" style="display:none;">IDかパスワードが間違っています、もう一度入力してください。</div>

                <div class="form_title">
                  <label for="name" class="form_name">ユーザ名</label>
                </div>
                <input type="text" name="name" id="name" size="100" maxlength="100" placeholder="例:たろう" autocomplete="off">
                <br>
                <div class="form_title">
                  <label for="name" class="form_name">パスワード</label>
                </div>
                <input type="password" name="pass" id="pass" size="100" maxlength="100" placeholder="パスワード" autocomplete="off">
                <br>
                <a class="waves-effect waves-light btn-large grey darken-1" href="../../index.php">戻る</a>
                <a class="waves-effect waves-light btn-large grey darken-1" href="../register/register.php">会員登録</a>
                <a class="waves-effect waves-light btn-large" href="javascript:regiser_form.submit()">ログイン</a>
            </form>
          </div>
        </div>
        <br><br>
      </div>
    </div>
  </div>
  </main>
  <?php include '../../footer.php'; ?>
  <?php
  try{
    $check='';
    if (isset($_GET['check'])){
      $check=htmlspecialchars($_GET['check']);
    }
    if($check == 'error'){
      ?>
      <script>
        document.getElementById("error_alert").style.display="inline";
      </script>
      <?php
    }
  } catch(Exception $e) {
    print '';
  }
  ?>
  </body>
</html>
