<?php
  namespace lib;
  use db\UserQuery;
  use model\UserModel;
  use Throwable;

class Auth {
    public static function login($id, $pwd) {
      try {
        if (!(UserModel::validateId($id) * UserModel::validatePwd($pwd))) {
          return false;
        }
        $is_success = false;

        /* idを元に対象のUserのインスタンスを取得し、変数に格納する  */
        $user = UserQuery::fetchById($id);
        // echo '<pre>';
        // print_r($result->id);
        // echo '</pre>';

        /* $userが空でなければパスワードの一致を確かめる */
        if (!empty($user) && $user->del_flg !== 1) {

          // パスワードがハッシュに一致するかどうかを調べる  password_verify(string $password, string $hash)
          if (password_verify($pwd, $user->pwd)) {
            $is_success = true;
            UserModel::setSession($user);
            // $_SESSION['user'] = $user;   セッションにUserModelインスタンスを格納する。registメソッドにも同じ記述がある為、上記のように各モデルがAbstractModel::setSessionメソッドを継承する形に統一する。
          } else {
            Msg::push(Msg::ERROR, 'パスワードが一致しません <br>');
          }
        } else {
          Msg::push(Msg::ERROR, 'ユーザーが見つかりません <br>');
        }
      } catch(Throwable $e) {
        $is_success = false;
        Msg::push(Msg::DEBUG, $e->getMessage());
        Msg::push(Msg::ERROR, 'エラーが発生しました。時間を置いてから再度お試しください');
      }
      return $is_success;
    }

    public static function regist($user) {
      try {
        // if (!$user->isValidId() || !$user->isValidPwd() || !$user->isValidNickname()) {   // OR条件を使うと全てのフォームが空の場合、最初のID検証のエラーしか表示されない問題がある
        if (!($user->isValidId() * $user->isValidPwd() * $user->isValidNickname())) {   // 各バリデーションの結果を論理値として乗算し、結果を０と１で分岐することにより全てのバリデーションを検証できる
          return false;   // regist関数がfalseになり、最終的に register.php の if(Auth::regist($user))にfalseが返り、登録が失敗する。
        }
        $is_success = false;

        $exist_user = UserQuery::fetchById($user->id);
        if (!empty($exist_user)) {
          Msg::push(Msg::ERROR, 'ユーザーが既に存在します。');
          return;
        }

        $is_success = UserQuery::insert($user->id, $user->pwd, $user->nickname);

        if ($is_success) {
          UserModel::setSession($user);
          // $_SESSION['user'] = $user;
        }
      } catch(Throwable $e) {
        $is_success = false;
        Msg::push(Msg::DEBUG, $e->getMessage());
        Msg::push(Msg::ERROR, 'エラーが発生しました。時間を置いてから再度お試しください');
      }
      return $is_success;
    }

    public static function isLogin() {
      try {
        $user = UserModel::getSession();  //  $_SESSION['_user']を取得し、ログイン中かどうか確認する
      } catch (Throwable $e) {
        Msg::push(Msg::ERROR, 'エラーが発生しました。');
        Msg::push(Msg::ERROR, $e->getMessage());
        return false;
      }
      if (isset($user)) {
        return true;
      } else {
        return false;
      }
    }

    public static function logout() {
      try {
        UserModel::clearSession();
      } catch(Throwable $e) {
        Msg::push(Msg::ERROR, $e->getMessage());
        return false;
      }
      return true;
    }
  }
  /* 以下セッションに関するメモ */
  /*
    $_SESSIONについて      https://wepicks.net/phpref-session-2/
    ユーザー毎のセッションデータは、ユニークなセッションIDにより管理される。
    下記2つのIDによりサーバー側とブラウザ側を連携する
    セッションID・・・   サーバー側
    PHPSESSID ・・・   ブラウザ側(クッキーに格納されている)
  */
  /*
    ＄pwdのハッシュ値について   https://www.php.net/manual/ja/faq.passwords.php
    前提条件 : 平文をハッシュ化した場合、ハッシュ値から平文の特定はできない。ハッシュ値の一致で認証を行うことになる。下記が詳細。
    DBが外部から盗まれても乗っ取られることのないようにpassword_hashメソッドでハッシュ化してDBへ保存し、password_verifyメソッドでPOSTされたパスワードの文字列をハッシュ化したものがDBと一致するか確認する。
    password_hashメソッド => password_hash($password , $algo , $options)

    以前はハッシュ化メソッドにmd5(), sha1()が使われていたが、データの値が同じであれば同じハッシュ値を生成する欠点がある。レインボーテーブルによる復元が可能 => https://it-trend.jp/encryption/article/64-0067

    password_hashメソッドはハッシュ化したパスワードにランダムな文字列を加えて一意性にするソルトという手法を用いている。

    password_hashメソッドのアルゴリズム(bcrypt)について  https://medium-company.com/bcrypt/
      DBに保存されている値 => $2y$10$n.PPvod4ai0r0qpqn5DurenOoxTyRhvef3S7DxoMu5BLRspG5oiBK
      上記を項目毎に分ける
      $2y$ => アルゴリズム(bcrypt)
      $10$ => コスト(ストレッチング回数 10 => 2の10乗を表す。1024回)
      PPvod4ai0r0qpqn5DurenO => ソルト(22文字の平文)
      oxTyRhvef3S7DxoMu5BLRspG5oiBK => パスワードにソルトを加えてからハッシュ計算されたもの

      * ストレッチング => ハッシュ関数を用いてハッシュ値への計算を数千回～数万回繰り返し行うこと
      https://tadtadya.com/php-use-password-hash-function/
  */
?>

