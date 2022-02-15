<?php
  require_once 'db_class.php';
  use db\DataSource;

  try {

    $db = new DataSource();

    $product_id = 1;
    $from_shop_id = 1;
    $to_shop_id = 3;
    $amount = 10;

    $sql = '
      update txn_stocks set amount = amount + :amount
      where shop_id = :shop_id and product_id = :product_id
    ';

    $db->begin_transaction();

    /* 入庫側 */
    $db->execute($sql, [
      ':amount' => $amount,
      ':shop_id' => $to_shop_id,
      ':product_id' => $product_id
    ]);

    /* 出庫側 */
    $db->execute($sql, [
      ':amount' => -1 * $amount,
      ':shop_id' => $from_shop_id,
      ':product_id' => $product_id
    ]);

    $sql2 = '
      select shop_id, product_id, amount from txn_stocks
      where product_id = :product_id;
    ';

    /* 入出庫後の在庫数を表示 */
    $result = $db->select($sql2, [':product_id' => $product_id]);
    echo '<pre>';
    print_r($result);
    echo '</pre>';

    $db->commit();    /* transaction終了 */

  } catch (PDOException $e) {

    echo "error : <br>" ;
    echo $e->getMessage() . '<br>';

  }


?>