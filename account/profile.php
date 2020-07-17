
<?php
try{
session_start();
session_regenerate_id(true);
} catch (Exception $e) {
}

?>
<!DOCTYPE html>
<html lang="ja">
        <head>
            <meta charset="utf-8"/>
        </head>
        <body>
          <form method="post" action profile_done.php enctype="multipart/form-data" >
            画像ファイル<br/>
            <input type="file"  name="pic"><br/>


            名前：<?php print $_SESSION['regist_name'];?> <br/><br/>
            メールアドレス： <?php print $_SESSION['regist_address'];?> <br/><br/>

            <!-- <?php if($flag){
                    print'生年月日： 未設定<br/>';
                    print'国： 未設定<br/>';
                    print'性別: 未設定<br/>';
                  }else {

                  }

                ?> -->






              <input type="button" a href ="register_update" name="update" value="編集"><br/>
                <a href="delete.php">退会</a>
                <a class= href="...php"></a>
          </form>

        </body>
</html>
