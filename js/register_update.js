function previewImage(obj)
{
  var fileReader = new FileReader();
  fileReader.onload = (function() {
    document.getElementById('preview').src = fileReader.result;
  });
  fileReader.readAsDataURL(obj.files[0]);
}
/**
 * 丸くトリミングするために必要な関数です。
 * キャンバスの画像を円形に座標計算し、切り取って返しています。
 */
function getRoundedCanvas(sourceCanvas) {
    var canvas = document.createElement('canvas');
    var context = canvas.getContext('2d');
    var width = sourceCanvas.width;
    var height = sourceCanvas.height;

    canvas.width = width;
    canvas.height = height;
    context.imageSmoothingEnabled = true;
    context.drawImage(sourceCanvas, 0, 0, width, height);
    context.globalCompositeOperation = 'destination-in';
    context.beginPath();
    context.arc(width / 2, height / 2, Math.min(width, height) / 2, 0, 2 * Math.PI, true);
    context.fill();
    return canvas;
}

$(function(){
    $('#triming_image').on('change', function(event){
        var trimingImage = event.target.files;

        // imageタグは1つしかファイルを送信できない仕組みと複数送信する仕組みの二通りありますので、サーバー側でチェックを忘れないようにしてください。
        if(trimingImage.length > 1){
            console.log(trimingImage.length + 'つのファイルが選択されました。');
            return false;
        }
        // 改め代入します。
        trimingImage = trimingImage[0];

        // 画像のチェックを行いますが、あくまでjsでのチェックなのでサーバーサイドでもう一度チェックを行ってください。
        if(!trimingImage.type.match('image/jp.*') // jpg jpeg でない
         &&!trimingImage.type.match('image/png') // png でない
         &&!trimingImage.type.match('image/gif') // gif でない
         &&!trimingImage.type.match('image/bmp') // bmp でない
        ){
            alert('No Support ' + trimingImage.type + ' type image');
            $(this).val('');
            return false;
        }

        var fileReader = new FileReader();
        fileReader.onload = function(e){
            var int32View = new Uint8Array(e.target.result);
            // see https://en.wikipedia.org/wiki/List_of_file_signatures
            // ファイルのヘッダを参照し、マイムタイプを疑似的に取得します。フレームワークによってはもっと簡単に正確に読めるものもあります。
            // 下記は厳しい設定です。正規の手順を踏んでもアップロードできないカメラなどがあります。
            // （私の環境ではアクションカメラの写真などは下記に引っ掛かりました。）
            if((int32View.length>4 && int32View[0]==0xFF && int32View[1]==0xD8 && int32View[2]==0xFF && int32View[3]==0xE0)
            || (int32View.length>4 && int32View[0]==0xFF && int32View[1]==0xD8 && int32View[2]==0xFF && int32View[3]==0xDB)
            || (int32View.length>4 && int32View[0]==0xFF && int32View[1]==0xD8 && int32View[2]==0xFF && int32View[3]==0xD1)
            || (int32View.length>4 && int32View[0]==0x89 && int32View[1]==0x50 && int32View[2]==0x4E && int32View[3]==0x47)
            || (int32View.length>4 && int32View[0]==0x47 && int32View[1]==0x49 && int32View[2]==0x46 && int32View[3]==0x38)
            || (int32View.length=2 && int32View[0]==0x42 && int32View[1]==0x4D && int32View[2]==0x46 && int32View[3]==0x38)
            ){
                // success
                $('#trimed_image').css('display', 'block');
                $('#trimed_image').attr('src', URL.createObjectURL(trimingImage));
                return true;
            } else {
                // failed
                alert('No Support ' + trimingImage.type + ' type image');
                // exeファイルのアップロードを考えると下記よりもいいプラクティスがある可能性があります。
                $('#trimed_image').val('');
                return false;
            }
        };
        fileReader.readAsArrayBuffer(trimingImage);

        fileReader.onloadend = function(e){
            var image = document.getElementById('trimed_image');
            var button = document.getElementById('crop_btn');

            var croppable = false;
            var cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 1,
                ready: function () {
                    croppable = true;
                },
            });

            // fileReaderが完了した後にボタンクリックイベントを作成する必要があります。
            button.onclick = function () {
                var croppedCanvas;

                if (!croppable) {
                    alert('トリミングする画像が設定されていません。');
                    return false;
                }

                // cropper.jsに用意されている機能です。
                croppedCanvas = cropper.getCroppedCanvas();
                // 下記toBlob関数はブラウザによって名前が違います。
                var blob;
                if(croppedCanvas.toBlob){
                    croppedCanvas.toBlob(function(blob){
                        var trimedImageForm = new FormData();
                        trimedImageForm.append('blob', blob);
                        // この例ではAjaxにて送信します。
                        $.ajax({
                            url: '', // POST送信先
                            type: 'post',
                            processData: false,
                            contentType: false,
                            data: trimedImageForm,
                        }).done(function( jsonResponse ){
                            var responese = $.parseJSON(jsonResponse);
                            if(responese.status == 'success'){
                                console.log(responese);
                                alert('アップロードしました。');
                            }else if(responese.status == 'error'){
                                alert('画像作成に失敗しました。再度お試しください。\n' + responese.msg);
                            }else{
                                alert('システムエラーが発生しました。');
                            }
                        }).fail(function( responese ) {
                            alert('システムエラーが発生しました。');
                            // フレームワークによってはサーバーエラーをjsonで返してくれます。
                            var responese = $.parseJSON(jsonResponse);
                        });
                    });
                }else if(croppedCanvas.msToBlob){
                    blob = croppedCanvas.msToBlob();
                    var trimedImageForm = new FormData();
                    trimedImageForm.append('blob', blob);
                    // この例ではAjaxにて送信します。
                    $.ajax({
                        url: '', // POST送信先
                        type: 'post',
                        processData: false,
                        contentType: false,
                        data: trimedImageForm,
                    }).done(function( jsonResponse ){
                        var responese = $.parseJSON(jsonResponse);
                        if(responese.status == 'success'){
                            console.log(responese);
                            alert('アップロードしました。');
                        }else if(responese.status == 'error'){
                            alert('画像作成に失敗しました。再度お試しください。\n' + responese.msg);
                        }else{
                            alert('システムエラーが発生しました。');
                        }
                    }).fail(function( responese ) {
                        alert('システムエラーが発生しました。');
                        // フレームワークによってはサーバーエラーをjsonで返してくれます。
                        var responese = $.parseJSON(jsonResponse);
                    });
                }else{
                    // これは少しわからないです。申し訳ない。
                    imageURL = canvas.toDataURL();
                }

                // 画面にトリミング結果を出力する場合は下記が必要です。
                // 例ではAjaxにて送信済みでので、下記機能に特に意味がありません。（結果表示したところですでに送信済みですので。）
                var result = document.getElementById('result');
                var roundedImage;
                roundedCanvas = getRoundedCanvas(croppedCanvas);
                roundedImage = document.createElement('img');
                roundedImage.src = roundedCanvas.toDataURL()
                roundedImage.name = 'trimed';
                roundedImage.id = 'trimed';
                result.innerHTML = '';
                result.appendChild(roundedImage);
            };
        };
    });
});
