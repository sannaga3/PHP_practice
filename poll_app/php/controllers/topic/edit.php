<?php
  namespace controller\topic\edit;

  use lib\Auth;
  use model\TopicModel;
  use model\UserModel;
  use db\TopicQuery;
  use Throwable;
  use lib\Msg;

  function get() {
    Auth::requireLogin();
    $topic = TopicModel::getSessionAndFlush();

    /* エラーでリダイレクトした時は getSessionAndFlushメソッド でインスタンスを取得している為、再度viewを表示するだけで良い */
    if (!empty($topic)) {
      \view\topic\edit\index($topic, true);
      return;
    }

    $topic = new TopicModel;
    $topic->id = get_param('topic_id', null, false);
    $user = UserModel::getSession();
    $fetchTopic = TopicQuery::fetchById($topic);

    /* トピックのユーザidがログインユーザ自身のidでなければ、編集ページへ遷移せずに権限がないと表示する */
    Auth::requirePermission($topic->id, $user);
    \view\topic\edit\index($fetchTopic, true);
  }

  function post() {
    Auth::requireLogin();
    $topic = new TopicModel;
    $topic->id = get_param('topic_id', null);
    $topic->title = get_param('title', null);
    $topic->published = get_param('published', null);
    $user = UserModel::getSession();

    Auth::requirePermission($topic->id, $user);

    try {
      $is_success = TopicQuery::update($topic);
    } catch(Throwable $e) {
      Msg::push(Msg::DEBUG, $e->getMessage());
      $is_success = false;
    }

    if ($is_success) {
      Msg::push(Msg::INFO, 'トピックを更新しました');
      redirect('topic/archive');
    } else {
      Msg::push(Msg::ERROR, 'トピックの更新に失敗しました');
      TopicModel::setSession($topic);
      redirect(GO_REFERER);
    }
  }
?>