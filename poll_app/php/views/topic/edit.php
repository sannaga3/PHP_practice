<?php
  namespace view\topic\edit;

  /* $is_editでアクションを分岐。true => edit, false => post */
  function index($topic, $is_edit) {
    $header_title = $is_edit ? 'トピック編集' : 'トピック作成';
?>

  <h1 class="h2 mb-3"><?php echo $header_title ?></h1>
  <div class="bg-white p-4 shadow-sm mx-auto rounded">
    <form action="<?php echo CURRENT_URI; ?>" method="POST" class="validate-form" novalidate autocomplete="off">
      <input type="hidden" name="topic_id" value="<?php echo $topic->id; ?>">
      <div class="form-group d-flex flex-column">
        <label for="title">タイトル</label for="title">
        <input type="text" id="title" name="title" value="<?php echo $topic->title; ?>"
          class="form-control validate-target"
          required
          maxlength="30"
          autofocus
        >
          <div class="invalid-feedback"></div>
      </div>
      <div class="form-group d-flex flex-column">
        <label for="published">ステータス</label>
        <select name="published" id="published" class="form-control" required>
          <option value="0" <?php echo $topic->published == 0 ? 'selected' : ''; ?>>非公開</option>
          <option value="1" <?php echo $topic->published == 0 ? '' : 'selected'; ?>>公開</option>
        </select>
      </div>
      <div class="pt-3">
        <input type="submit" class="btn btn-primary" value="送信" disabled>
        <a href="<?php echo show_url('/') ?>" class="btn text-primary ml-2">戻る</a>
      </div>
    </form>
  </div>
<?php } ?>