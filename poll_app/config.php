<?php
  define('CURRENT_URI', $_SERVER['REQUEST_URI']);
  /* $urlの /poll をマッチさせ、共有部分を定数化する。 */
  if(preg_match("/(\/poll)/i", CURRENT_URI, $match)) {
    define('BASE_PATH', $match[0] . '/');        // define(定数名, 値) この場合は /poll/view と / をつなげている https://www.php.net/manual/ja/function.define.php
  }
  /* BASE_PATHを用いてimage,js,cssのディレクトリを定数化 */
  define('BASE_IMAGE_PATH', BASE_PATH . "images/");
  define('BASE_JS_PATH', BASE_PATH . "js/");
  define('BASE_CSS_PATH', BASE_PATH . "css/");
  define('BASE_PARTIAL_PATH', BASE_PATH . "partial/");
  define('BASE_VIEW_PATH', BASE_PATH . "views/");
  define('SOURCE_PATH', __DIR__ . '/php/');
  define('GO_HOME', 'home');
  define('GO_REFERER', 'referer');  // 一つ前のパスへ戻る
  define('DEBUG', true);
?>

