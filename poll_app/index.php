<?php
  require_once 'config.php';

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

?>