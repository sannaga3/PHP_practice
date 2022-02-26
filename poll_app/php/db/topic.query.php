<?php
  namespace db;
  use db\DataSource;
  use model\TopicModel;

  class TopicQuery {
    public static function fetchByUserId($user) {
      if (!$user->isValidId()) { return false; }
      $db = new DataSource();
      $sql = 'select * from topics t
              where t.user_id = :id and del_flg != 1
              order by id desc;';
      $result = $db->select($sql, [':id' => $user->id], DataSource::CLS, TopicModel::class);
      return $result;
    }

    public static function insert($id, $pwd, $nickname) {
      $db = new DataSource;
      $sql = 'insert into users(id, pwd, nickname) values (:id, :pwd, :nickname)';
      $pwd = password_hash($pwd, PASSWORD_DEFAULT);
      return $db->execute($sql, [':id' => $id, ':pwd' => $pwd, ':nickname' => $nickname], DataSource::CLS, UserModel::class);
    }
  }
?>