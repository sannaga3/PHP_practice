<?php

  /* よく使う関数をヘルパーに部品化する */

  function get_param($key, $default_val, $is_post = true) {
    $arry = $is_post ? $_POST : $_GET;
    return $arry[$key] ?? $default_val;
  }

  /* home , login, その他のパスへのリダイレクト分岐 */
  function redirect($path) {
    if ($path === GO_HOME) {
      $path = get_url('');
    } elseif ($path === GO_REFERER) {
      $path = $_SERVER['HTTP_REFERER'];
    } else {
      $path = get_url($path);
    }
    header("location: {$path}"); //  header関数、ログイン後のリダイレクト処理。リダイレクト後に処理が続かないようにする必要がある。  https://www.php.net/manual/ja/function.header.php
    die();
  }

  function get_url($path) {
    return BASE_PATH . trim($path, '/');  // 先頭と末尾の / を取り除くことで、BASE_PATHと被らないようにする
  }

  function show_url($path) {
    echo get_url($path);
  }

  function is_alnum($val) {
    return !preg_match("/^[a-zA-Z0-9]+$/", $val);
  }

  function escape($data) {
    if (is_array($data)) {
      /* 配列の個々の値を取得し、エスケープする */
      foreach($data as $prop => $val) {
        $data[$prop] = escape($val);
      }
      return $data;
    } elseif (is_object($data)) {
      /* オブジェクトの個々のプロパティ値を取得し、エスケープする */
      foreach($data as $prop => $val) {
        $data->$prop = escape($val);
      }
      return $data;
    } else {
      /* htmlをエスケープする */
      return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
  }
?>