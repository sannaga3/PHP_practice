<?php
  namespace lib;

  use model\AbstractModel;

  use Throwable;

  /* $SESSION_NAME = [[ERROR]['メッセージ内容'], [INFO]['メッセージ内容'], [DEBUG]['メッセージ内容']]といった形で、セッションにメッセージタイプと内容を配列として格納して扱う*/
  class Msg extends AbstractModel{
    protected static $SESSION_NAME = '_msg';
    public const ERROR = 'error';
    public const INFO = 'info';
    public const DEBUG = 'debug';

    /* ＄typeで ERROR INFO DEBUG の$typeを指定し、保持するメッセージ内容を設定*/
    public static function push($type, $msg) {
      /* 配列になっていない場合初期化する */
      if(!is_array(static::getSession())) {
        static::init();
      }
      $msgs = static::getSession();
      $msgs[$type][] = $msg;   //  $msgs[ERROR]['$msg']
      static::setSession($msgs);
    }

    /* 型毎、メッセージ毎に出力する */
    public static function flush() {
      try {
        $msgs_with_type = static::getSessionAndFlush() ?? [];
        echo "<div id='message'>";
        foreach($msgs_with_type as $type => $msgs) {  // 型を個別に取得する
          if ($type === static::DEBUG && !DEBUG) {    // 後ろの方の !DEBUG は define('DEBUG', true) のデバッグモードが false の時を表す。DEBUGタイプの値がfalse。
            continue;                                 // デバッグモードでない時は以降の処理へ継続
          }

          $color = $type === static::INFO ? 'alert-info' : 'alert-danger';  // メッセージタイプにより$colorへ格納するクラスの名前を変更する。クラス名にはbootstrapを用いる。

          foreach($msgs as $msg) {  // メッセージ内容を個別に取得する
            echo "<div class='alert $color'>{$msg}</div>";                  // $colorによりalertの色分けをする
          }
        }
        echo "</div>";

      } catch(Throwable $e) {
        Msg::push(Msg::DEBUG, $e->getMessage());
        Msg::push(Msg::ERROR, "Msg::flushで例外が発生しました");
      }
    }

    private static function init() {
      /* セッションに保持する値を初期化する */
      static::setSession([
        static::ERROR => [],
        static::INFO => [],
        static::DEBUG => []
      ]);
    }
  }
?>