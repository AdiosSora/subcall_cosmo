<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SkyWay - Room example</title>
  </head>
  <body>
    <div class="container">
      <h1 class="heading">Room example</h1>
      <p class="note">
        Change Room mode (before join in a room):
        <a href="#">mesh</a> / <a href="#sfu">sfu</a>
      </p>
      <div class="room">
        <div>
          <video id="js-local-stream"></video>
          <span id="js-room-mode"></span>:
          <?php
            $room = $_POST['room_id'];
            $guestName=$_POST['guest_name'];
          if($room!=null && $guestName!=null){
            print '<input type="text" placeholder="Room Name" id="js-room-id" value="'.$room.'">';
            print '<div id="js-guest-name">'.$guestName.'</div>';
          } else {
            header('Location: index.php');
          }
          ?>
          <button id="js-join-trigger">Join</button>
          <button id="js-leave-trigger">Leave</button>
        </div>

        <div class="remote-streams" id="js-remote-streams"></div>

        <div>
          <pre class="messages" id="js-messages"></pre>
          <input type="text" id="js-local-text">
          <button id="js-send-trigger">Send</button>
        </div>
      </div>
      <p class="meta" id="js-meta"></p>
    </div>
    <script src="//cdn.webrtc.ecl.ntt.com/skyway-latest.js"></script>
    <script src="/js/script.js"></script>
  </body>
  <script>
  </script>
</html>
