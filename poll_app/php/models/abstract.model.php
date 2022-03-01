<?php
  /* 抽象モデル */

  namespace model;

  use Error;

  abstract class AbstractModel {
    protected static $SESSION_NAME = null;  // 継承先のモデルに同じプロパティを持たせて$SESSION_NAMEの値を決める為、抽象モデルではnullにしておく

    public static function setSession($val) {
      if (empty(static::$SESSION_NAME)) {
        throw new Error('$SESSION_NAMEを設定してください');
      }
      $_SESSION[static::$SESSION_NAME] = $val;  // Userクラスの場合 $_SESSION['_user'] = $val
    }

    public static function getSession() {
      return $_SESSION[static::$SESSION_NAME] ?? null;
    }

    public static function clearSession() {
      static::setSession(null);  // $_SESSION['static::$SESSION_NAME']の値を初期化
    }

    /* セッションにフォームの値やメッセージを格納し、リダイレクト後に値を取得してからセッションを初期化する */
    public static function getSessionAndFlush(){
      try {
        return static::getSession();
      } finally {
        static::clearSession();
      }
    }
  }
?>