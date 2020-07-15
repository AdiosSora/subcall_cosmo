//メールアドレスチェック用関数(Ispass)を定義
jQuery.validator.addMethod("Ispass", function(value, element) {
     return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,30}$/.test(value);
   }, "半角英数大文字を一文字以上入力してください。(8文字以上30文字以下)"
);
jQuery(function($){
    $('#check').validate({
         rules: {
             //ユーザ名チェック
             name: {
                required: true
             },
             //メールアドレスチェック
             address: {
                 required: true,
                 email: true
             },
             //パスワードチェック
             pass:{
                 required: true,
                 Ispass: true
             },
             pass2:{
                 required: true,
                 equalTo: "#pass"
             }
         },

        //チェックに反した時に表示するメッセージ
         messages: {
              name: {
                  required: '必須入力項目です。'
              },
              address :{
                  required: '必須入力項目です。',
                  email: '有効なメールアドレスを入力してください。'
              },
              pass:{
                  required: '必須入力項目です。'
              },
              pass2:{
                  required: '必須入力項目です。',
                  equalTo: 'パスワードが一致しません。'
              }
         },

       });
});

$(document).ready(function() {

    $('#pass').keyup(function() {
        $('#result').html(checkStrength($('#pass').val()))
    })

    function checkStrength(password) {

        var strength = 0 //強さ

        if (password.length < 6) {
            $('#result').removeClass()
            $('#result').addClass('short')
            return '短すぎる！！'
        }

        // 文字数が7より大きいければ+1
        if (password.length > 7) strength += 1
        // 英字の大文字と小文字を含んでいれば+1
        if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1
        // 英字と数字を含んでいれば+1
        if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1
        // 記号を含んでいれば+1
        if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1
        // 記号を2つ含んでいれば+1
        if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1

        // 点数を元に強さを計測
        if (strength < 2) {
            $('#result').removeClass()
            $('#result').addClass('弱いです〜')
            return 'Weak'
        } else if (strength == 2) {
            $('#result').removeClass()
            $('#result').addClass('良い感じ！！')
            return 'Good'
        } else {
            $('#result').removeClass()
            $('#result').addClass('強いです！!')
            return 'Strong'
        }
    }
});
