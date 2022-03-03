<?php
  namespace view\login;

  /* index関数でbody部分を呼べるようにする */
  function index() {
?>
<h1 class="sr-only">ログイン</h1>
<div class="mt-5">
  <div class="text-center mb-4">
    <img src="<?php echo BASE_IMAGE_PATH . 'logo.png' ?>" alt="みんなのアンケート サイトロゴ" width="50px" class="mr-2">
  </div>
  <div class="login-form bg-white p-4 shadow-sm rounded">
    <!-- 自身のURLに対してPOSTメソッドをリクエストする -->
    <form action="<?php echo CURRENT_URI; ?>" method="POST" class="validate-form" novalidate autocomplete="off">
      <div class="form-group">
        <label for="id">ユーザーID</label>
        <input id="id" type="text" name="id" class="form-control validate-target" required maxlength="10" pattern="[a-zA-z0-9]+" autofocus tabindex="1">
        <div class="invalid-feedback"></div>
      </div>
      <div class="form-group">
        <label for="id">パスワード</label>
        <input id="pwd" type="password" name="pwd" class="form-control validate-target" required minlength="4" pattern="[a-zA-z0-9]+" tabindex="2">
        <div class="invalid-feedback"></div>
      </div>
      <div class="d-flex align-items-center justify-content-between">
        <div>
          <input type="submit" value="ログイン" class="btn btn-primary shadow-sm" disabled>
        </div>
        <div>
          <a href="<?php show_url('register') ?>">サインアップへ</a>
        </div>
      </div>
    </form>
  </div>
</div>
<?php } ?>