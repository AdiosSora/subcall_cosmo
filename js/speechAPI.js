//参考　URL　https://qiita.com/hmmrjn/items/4b77a86030ed0071f548

const resultDiv = document.getelementbyId('speechText');

window.alert("speechAPIが呼び出されました");

recognition.start();//音声認識スタート!!

  SpeechRecognition = webkitSpeechRecognition || SpeechRecognition;
  let recognition = new SpeechRecognition();//SpeechRecognitionは音声認識メソッド。

  recognition.lang = 'ja-JP';
  recognition.interimResults = true;
  recognition.continuous = true;

  let finalTranscript = ''; // 確定した(黒の)認識結果

  recognition.onresult = (event) => {
    let interimTranscript = ''; // 暫定(灰色)の認識結果
    for (let i = event.resultIndex; i < event.results.length; i++) {
      let transcript = event.results[i][0].transcript;
      if (event.results[i].isFinal) {
        finalTranscript += transcript;
      } else {
        interimTranscript = transcript;
      }
    }
    resultDiv.value+=finalTranscript + '<i style="color:#ddd;">' + interimTranscript + '</i>';
  }
