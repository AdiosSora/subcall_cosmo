//メールアドレスチェック用関数(Ispass)を定義
jQuery.validator.addMethod("Ispass", function(value, element) {
     return this.optional(element) || /^([a-zA-Z0-9]+)$/.test(value);
   }, "※半角英数字で入力してください。"
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
                  required: '※必須入力項目です。'
              },
              address :{
                  required: '※必須入力項目です。',
                  email: '※有効なメールアドレスを入力してください。'
              },
              pass:{
                  required: '※必須入力項目です。'
              },
              pass2:{
                  required: '※必須入力項目です。',
                  equalTo: '※パスワードが一致しません。'
              }
         },

       });
});

// パスワードの表示・非表示切替
$(".toggle-password").click(function() {
  // iconの切り替え
  $(this).toggleClass("mdi-eye mdi-eye-off");

  // 入力フォームの取得
  var input = $(this).parent().prev("input");
  // type切替
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});
