<?php
  /* Product テーブルをクラス化し、モデルとして扱う */
  namespace model;

  class ProductModel {
    public int $id;
    public string $name;
    public int $delete_flg;

    public function echo_product_name() {
      echo "product_name : {$this->name}";
    }
  }

?>