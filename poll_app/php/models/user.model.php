<?php
  namespace model;

  use lib\Msg;

  class UserModel extends AbstractModel {
    public string $id;
    public string $pwd;
    public string $nickname;
    public int $del_flg;

    protected static $SESSION_NAME = '_user';  // _から始まる変数はメソッドを通じて値を取得すること表す  $_SESSION['_user']

    /* バリデーションを検証する引数を簡略化する  !UserModel::validateId($user->id) => !$user::isValidId($user->id)  */
    public function isValidId() {
      return static::validateId($this->id);
    }

    /* auth.php の登録で使うバリデーション。  UserModel の id を引数 $val に格納し、バリデーションの検証を行う */
    public static function validateId($val) {
      $res = true;

      if(empty($val)) {
        Msg::push(Msg::ERROR, 'ユーザIDを入力して下さい');
        $res = false;
      } else {
        if (strlen($val) > 10) {     // strlen(string $string): int  文字列の長さをintで返す  https://www.php.net/manual/ja/function.strlen.php
          Msg::push(Msg::ERROR, 'ユーザ名は10桁以下で入力してください');
          $res = false;
        }
        if (is_alnum($val)) {
          Msg::push(Msg::ERROR, 'ユーザ名は半角英数字で入力してください');
          $res = false;
        }
      }
      return $res;       // $res が falseの場合バリデーションエラー
    }

    public function isValidPwd() {
      return static::validatePwd($this->pwd);
    }

    public static function validatePwd($val) {
      $res = true;

      if(empty($val)) {
        Msg::push(Msg::ERROR, 'パスワードを入力して下さい');
        $res = false;
      } else {
        if (strlen($val) < 4) {     // strlen(string $string): int  文字列の長さをintで返す。全角は2文字分  https://www.php.net/manual/ja/function.strlen.php
          Msg::push(Msg::ERROR, 'パスワードは4桁以上で入力してください');
          $res = false;
        }
        if (is_alnum($val)) {
          Msg::push(Msg::ERROR, 'パスワードは半角英数字で入力してください');
          $res = false;
        }
      }
      return $res;       // $res が falseの場合バリデーションエラー
    }

    public function isValidNickname() {
      return static::validateNickname($this->nickname);
    }

    public static function validateNickname($val) {
      $res = true;

      if(empty($val)) {
        Msg::push(Msg::ERROR, 'ニックネームを入力して下さい');
        $res = false;
      } else {
        if (mb_strlen($val) > 10) {     // mb_strlen(string $string, ?string $encoding = null): int  文字列の長さを返す。マルチバイト文字(全角)の一文字を1個として数える。  https://www.php.net/manual/ja/function.mb-strlen.php
          Msg::push(Msg::ERROR, 'ニックネームは10文字以下で入力してください');
          $res = false;
        }
        if (is_alnum($val)) {
          Msg::push(Msg::ERROR, 'ニックネームは半角英数字で入力してください');
          $res = false;
        }
      }
      return $res;       // $res が falseの場合バリデーションエラー
    }
  }
?>