<?php
  var_dump($_POST);
  echo '<br>';
  $num = $_POST['num'];
  $price = $_POST['price'];
  $discount = $_POST['discount'];   // hidden_field
  $sum = $num * $price;
  $sum -= $sum * $discount / 100;
  echo 'amount : ' . round($sum);
?>