<form action="<?php $_SERVER['REQUEST_URI']; ?>" method="POST">
  product ID : <input type="text" name="product_id">
  <input type="submit" value="検索">
</form>


<?php
  require_once 'product_model.php';
  require_once 'db_class.php';
  use db\DataSource;
  use model\ProductModel;

  try {
    if(isset($_POST['product_id'])) {
      $db = new DataSource();
      $product_id = $_POST['product_id'];
      $sql = "select name, delete_flg from mst_products where id = :id and delete_flg = 0";

      /*
        第3引数の $type に DataSourceクラス自身の静的プロパティを持たせることで、selectOne関数内の条件分岐を指定する。
        第4引数では ClassName::class で名前空間つきのパスを文字列で取得している => "model\ProductModel"    https://suzuki.tdiary.net/20140312.html。
      */
      $result = $db->selectOne($sql, [':id' => $product_id], DataSource::CLS, ProductModel::class);
      // var_dump(ProductModel::class);
      // var_dump($result);
      // echo get_class($result) . '<br>';     クラス名は名前空間付きで扱われている
      if (!empty($result)) {
        // echo "product_name : {$result->name} <br>";
        $result->echo_product_name();
      } else {
        echo 'not found any product <br>';
      }
    }
  } catch(PDOException $e) {
    echo '<pre>';
    echo "error : {$e} <br>";
    echo '</pre>';
  }
?>