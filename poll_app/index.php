<?php
  require_once 'config.php';

  /* リクエストのパラメータの変数化及び初期値設定のライブラリ */
  require_once SOURCE_PATH . 'libs/helper.php';

  /* ログイン認証のライブラリ */
  require_once SOURCE_PATH . 'libs/auth.php';
  require_once SOURCE_PATH . 'libs/router.php';
  use function lib\route;

  /* モデル内でDataSourceの各関数を用いてDBへアクセスする  */
  require_once SOURCE_PATH .'models/abstract.model.php';
  require_once SOURCE_PATH .'models/user.model.php';
  require_once SOURCE_PATH .'models/topic.model.php';
  require_once SOURCE_PATH .'db/datasource.php';
  require_once SOURCE_PATH .'db/user.query.php';
  require_once SOURCE_PATH .'db/topic.query.php';

  /* メッセージ表示 */
  require_once SOURCE_PATH . 'libs/message.php';

  /* 各viewを関数で呼べるようにrequire_onceしておく */
  require_once SOURCE_PATH . 'partials/topic-list-item.php';
  require_once SOURCE_PATH . 'partials/header.php';
  require_once SOURCE_PATH . 'views/home.php';
  require_once SOURCE_PATH . 'views/login.php';
  require_once SOURCE_PATH . 'views/register.php';
  require_once SOURCE_PATH . 'views/topic/archive.php';
  require_once SOURCE_PATH . 'partials/footer.php';

  /* controller/login のlogin関数でセッション変数にuserを格納する為 */
  session_start();

  try {
    /* ヘッダーの読み込み */
    \partials\header();

    /* $_SERVER['REQUEST_URI'] から 個別のページを識別する /poll/login => login */
    $rpath = str_replace(BASE_PATH, "", $_SERVER['REQUEST_URI']);       /* str_replace(置換する値, 置換後の値, 置換される値)       https://www.php.net/manual/ja/function.str-replace.php */
    /* 後に関数の一部としてアクション名を使う為、小文字にしておく */
    $method = strtolower($_SERVER['REQUEST_METHOD']);

    route($rpath, $method);
  } catch (Throwable $e) {
    die('<h1>index.phpでエラーが起きています</h1>');
  }


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
  \partials\footer();

  // セッション確認のメモ
  echo '<pre>';
  print_r($_SESSION['_user']);
  echo 'sessionName : ' . session_name() . '<br>';
  echo 'sessionID : ' . session_id() . '<br>';
  echo '</pre>';
?>