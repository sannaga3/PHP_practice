<?php
  /* DBへのアクセス設定とデータベースへの接続 */
  $user = 'test_user';
  $pwd = 'pwd';
  $host = 'localhost';
  $dbName = 'test_phpdb';

  $dsn = "mysql:host={$host};port=8889;dbname={$dbName};";    /*  https://www.php.net/manual/ja/ref.pdo-mysql.connection.php */

  /* PDOクラスブジェクト($conn)の作成。オブジェクト作成時にDBへ接続する。以降は$connにクエリを投げていく https://www.javadrive.jp/php/pdo/index2.html */
  /* PDOクラスブジェクトによる接続はPHP5.1以降で使用可能 https://www.toumasu-program.net/entry/2019/12/20/102903/ */
  try{
    $conn = new PDO($dsn, $user, $pwd);
  }catch (PDOException $e){
      print('Connection failed:'.$e->getMessage()); /* PDOクラスブジェクト作成失敗時の例外処理 */
      die();
  }

  /* POD::setAttributeメソッドでPDOStatement::fetchAllメソッドのデフォルトのスタイル(PDO::FETCH_BOT)を変更する  https://qiita.com/mpyw/items/b00b72c5c95aac573b71 */
  // $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

  /* ここから上はDB接続 ここから下はクエリ */


  /* DBから値を取得ここから */

  echo '-------------------------------------------------------------------------------------';

  $pst = $conn->query('select * from mst_prefs');   /* クエリを変数に格納 */
  // $result = $pst->fetchAll();                    /* クエリ変数を実行し、表示方法を引数に記述。引数なし => FETCH_BOTH(カラム名＆index番号) デフォルト設定 */
  $result = $pst->fetchAll(PDO::FETCH_ASSOC);       /* 引数がFETCH_ASSOC => カラム名のみ */

  echo '<pre>';            /* preで囲むと改行も読み込んでくれるので見やすくなる */
  print_r($result);
  echo '</pre>';

  echo '-------------------------------------------------------------------------------------';

  $pst2 = $conn->query('select name, pref_id from mst_shops');
  $result2 = $pst2->fetchAll(PDO::FETCH_KEY_PAIR);       /* 引数がFETCH_KEY_PAIR => key => valueの形で出力(クエリでの取得を２カラムに指定する必要あり)  */

  echo '<pre>';
  print_r($result2);
  echo '</pre>';

  echo '-------------------------------------------------------------------------------------';

  $pst3 = $conn->query('select name from mst_shops');
  $result3 = $pst3->fetchAll(PDO::FETCH_COLUMN);       /* 引数がFETCH_COLUMN => 1つのカラムだけを1次元配列で取得 */

  echo '<pre>';
  print_r($result3);
  echo '</pre>';

  /* DBから値を取得ここまで */


  /* レコードの値を更新ここから */

  echo '-------------------------------------------------------------------------------------';

  $result4 = $conn->exec('update mst_prefs set name = "沖縄" where id = 5;');  /* PDO::execメソッド。クエリを実行し、影響を受けた行数を返す。SELECT 文には使えない。  https://www.php.net/manual/ja/pdo.exec.php */
  /* VScodeのターミナルで tail -f -n 100  /Applications/MAMP/logs/mysql_query.log しておくと ctrl + F でupdateのクエリを探すのが簡単 */

  echo '<pre>';
  print_r($result4);
  echo '</pre>';

  /* レコードの値を更新ここまで */

  /* 例外処理ここから */

  // echo '------------------------------------------------------------------------------------- <br>';

  // try {         /* 実行文 */
  //   $bool = false;
  //   // $bool->method();     /* あえてエラーを起こす */

  //   new PDO('', '', '');
  //   echo '通常処理が終了 <br>';

  // } catch(PDOException $e) {  /* エラー文 */

  //   echo 'PDOException <br>';
  //   echo '例外処理です。 error message : ';
  //   echo $e->getMessage() . '<br>';
  //   echo get_class($e) . '<br>';

  // } catch(Error $e) {

  //   echo 'Error <br>';
  //   echo '例外処理です。 error message : ';
  //   echo $e->getMessage() . '<br>';

  // } finally {   /* tryの成功失敗に関わらず実行する文 */

  //   echo '終了処理が実行されました <br>';

  // };

  // echo '------------------------------------------------------------------------------------- <br>';

  // function throwException2() {
  //   $bool = false;
  //   $bool->method();         /* tryの内部で処理されているため、エラーが返り値として catch に渡り、エラーにならない */
  //   new PDO('', '', '');
  //   echo '関数が終了しました';
  // }

  // try {

  //   echo '通常処理開始2 <br>';
  //   throwException2();
  //   echo '通常処理が終了 <br>';

  // } catch(Error $e) {

  //   echo 'Error <br>';
  //   echo '例外処理です。 error message : ';
  //   echo $e->getMessage() . '<br>';

  // } finally {   /* tryの成功失敗に関わらず実行する文 */

  //   echo '終了処理が実行されました <br>';

  // };

  // echo '------------------------------------------------------------------------------------- <br>';

  // function throwException3() {
  //   try {
  //     $bool = false;
  //     $bool->method();         /* 関数内のtryでキャッチできない場合は上位層へ返る */
  //     echo '関数が終了しました';

  //   } catch(PDOException $e) {

  //     echo 'PDOException <br>';
  //     echo '例外処理です。 error message : ';
  //     echo $e->getMessage() . '<br>';
  //   }
  // }

  // try {

  //   echo '通常処理開始3 <br>';
  //   throwException3();
  //   echo '通常処理が終了 <br>';

  // } catch(Error $e) {

  //   echo 'Error <br>';
  //   echo '例外処理です。 error message : ';
  //   echo $e->getMessage() . '<br>';
  //   echo get_class($e) . '<br>';

  // } finally {   /* tryの成功失敗に関わらず実行する文 */

  //   echo '終了処理が実行されました <br>';

  // };


  // /* 例外クラス ExceptionとErrorの違い https://qiita.com/mpyw/items/c69da9589e72ceac470c  https://www.utakata.work/entry/20181115/1542245529 */
  // /* Throwableインターフェス(php7から実装)をを頂点として、それを継承した Error と Exceptionクラスが実質の最上位クラスとして存在する。 */
  // /* Exceptionクラス phpで処理するエラーを補足する場合は、基本的にこのクラス、もしくはこのクラスを継承したサブクラスを用いる。 */
  // /* Errorクラス  php7から実装。 ParseErrorやTypeErrorなどが含まれる。文法ミスによるエラーのため、キャッチせずにコード修正すれば良い */

  echo '------------------------------------------------------------------------------------- <br>';

  $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);       /* PDOの例外エラーを詳細にしてくれるオプション。select文などのSQLのエラーが詳細になる https://www.toumasu-program.net/entry/2019/12/20/102903/ */

  try {

    // $get_store_c_id = $conn->query('select id from mst_shops where name = "店舗A"');
    // $store_c_id = $get_store_c_id->fetchAll(PDO::FETCH_ASSOC);
    // print_r($store_c_id);

    $update_rows = $conn->exec('update txn_stocks ts set ts.amount = ts.amount + 10 where shop_id = 1');
    echo $update_rows . '<br>';
    echo '処理終了';

  } catch(PDOException $e) {

    echo 'PDOException <br>';
    echo '例外処理です。 error message : ';
    echo $e->getMessage() . '<br>';
  }

  echo '------------------------------------------------------------------------------------- <br>';

  // try {


  // } catch(Exception $e) {


  // };


  /* 例外処理ここまで */

  /* DBとの接続を破棄 PDOの場合自動的に接続が切断されるが、接続方式によっては必須 */
  $conn = null;
?>