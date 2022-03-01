<?php
  namespace controller\topic\create;

  use lib\Auth;
  use model\TopicModel;
  use model\UserModel;
  use db\TopicQuery;
  use Throwable;
  use lib\Msg;

  function get() {
    Auth::requireLogin();
    $topic = TopicModel::getSessionAndFlush();

    if (empty($topic)) {
      $topic = new TopicModel;
      $topic->id = -1;
      $topic->title ='';
      $topic->published = 0;
    }

    \view\topic\edit\index($topic, false);
  }

  function post() {
    Auth::requireLogin();
    $topic = new TopicModel;
    $topic->id = get_param('topic_id', null);
    $topic->title = get_param('title', null);
    $topic->published = get_param('published', null);
    $user = UserModel::getSession();;

    try {
      $is_success = TopicQuery::insert($topic,$user);
    } catch(Throwable $e) {
      Msg::push(Msg::DEBUG, $e->getMessage());
      $is_success = false;
    }

    if ($is_success) {
      Msg::push(Msg::INFO, 'トピックを作成しました');
      redirect('topic/archive');
    } else {
      Msg::push(Msg::ERROR, 'トピックの作成に失敗しました');
      /* セッションにフォームの値を格納し、getでリダイレクトされた後に再度表示可能にする */
      TopicModel::setSession($topic);
      redirect(GO_REFERER);
    }
  }
?>