<?php
  namespace lib;

  use Throwable;

  function route($rpath, $method) {
    try {
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

      /* topic/archive を topic\archive に変換 */
      $rpath = str_replace('/', '\\', $rpath);

      /* 関数の指定と呼び出し \controllers\{$rpath}\{$method} => controller\login\get 文字列であっても関数を実行できる。controller\login という namespace のget()メソッドを呼ぶという意味 */
      $function_name = "\\controller\\{$rpath}\\{$method}";
      $function_name();

    } catch(Throwable $e) {
      Msg::push(Msg::DEBUG, $e->getMessage());
      Msg::push(Msg::ERROR, 'エラーです');
      redirect('404');
    }
  }
?>