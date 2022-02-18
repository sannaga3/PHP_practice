<h1>ログインページ</h1>
<!-- 自身のURLに対してPOSTメソッドをリクエストする -->
<form action="<?php echo CURRENT_URI; ?>" method="POST">
  <div>
    id : <input type="text" name="id">
  </div>
  <div>
    pw : <input type="password" name="pwd">
  </div>
  <div>
    <input type="submit" id="ログイン">
  </div>
</form>
