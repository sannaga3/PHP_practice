<?php
  namespace controller\topic\detail;

  use db\DataSource;
  use lib\Auth;
  use lib\Msg;
  use model\CommentModel;
  use model\TopicModel;
  use model\UserModel;
  use db\TopicQuery;
  use db\CommentQuery;
  use Throwable;

  function get() {
    /* インスタンスを生成 => パラメータからidを取得 => DBから対象レコードを取得 */
    // $topic = TopicModel::getSessionAndFlush();
    // print_r($comment);
    // if (empty($comment)) {
    //   $comment = new CommentModel;
    // }
    // if (empty($topic)) {
    //   $topic = new TopicModel;
    // }
    $topic = new TopicModel;
    $topic->id = get_param('topic_id', null, false);

    TopicQuery::incrementViewCount($topic);

    $fetchTopic = TopicQuery::fetchById($topic);
    $comments = CommentQuery::fetchByTopicId($topic);

    if (!$fetchTopic || !$fetchTopic->published) {
      Msg::push(Msg::ERROR, 'トピックが見つかりません');
      redirect('404');
    }

    \view\topic\detail\index($fetchTopic, $comments);
  }

  function post() {
    Auth::requireLogin();
    $comment = new CommentModel;
    $comment->topic_id = get_param('topic_id', null);
    $comment->body = get_param('body', null);
    $comment->agree = get_param('agree', null);

    $user = UserModel::getSession();
    $comment->user_id = $user->id;

    try {
      /* トピックとコメント2つのテーブル両方へのアクセスが成功した場合のみ処理を実行する為、トランザクションを使用する */
      $db = new DataSource;
      $db->begin();

      /* トピックモデルの賛成・反対の追加が成功した場合にコメントのレコードを作成 */
      $is_success = TopicQuery::incrementLikesOrDislikes($comment);

      if ($is_success && !empty($comment->body)) {
        $is_success = CommentQuery::insert($comment);
      }

    } catch(Throwable $e) {

      Msg::push(Msg::ERROR, $e->getMessage());
      $is_success = false;

    } finally {

      if($is_success) {
        $db->commit();
        Msg::push(Msg::INFO, 'コメントを作成しました');
      } else {
        $db->rollback();
        Msg::push(Msg::ERROR, 'コメント作成に失敗しました');
        Msg::push(Msg::ERROR, $comment);
      }
    }

    redirect('topic/detail?topic_id=' . $comment->topic_id);
  }
?>