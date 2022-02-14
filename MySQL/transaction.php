<?php
  /* トランザクションを用いて商品在庫の店舗移動を行う */

  try {

    $user = 'test_user';
    $pwd ='pwd';
    $host = 'localhost';
    $dbName = 'test_phpdb';

    $dsn = "mysql:host={$host};port=8889;dbname={$dbName};";
    $conn = new PDO($dsn, $user, $pwd);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $product_id = 1;
    $from_shop_id = 3;
    $to_shop_id = 1;
    $amount = 10;

    /* 入出庫のクエリ。:name でパラメータで取得した値に置き換える */
    $pst = $conn->prepare('
      update txn_stocks set amount = amount + :amount
      where shop_id = :shop_id and product_id = :product_id
    ');

    /*
      transaction開始。 shop_id 3 から 1 へ在庫を 10 ずつ移行する。
      shop_id 3 の在庫が無くなった時に出庫側の処理でエラーになるが、先に実行済みの入庫側の処理が反映されないようにトランザクション処理にしておく。
     */
    $conn->beginTransaction();

    /* 入庫側 */
    $pst->execute([
      ':amount' => $amount,
      ':shop_id' => $to_shop_id,
      ':product_id' => $product_id
    ]);

    /* 出庫側 */
    $pst->execute([
      ':amount' => -1 * $amount,
      ':shop_id' => $from_shop_id,
      ':product_id' => $product_id
    ]);

    $conn->commit();    /* transaction終了 */

  } catch (PDOException $e) {

    echo "error : <br>" ;
    echo $e->getMessage() . '<br>';

  }
?>