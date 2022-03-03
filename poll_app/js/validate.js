function validate_form() {
  const $inputs = document.querySelectorAll('.validate-target');
  const $form = document.querySelector('.validate-form');

  if (!$form) return;

  // $inputsで取得した全ての要素に対してイベントリスナーを付与する
  for (const $input of $inputs) {

    $input.addEventListener('input', function(e) {
      const $target = e.currentTarget;
      const $feedback = $target.nextElementSibling;  // 親の要素から見て自身の直後の要素を取得

      activateSubmitButton($form);

      //  $feedbackが無効化されている時(ボタンが押せる時)はバリデーションチェックの必要がない為関数を抜ける。
      if (!$feedback.classList.contains('invalid-feedback')) {
        return;
      }

      // バリデーションエラーがある場合はfalse
      if ($target.checkValidity()) {
        $target.classList.add('is-valid');
        $target.classList.remove('is-invalid');
        $feedback.textContent = '';
      } else {
        $target.classList.add('is-invalid');
        $target.classList.remove('is-valid');
        // フォームに入力した値が空の場合
        if ($target.validity.valueMissing) {
          $feedback.textContent = '値を入力してください';
        // フォームに入力した値が minlengthより少ない場合
        } else if ($target.validity.tooShort) {
          $feedback.textContent = `${$target.minLength} 文字以上で入力してください。現在 ${$target.value.length} 文字です`;
        // フォームに入力した値が maxlengthより少ない場合。maxlengthが設定されている場合、フォームに10文字以上入力できない為、この条件がtrueになることはない？
        } else if ($target.validity.tooLong) {
          $feedback.textContent = `${$target.maxLength} 文字以下で入力してください。現在 ${$target.value.length} 文字です`;
        // フォームに入力した値が pattern の正規表現にマッチしない場合
        } else if ($target.validity.patternMismatch) {
          $feedback.textContent = `半角英数字で入力してください。`;
        }
      }
    })
  }

  function activateSubmitButton($form) {
    const $submitBtn = $form.querySelector('[type="submit"]');

    // formの値がバリデーションに引っかかればボタンを押せないように、そうでなければ押せるようにする(タグのdisabled属性を操作する)
    if($form.checkValidity()) {
      $submitBtn.removeAttribute('disabled');
    } else {
      $submitBtn.setAttribute('disabled', true);
    }
  }
}
validate_form();