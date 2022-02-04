<?php
  namespace lib;

  const TAX_RATE3 = 0.1;

  function with_tax2($base_price, $tax_rate = 0.1) {
    $sum_price = $base_price + ($base_price * $tax_rate);
    return $sum_price = round($sum_price);
  }
  \global_echo();                     // 名前空間からグローバル空間の関数を呼び出す時は \ を先頭につける
  $global_class = new \GlobalClass(); // 上記と同様にクラスを呼び出すときも \　が必要
  $global_class->class_exception();   // クラスメソッド呼び出し
?>