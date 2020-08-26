<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <script type="text/javascript">
  const fileup = (e) => {
    const img = document.getElementById('img');
    const reader = new FileReader();
    const imgReader = new Image();
    const imgWidth = 400;
    reader.onloadend = () => {
      imgReader.onload = () => {
        const imgType = imgReader.src.substring(5, imgReader.src.indexOf(';'));
        const imgHeight = imgReader.height * (imgWidth / imgReader.width);
        const canvas = document.createElement('canvas');
        canvas.width = imgWidth;
        canvas.height = imgHeight;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(imgReader,0,0,imgWidth,imgHeight);
        img.src = canvas.toDataURL(imgType);
      }
      imgReader.src = reader.result;
    }
    reader.readAsDataURL(e.files[0]);
  }
  </script>
</head>
<body>
  ファイル：<input type="file" accept="image/jpeg,image/png,image/gif" onchange="fileup(this)" />
  <div>
    <img src="" id="img" />
  </div>
</body>
</html>
