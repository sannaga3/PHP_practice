<form action="<?php $_SERVER['REQUEST_URI']; ?>" method="POST">
  Shop ID : <input type="text" name="shop_id">
  <input type="submit" value="検索">
</form>

<?php
if(isset($_POST['shop_id'])) {
  try {
    $shop_id = $_POST['shop_id'];
    $user = 'test_user';
    $pwd ='pwd';
    $host = 'localhost';
    $dbName = 'test_phpdb';

    $dsn = "mysql:host={$host};port=8889;dbname={$dbName};";
    $conn = new PDO($dsn, $user, $pwd);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);   // エミュレート機能のプリペアドステートメント機能をオフにする
    // $pst = $conn->query("select * from test_phpdb.mst_shops where id = {$shop_id};");    // query、execメソッドではSQLインジェクションを防げない
    $pst = $conn->prepare("select * from test_phpdb.mst_shops where id = :id;");    // prepareメソッド   prepare(string $query, array $options = [])  * optionは key=>value の組み合わせ   https://www.php.net/manual/ja/pdo.prepare.php
    // $pst->bindValue(':id', $shop_id, PDO::PARAM_INT);    //  bindValue(パラメータ, 値, データ型)     https://www.php.net/manual/ja/pdostatement.bindvalue.php
    // bindValuedで PDO::PARAM_INT とデータ型を指定しているため、1;truncate sample_data で検索をかけても整数値の 1 しか値を受け付けない
    // $pst->execute();    // ここでSQLを実行する
    $pst->execute([':id' => $shop_id]);    // bindValueと併せて記述する
    $result = $pst->fetch();               // 結果が０の場合falseが返る

    if(!empty($result) && count($result) > 0) {
      echo "店舗名 : {$result['name']}";
    } else {
      echo '該当店舗が見つかりませんでした';
    }
  } catch(PDOException $e) {
    echo 'エラーが発生しました';
  }
}

/*
  プリペアドステートメントとエミュレート機能   http://code-php.com/php-db/ps-emulate/

  エミュレート機能により、プリペアドステートメント機能を持たないDBであってもphp側でプリペアドステートメント機能を実装できる。
  実際はエミュレート機能には脆弱性があり、無効化していることが多い。

*/

/*
  query、prepareの違い https://blog.senseshare.jp/query-prepare.html

  query  =>  SQL文のセット、パラメータのセット、SQLの実行、この3工程を全て行う

  prepareでは上記の3工程を分割することで、パラメータをプレースホルダー化する
  prepare   =>  SQL文のセット(DBにSQL文を伝え、Pre-compiled状態にする)  select * from test_phpdb.mst_shops where id = :id;
  bindValue =>  パラメータのセット                                    :id => 1
  execute   =>  SQLの実行

  * Pre-compiled状態にすることで、同じクエリを何度も使う場合、構文チェックなどの手間を省略できパフォーマンスが上がる
*/

/*
  DBに以下のSQLを流し、SQLインジェクション用のテーブル sample_table を作成する。

  create table sample_data (id int(10) unsigned auto_increment primary key);
  insert into sample_data values (1),(2),(3),(4),(5),(6),(7),(8),(9);
  select * from sample_data;

  フォームに 1;truncate sample_data と入力して検索ボタンを押し、ログファイルを見てみる。
  ; で区切られ、以下2つのSQLが実行されたのが確認できる。select * from sample_data するとレコードが全て削除されている;

  2022-02-14T03:36:59.005927Z       184 Query     select * from test_phpdb.mst_shops where id = 1;
  2022-02-14T03:36:59.013864Z       184 Query     truncate sample_data

*/
?>
