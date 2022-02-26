<?php
  namespace partials;

  use lib\Auth;
  use lib\Msg;

  function header() {

  /* メソッドによるログイン判定 */
  // if (Auth::isLogin()) {
  //   echo 'ログイン中です';
  // } else {
  //   echo 'ログインしていません';
  // }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>アンケート</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="//fonts.googleapis.com/css2?family=Source+Code+Pro:ital,wght@1,600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php echo BASE_CSS_PATH . 'index.css' ?>">
</head>
<body>
  <div id="container">
    <header class="container my-2">
      <nav class="row align-items-center py-2">
        <a href="<?php show_url('/'); ?>" class="col-md d-flex align-items-center mb-3 mb-md-0">
          <img src="<?php echo BASE_IMAGE_PATH . 'logo.png' ?>" alt="みんなのアンケート サイトロゴ" width="50px" class="mr-2">
          <span class="h2 font-weight-bold font-source-code-pro mb-0">みんなのアンケート</span>
        </a>
        <div class="col-md-auto d-flex align-items-center">
          <?php // ログイン・ログアウト時のnavを分岐 ?>
          <?php if(Auth::isLogin()) : // {} の代わりに : と endif; を使うことができる  https://www.flatflag.nir87.com/if-257 ?>
            <a href="<?php show_url('topic/create'); ?>" class="mr-3">投稿</a>
            <a href="<?php show_url('topic/archive'); ?>" class="mr-3">過去の投稿</a>
            <a href="<?php show_url('logout'); ?>" class="btn btn-outline-info shadow-sm mr-3">ログアウト</a>
          <?php else: ?>
            <a href="<?php show_url('register'); ?>" class="btn btn-primary shadow-sm mr-3">サインアップ</a>
            <a href="<?php show_url('login'); ?>">ログイン</a>
          <?php endif; ?>
        </div>
      </nav>
    </header>
    <main class="container py-3">
<?php
    Msg::flush();
  }
?>