<?php
  namespace model;

  use lib\Msg;

  class TopicModel extends AbstractModel {
    public int $id;
    public string $title;
    public int $published;
    public int $views;
    public int $like;
    public int $dislike;
    public string $user_id;
    public string $nickname;  //  usersテーブルと結合して取得する為
    public int $del_flg;

    protected static $SESSION_NAME = '_topic';  // _から始まる変数はメソッドを通じて値を取得すること表す  $_SESSION['_user']

    // /* バリデーションを検証する引数を簡略化する
    public function isValidId() {
      return static::validateId($this->id);
    }

    public static function validateId($val) {
      $res = true;

      /* IDが空、もしくは数値かどうかを検証 */
      if(empty($val) || !is_numeric($val)) {
        Msg::push(Msg::ERROR, 'トピックIDを数値で入力して下さい');
        $res = false;
      }
      return $res;
    }

    public function isValidTitle() {
      return static::validateTitle($this->title);
    }

    public static function validateTitle($val) {
      $res = true;

      if(empty($val)) {
        Msg::push(Msg::ERROR, 'タイトルを文字列で入力して下さい');
        $res = false;
      } else {
        if (mb_strlen($val) > 30) {
          Msg::push(Msg::ERROR, 'タイトルは30文字以内で入力して下さい');
          $res = false;
        }
      }
      return $res;
    }

    public function isValidPublished() {
      return static::validatePublished($this->published);
    }

    public static function validatePublished($val) {
      $res = true;

      if(!isset($val)) {
        Msg::push(Msg::ERROR, '公開設定を選択してください');
        $res = false;
      } else {
        if (!($val == 0 || $val == 1)) {
          Msg::push(Msg::ERROR, '不正な公開ステータスです');
          $res = false;
        }
      }
      return $res;
    }
  }
?>