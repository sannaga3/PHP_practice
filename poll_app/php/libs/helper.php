<?php
  function get_param($key, $default_val, $is_post = true) {
    $arry = $is_post ? $_POST : $_GET;
    return $arry[$key] ?? $default_val;
  }
?>