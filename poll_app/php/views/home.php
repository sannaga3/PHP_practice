<?php
  namespace view\home;

  function index($topics) {
    $topics = escape($topics);
    $first_topic =  array_shift($topics);  //  array_shiftメソッドで $topics の０番目を削除して返すことで、$topicsから分離する

    \partials\topic_header_item($first_topic, true); // true は $from_top_page。トップページからログインして遷移してきた場合は、最初のトピックに詳細ページへのリンクを付与する
?>
    <ul class="container">
      <?php
        foreach ($topics as $topic) {
          $url = get_url('topic/detail?topic_id=' . $topic->id);
          \partials\topic_list_item($topic, $url, false);
        }
      ?>
    </ul>
<?php } ?>