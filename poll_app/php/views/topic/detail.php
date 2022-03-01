<?php
  namespace view\topic\detail;

  function index($topic, $comments) {
    $topic = escape($topic);
    $comments = escape($comments);

    \partials\topic_header_item($topic, false); // トップページから遷移していない為第二引数はfalse
?>
    <div class="py-5">
      <ul class="list-unstyled my-5">
        <?php foreach($comments as $comment) :
          $is_agree = $comment->agree ? '賛成' : '反対';
          $agree_class = $comment->agree ? 'badge-success' : 'badge-danger';
        ?>
          <li class="bg-white shadow-sm mb-3 rounded p-3">
            <div class="d-flex flex-column">
              <h2 class="h4">
                <span class="badge <?php echo $agree_class; ?> align-bottom"><?php echo $is_agree; ?></span>
                <span class="text-secondary"><?php echo $comment->body; ?></span>
              </h2>
              <span>Commented by <?php echo $comment->nickname; ?></span>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
<?php } ?>