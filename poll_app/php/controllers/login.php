<?php
  namespace controller\login;

  use lib\Auth;
  use lib\Msg;

  function get() {
    require_once SOURCE_PATH . 'views/login.php';
  }

  function post(){
    // libs/helper.php の get_param関数へ部品化
    // $id = $_POST['id'] ??  '';  /* null演算子を使って、postリクエストでパラメータが飛んでこなかった場合の初期値を設定する。isset($_POST['id']) ? $_POST['id'] : ''と同じ意味 */
    // $pwd = $_POST['pwd'] ?? '';
    $id = get_param('id', '');
    $pwd = get_param('pwd', '');

    Msg::push(Msg::DEBUG, 'デバッグメッセージ');
    /* Authクラスのloginメソッドにより、idとパスワードのログイン認証を行う */
    if (Auth::login($id, $pwd)) {
      Msg::push(Msg::INFO, '認証成功');
      redirect(GO_HOME);       // helper.pnpのredirect関数でhomeへリダイレクト。
    } else {
      // echo '認証失敗';      header("location: {$path}")
      Msg::push(Msg::ERROR, '認証失敗');
      redirect(GO_REFERER);  // ログインをやり直し為、再度ログインページを表示
    }
  }

  /* ログイン関数を libs/auth.php へ部品化 */
  /* 認証成功の変数 $is_success のデフォルト値をfalseにし、成功時のみtrueを返り値とする */
  // function login($id, $pwd) {
  //   $is_success = false;

  //   /* idを元に対象のUserのインスタンスを取得し、変数に格納する  */
  //   $user = UserQuery::fetchById($id);
  //   // echo '<pre>';
  //   // print_r($result->id);
  //   // echo '</pre>';

  //   /* $userが空でなければパスワードの一致を確かめる */
  //   if (!empty($user) && $user->del_flg !== 1) {

  //     // パスワードがハッシュに一致するかどうかを調べる  password_verify(string $password, string $hash)
  //     if (password_verify($pwd, $user->pwd)) {

  //       $is_success = true;
  //       $_SESSION['user'] = $user;
  //       /*
  //         $_SESSIONについて      https://wepicks.net/phpref-session-2/
  //         ユーザー毎のセッションデータは、ユニークなセッションIDにより管理される。
  //         下記2つのIDによりサーバー側とブラウザ側を連携する
  //         セッションID・・・   サーバー側
  //         PHPSESSID ・・・   ブラウザ側(クッキーに格納されている)
  //       */
  //     } else {
  //       echo 'パスワードが一致しません <br>';
  //     }
  //   } else {
  //     echo 'ユーザーが見つかりません <br>';
  //   }
  //   return $is_success;
  // }
?>