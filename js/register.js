
//メールアドレスチェック用関数(Ispass)を定義
jQuery.validator.addMethod("Ispass", function(value, element) {
  return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,30}$/.test(value);
}, "半角英数大文字を一文字以上入力してください。(8文字以上30文字以下)");

jQuery(function($) {
  $('#check').validate({
    rules: {
      //ユーザ名チェック
      name: {
        required: true,
        Isuser: true
      },
      //メールアドレスチェック
      address: {
        required: true,
        email: true
      },
      //パスワードチェック
      pass: {
        required: true,
        Ispass: true
      },
      pass2: {
        required: true,
        equalTo: "#pass"
      }
    },

    //チェックに反した時に表示するメッセージ
    messages: {
      name: {
        required: '必須入力項目です。'
      },
      address: {
        required: '必須入力項目です。',
        email: '有効なメールアドレスを入力してください。'
      },
      pass: {
        required: '必須入力項目です。'
      },
      pass2: {
        required: '必須入力項目です。',
        equalTo: 'パスワードが一致しません。'
      }
    },

  });
});
