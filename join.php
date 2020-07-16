<!DOCTYPE html>                                                                                                                                                                                                                                                                                                                                                                                  <!DOCTYPE html>
<html lang="en">
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
          print '<input type="text" placeholder="Room Name" id="js-room-id" value="'.$room.'">';
          ?>

          <button id="js-join-trigger">Join</button>
          <button id="js-leave-trigger">Leave</button>
        </div>

        <div class="remote-streams" id="js-remote-streams"></div>

        <!-- チャット -->
        <div>
          チャット
          <pre class="messages" id="js-messages"></pre>
          <input type="text" id="js-local-text">
          <button id="js-send-trigger">Send</button>
        </div>

        <!-- メンバーリスト -->
        <div>
          メンバーリスト</br>
          <?php
            require_once('common.php');

            $guestname = $_POST['guestname'];

            call_memberlist($guestname);
          ?>
        </div>

        <!-- 音声認識チャット -->
        <div>
          音声認識チャット
        </div>

      <p class="meta" id="js-meta"></p>
    </div>
    <script src="//cdn.webrtc.ecl.ntt.com/skyway-latest.js"></script>
  </body>
</html>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   
