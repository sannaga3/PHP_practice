<?php
session_start();

// httpリクエストにユーザ名とパスワードがあれば、それをセッションに格納する
if(isset($_POST['username'])
  && isset($_POST['pwd'])
  && $_POST['username'] === 'test'
  && $_POST['pwd'] === 'pwd'
) {
    $_SESSION['user'] = [
      'name' => $_POST['username'],
      'pwd' => $_POST['pwd']
    ];
}

if(!empty($_SESSION['user'])) {
  echo 'logging in';
} else {
  echo 'not logged in';
}
?>