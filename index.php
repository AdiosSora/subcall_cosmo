<!DOCTYPE html>

<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SubCall</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">

        <label for="name" accesskey="n">ようこそ　ゲスト様</label>

        <h1 class="heading">Welcome to Subcall</h1>


        <button type="button" onclick="golink()">ログイン</button></br>

          <button type="button" onclick="room_make()">部屋を作る</button></br>

          <button type="button" onclick="room_in()">部屋に入る</button></br>

          <script>
          function golink(){
             location.href="login.php";
          }

          function room_make(){
             location.href="room_make.php";
          }

          function room_in(){
             location.href="room_in.php";
          }

            </script>

        </form>



</body>
</html>
