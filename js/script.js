/* eslint-disable require-jsdoc */
$(function() {
  // Peer object
  const peer = new Peer({
    key:   '766085bc-041a-4889-ba90-b8fda1a4615f',
    debug: 3,
  });

  const localText = document.getElementById('chat-textarea');
  const messages = document.getElementById('chat-text');
  const sub_messages = document.getElementById('sub-text');

  let localStream;
  let room;
  peer.on('open', () => {
    $('#my-id').text(peer.id);
    // Get things started
    step1();
  });

  peer.on('error', err => {
    alert(err.message);
    // Return to step 2 if error occurs
    step2();
  });


  $('#make-call').on('submit', e => {
    e.preventDefault();
    // Initiate a call!
    const roomName = $('#join-room').val();
    if (!roomName) {
      return;
    }
    room = peer.joinRoom('sfu_video_' + roomName, {
      mode: 'sfu',
      stream: localStream
    });

    $('#room-id').text(roomName);
    step3();
    step4();
  });

  $('#end-call').on('click', () => {
    room.close();
    step2();
  });

  $('#step1-retry').on('click', () => {
    $('#step1-error').hide();
    step1();
  });

  $('#btn-send').on('click', () => {
    onClickSend();
  });

  function onClickSend() {
    // Send message to all of the peers in the room via websocket
    console.log('チャット送信');
    room.send('1'+localText.value);
    messages.textContent += `${peer.id} : ${localText.value}\n`;
    localText.value='';

  }
  function onSubSend(subtext) {
    // Send message to all of the peers in the room via websocket
    console.log('字幕送信');
    room.send('2'+peer.id+subtext);
    localText.value = '';
  }

  // set up audio and video input selectors
  const audioSelect = $('#audioSource');
  const videoSelect = $('#videoSource');
  const selectors = [audioSelect, videoSelect];

  navigator.mediaDevices.enumerateDevices()
    .then(deviceInfos => {
      const values = selectors.map(select => select.val() || '');
      selectors.forEach(select => {
        const children = select.children(':first');
        while (children.length) {
          select.remove(children);
        }
      });

      for (let i = 0; i !== deviceInfos.length; ++i) {
        const deviceInfo = deviceInfos[i];
        const option = $('<option>').val(deviceInfo.deviceId);

        if (deviceInfo.kind === 'audioinput') {
          option.text(deviceInfo.label ||
            'Microphone ' + (audioSelect.children().length + 1));
          audioSelect.append(option);
        } else if (deviceInfo.kind === 'videoinput') {
          option.text(deviceInfo.label ||
            'Camera ' + (videoSelect.children().length + 1));
          videoSelect.append(option);
        }
      }

      selectors.forEach((select, selectorIndex) => {
        if (Array.prototype.slice.call(select.children()).some(n => {
            return n.value === values[selectorIndex];
          })) {
          select.val(values[selectorIndex]);
        }
      });

      videoSelect.on('change', step1);
      audioSelect.on('change', step1);
    });

  function step1() {
    // Get audio/video stream
    const audioSource = $('#audioSource').val();
    const videoSource = $('#videoSource').val();
    const constraints = {
      audio: {deviceId: audioSource ? {exact: audioSource} : undefined},
      video: {deviceId: videoSource ? {exact: videoSource} : undefined},
    };
    navigator.mediaDevices.getUserMedia(constraints).then(stream => {
      $('#my-video').get(0).srcObject = stream;
      localStream = stream;

      if (room) {
        room.replaceStream(stream);
        return;
      }

      step2();
    }).catch(err => {
      $('#step1-error').show();
      console.error(err);
    });
  }

  function step2() {
    $('#their-videos').empty();
    $('#step1, #step3').hide();
    $('#step2').show();
    $('#join-room').focus();
  }

  function step3() {
    // Wait for stream on the call, then set peer video display
    room.on('stream', stream => {
      const peerId = stream.peerId;
      const id = 'video_' + peerId + '_' + stream.id.replace('{', '').replace('}', '');

      $('#their-videos').append($(
        '<div class="remoteVideo_div video_' + peerId +'" id="' + id + '">' +
          '<label>' + stream.peerId + ':' + stream.id + '</label>' +
          '<video class="remoteVideos" autoplay playsinline>' +
          '<p class="subtext_field">' +
        '</div>'));
      const el = $('#' + id).find('video').get(0);
      el.srcObject = stream;
      el.play();
    });

    room.on('removeStream', function(stream) {
      const peerId = stream.peerId;
      $('#video_' + peerId + '_' + stream.id.replace('{', '').replace('}', '')).remove();
    });

    // UI stuff
    room.on('close', step2);

    room.once('open', () => {
      messages.textContent += `=== You` + peer.id + `joined ===\n`;
    });

    room.on('data', ({ data, src }) => {
      console.log('データ受け取り');
      //チャットor字幕の比較
      var result_num = data.substr( 0, 1 );
      var result_message = data.substr(1);
      //「１」チャットの場合
      if(result_num == '1'){
        console.log('データ受け取り1発火');
        messages.textContent += `${src}: ${result_message}\n`;
      }else
      if(result_num == '2'){
        console.log('データ受け取り2発火');
        var peerID_length = src.length;
        console.log(`${peerID_length}`);
        var subtext_area = document.getElementById(`${src}`);
        console.log(`${subtext_area}`);
        sub_messages.innerHTML += result_message.substring(peerID_length);

        console.log(result_message.substring(result_message));
        console.log(result_message.substring(peerID_length));
      }
    });

    room.on('peerLeave', peerId => {
      $('.video_' + peerId).remove();
    });

    $('#step1, #step2').hide();
    $('#step3').show();
  }
  function step4(){

    const speech = new webkitSpeechRecognition();
    speech.lang = 'ja-JP';
    speech.start();

    console.log('認識スタート');

    speech.onresult = function (e) {
      console.log('認識完了');
        speech.stop();
        if (e.results[0].isFinal) {
          var autotext = e.results[0][0].transcript

          //文字識別結果
          console.log(e);
          console.log(autotext);
          onSubSend(autotext)
        }
    }

    speech.onend = () => {

      console.log('認識再開');
        speech.start()
    };
  }
});
