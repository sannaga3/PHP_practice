<?php
  require_once 'config.php';

  /* リクエストのパラメータの変数化及び初期値設定のライブラリ */
  require_once SOURCE_PATH . 'libs/helper.php';

  /* ログイン認証のライブラリ */
  require_once SOURCE_PATH . 'libs/auth.php';

  /* モデル内でDataSourceの各関数を用いてDBへアクセスする  */
  require_once SOURCE_PATH .'models/abstract.model.php';
  require_once SOURCE_PATH .'models/user.model.php';
  require_once SOURCE_PATH .'db/datasource.php';
  require_once SOURCE_PATH .'db/user.query.php';

  /* メッセージ表示 */
  require_once SOURCE_PATH . 'libs/message.php';

  /* controller/login のlogin関数でセッション変数にuserを格納する為 */
  session_start();

  /* ヘッダーの読み込み */
  require_once SOURCE_PATH . 'partials/header.php';

  /* $_SERVER['REQUEST_URI'] から 個別のページを識別する /poll/login => login */
  $rpath = str_replace(BASE_PATH, "", $_SERVER['REQUEST_URI']);       /* str_replace(置換する値, 置換後の値, 置換される値)       https://www.php.net/manual/ja/function.str-replace.php */

  /* 後に関数の一部としてアクション名を使う為、小文字にしておく */
  $method = strtolower($_SERVER['REQUEST_METHOD']);

  function route($rpath, $method) {
    if($rpath === '') {
      $rpath = 'home';
    }

    /* $rpathを用いてパスを変数化して読み込み */
    $targetFile = SOURCE_PATH . "/controllers/{$rpath}.php";

    /* $targetFileが存在しなければ404を出力 */
    if(!file_exists($targetFile)) {
      require_once SOURCE_PATH . "views/404.php";
      return;
    }
    require_once $targetFile;

    /* 関数の指定と呼び出し \controllers\{$rpath}\{$method} => controller\login\get 文字列であっても関数を実行できる。controller\login という namespace のget()メソッドを呼ぶという意味 */
    $function_name = "\\controller\\{$rpath}\\{$method}";
    $function_name();
  }
  route($rpath, $method);

  /* ボディ部分を各ファイルから読み込む。 $rpathによってルーティングの振り分け */
  /* partialディレクトリと上記のroute関数に分離した為コメントアウトとする */
  // switch ($rpath) {
  //   case 'login':
  //     require_once BASE_PATH . 'controllers/login.php';
  //     break;
  //   case 'register.php':
  //     require_once BASE_PATH . 'controllers/register.php';
  //     break;
  //   case '/poll/views/home.php':
  //     require_once BASE_PATH . 'controllers/home.php';
  //     break;
  // }

  /* フッターの読み込み */
  require_once SOURCE_PATH . 'partials/footer.php';

  // セッション確認のメモ
  // echo '<pre>';
  // print_r($_SESSION['user']);
  // echo 'sessionName : ' . session_name() . '<br>';
  // echo 'sessionID : ' . session_id() . '<br>';
  // echo '</pre>';
?>