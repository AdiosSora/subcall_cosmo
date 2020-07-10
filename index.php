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
        <h1 class="heading">Welcome to Subcall</h1>
        <script>
          function golink(){
             location.href="login.php";
          }
        </script>
        <button type="button" onclick="golink()">ログイン</button></br>
        <form action="login.php" method="post">
          部屋番号を入力してください
          <input type="text" name="roomId" size="30" maxlength="20"></br>
          言語を選択してください(Select a language)
          <select name="language">
            <option value="ja">日本語</option>
            <option value="english">英語</option>
        </p>
</body>
</html>
