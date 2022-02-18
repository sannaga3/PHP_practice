<?php
  namespace controller\register;

  function get() {
    require_once SOURCE_PATH . 'views/register.php';
  }
  function post(){
    echo 'post methodを受け取りました。';
  }
?>