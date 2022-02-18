<?php
  namespace lib;
  use db\UserQuery;

  class Auth {
    public static function login($id, $pwd) {
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
          $_SESSION['user'] = $user;
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

            password_hashメソッドのアルゴリズムについて  https://medium-company.com/bcrypt/
              DBに保存されている値 => $2y$10$n.PPvod4ai0r0qpqn5DurenOoxTyRhvef3S7DxoMu5BLRspG5oiBK
              上記を項目毎に分ける
              $2y$ => アルゴリズム(bcrypt)
              $10$ => コスト(ストレッチング回数 10 => 2の10乗を表す。1024回)
              PPvod4ai0r0qpqn5DurenO => ソルト(22文字の平文)
              oxTyRhvef3S7DxoMu5BLRspG5oiBK => パスワードにソルトを加えてからハッシュ計算されたもの

              * ストレッチング => ハッシュ関数を用いてハッシュ値への計算を数千回～数万回繰り返し行うこと
              https://tadtadya.com/php-use-password-hash-function/
          */
        } else {
          echo 'パスワードが一致しません <br>';
        }
      } else {
        echo 'ユーザーが見つかりません <br>';
      }
      return $is_success;
    }
  }
?>