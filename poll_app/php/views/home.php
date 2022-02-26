<?php
  namespace view\home;

  function home() {
?>
<h1>TOPページ</h1>
<form action="<?php echo BASE_PATH . 'login'; ?>" method="POST">
    <input type="submit">
</form>
  <?php } ?>