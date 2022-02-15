<form action="<?php $_SERVER['REQUEST_URI']; ?>" method="POST">
  Shop ID : <input type="text" name="shop_id">
  <input type="submit" value="検索">
</form>

<?php
require_once 'db_class.php';
use db\DataSource;     //  namespace の db から DataSource をインポート

if(isset($_POST['shop_id'])) {
  try {
    $shop_id = $_POST['shop_id'];
    $db = new DataSource();
    $result = $db->selectOne("select * from test_phpdb.mst_shops where id = :id;", [':id' => $shop_id]);   // DataSourceのselectメソッドを使う

    if(!empty($result) && count($result) > 0) {
      echo "店舗名 : {$result['name']}";
    } else {
      echo '該当店舗が見つかりませんでした';
    }
  } catch(PDOException $e) {
    echo 'エラーが発生しました';
  }

  echo '<br> ----------------------------------------------------- <br>';

  try {
    $shop_id = $_POST['shop_id'];
    $db = new DataSource();
    $result = $db->select("select * from test_phpdb.mst_shops where id = :id;", [':id' => $shop_id]);

    if(!empty($result) && count($result) > 0) {
      echo "店舗名 : {$result[0]['name']} , ID : {$result[0]['pref_id']}";
    } else {
      echo '該当店舗が見つかりませんでした';
    }
  } catch(PDOException $e) {
    echo 'エラーが発生しました';
  }
}