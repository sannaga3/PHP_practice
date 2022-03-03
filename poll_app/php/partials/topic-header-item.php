<?php
  namespace partials;

  use lib\Auth;

  function topic_header_item($topic, $from_top_page) {;
?>
    <div class="row justify-content-md-center">
      <div class="col">
        <div class="row justify-content-md-center mb-md-5">
          <?php chart($topic); ?>
        </div>
      </div>
      <div class="col-auto">
          <?php topic_main($topic, $from_top_page); ?>
          <?php comment_form($topic); ?>
      </div>
    </div>
<?php
  }

  function chart($topic) { ?>

    <canvas id="chart" width="400" height="400" data-likes="<?php echo $topic->likes ?>" data-dislikes="<?php echo $topic->dislikes ?>"></canvas>

<?php
  }

  function topic_main($topic , $from_top_page) {  ?>

    <div>
      <?php if ($from_top_page) : ?>
        <h1 class="sr-only">みんなのアンケート</h1>
        <h2 class="h1">
          <a href="<?php show_url('topic/detail?topic_id=' . $topic->id); ?>" class="text-secondary">
            <?php echo $topic->title; ?>
          </a>
        </h2>
      <?php else :?>
        <h2 class="h1"><?php echo $topic->title; ?></h2>
      <?php endif;?>
      <span class="mr-1 h5 font-weight-normal">Commented by テストユーザー</span>
      <span class="mr-1 h5 font-weight-normal">&bull;</span>
      <span class="h5 font-weight-normal"><?php echo $topic->views; ?>views</span>
    </div>
    <div>
      <div class="container">
        <div class="row text-center mt-3">
          <div class="col like-green">
            <div class="display-1"><?php echo $topic->likes; ?></div>
            <div class="h5">賛成</div>
          </div>
          <div class="col dislike-red">
            <div class="display-1"><?php echo $topic->dislikes; ?></div>
            <div class="h5">反対</div>
          </div>
        </div>
      </div>
    </div>
<?php
  }

  function comment_form($topic) { ?>

    <?php if (Auth::isLogin()) : ?>
      <form action="<?php show_url('topic/detail'); ?>" method="POST" novalidate autocomplete="off">
        <span class="h4">あなたは賛成？反対？</span>
        <input type="hidden" name="topic_id" value="<?php echo $topic->id; ?>">
        <div class="form-group">
          <textarea class="w-100 border-light" name="body" id="body" rows="5" maxlength="100"autofocus></textarea>
        </div>
        <div class="container">
          <div class="form-group row h5">
            <div class="col-auto pl-0 d-flex align-items-center">
              <div class="form-check-inline">
                <input type="radio" id="agree" name="agree" value="1" checked required>
                <label for="agree" class="form-check-label">賛成</label>
              </div>
              <div class="form-check-inline">
                <input type="radio" id="disagree" name="agree" value="0">
                <label for="disagree" class="form-check-label">反対</label>
              </div>
            </div>
            <input type="submit" value="送信" class="col btn btn-success shadow-sm">
          </div>
        </div>
      </form>
    <?php else: ?>
      <div class="d-flex flex-column">
        <div class='text-center mt-3 font-weight-bold'>ログインしてください ! !</div>
        <a href="<?php show_url('login'); ?>" class="btn btn-lg btn-success mt-2">ログイン</a>
      </div>
    <?php endif; ?>

<?php } ?>
