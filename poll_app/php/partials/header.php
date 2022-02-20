<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?php echo BASE_CSS_PATH . 'index.css' ?>">
  <title>アンケート</title>
</head>
<body>
  <?php
    use lib\Auth;
    use lib\Msg;

    Msg::flush();

    /* メソッドによるログイン判定 */
    if (Auth::isLogin()) {
      echo 'ログイン中です';
    } else {
      echo 'ログインしていません';
    }
  ?>