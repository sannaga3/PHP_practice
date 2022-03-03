<?php
  namespace partials;

  function topic_list_item($topic, $title_url, $with_status) {
    /* $with_statusでラベルの表示の有無を指定、topicのpublishedカラム(boolean)でラベルの色を分岐 */
    $published = $topic->published ? '公開' : '非公開';
    $label_class = $topic->published ? 'badge-primary' : 'badge-danger';
?>
  <li class="topic row bg-white shadow-sm my-3 rounded p-3">
    <div class="col-md d-flex align-items-center">
      <h2 class="mb-2 mb-md-0">
        <?php if ($with_status) : ?>
          <span class="badge <?php echo $label_class; ?> align-bottom"><?php echo $published ?></span>
        <?php endif;?>
        <a href="<?php echo $title_url; ?>" class="text-secondary"><?php echo $topic->title; ?></a>
      </h2>
    </div>
    <div class="col-auto mx-auto">
      <div class="text-center row">
        <div class="view col-auto min-w-100">
          <div class="h1 mb-0"><?php echo $topic->views ?></div>
          <div class="mb-0">Views</div>
        </div>
        <div class="agree col-auto min-w-100 like-green">
          <div class="h1 mb-0"><?php echo $topic->likes ?></div>
          <div class="mb-0">賛成</div>
        </div>
        <div class="disagree col-auto min-w-100 dislike-red">
          <div class="h1 mb-0"><?php echo $topic->dislikes ?></div>
          <div class="mb-0">反対</div>
        </div>
      </div>
    </div>
  </li>
<?php } ?>

