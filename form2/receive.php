<?php
  print_r($_POST['account']);
  echo '<br>';
  $account = $_POST['account'];
  $id = $account['id'];
  echo 'id : ', $id, '<br>';
  echo 'name : ', $account['name'], '<br>';
  echo 'pwd : ', $account['pwd'], '<br>';
?>