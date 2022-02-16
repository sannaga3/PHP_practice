<?php
  $url = $_SERVER['REQUEST_URI'];
  // echo $url . '<br>';
  /* $urlの /poll をマッチさせ、共有部分を定数化する。 */
  if(preg_match("/(\/poll)/i", $url, $match)) {
    define('BASE_PATH', $match[0] . '/');        // define(定数名, 値) この場合は /poll/view と / をつなげている https://www.php.net/manual/ja/function.define.php
  }
  /* BASE_PATHを用いてimage,js,cssのディレクトリを定数化 */
  define('BASE_IMAGE_PATH', BASE_PATH . "images/");
  define('BASE_JS_PATH', BASE_PATH . "js/");
  define('BASE_CSS_PATH', BASE_PATH . "css/");

  /* $_SERVER['REQUEST_URI']によってルーティングの振り分け */
  switch ($url) {
    case '/poll/views/login.php':
      require_once 'views/login.php';
      break;
    case '/poll/views/register.php':
      require_once 'views/register.php';
      break;
    case '/poll/views/form.php':
      require_once 'views/form.php';
      break;
    case '/poll/views/home.php':
      require_once 'views/home.php';
      break;
  }
?>

