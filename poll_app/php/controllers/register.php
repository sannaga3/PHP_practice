<?php
  namespace controller\register;

  use lib\Auth;
  use model\UserModel;

  function get() {
    require_once SOURCE_PATH . 'views/register.php';
  }
  function post(){
    /* 登録したユーザのインスタンス生成 */
    $user = new UserModel;
    $user->id = get_param('id', '');
    $user->pwd = get_param('pwd', '');
    $user->nickname = get_param('nickname', '');

    if(Auth::regist($user)) {
      echo '登録成功';
    } else {
      echo '登録失敗';
    }
  }
?>