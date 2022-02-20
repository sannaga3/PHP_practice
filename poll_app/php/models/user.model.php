<?php
  namespace model;

  class UserModel extends AbstractModel {
    public string $id;
    public string $pwd;
    public string $nickname;
    public int $del_flg;

    protected static $SESSION_NAME = '_user';  // _から始まる変数はメソッドを通じて値を取得すること表す  $_SESSION['_user']
  }
?>