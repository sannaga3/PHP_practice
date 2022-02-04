<div>
  名前：<?php echo $_GET['username']; ?>    <!-- $_GET変数  HTTP GET メソッドで送信された値を取得する -->
</div>

<div>
  パスワード：<?php echo $_GET['password']; ?>
</div>

<?php
  // GETで送信された値を全て取得
  foreach($_GET as $key => $value) {
    echo $key . ' : ' . $value . '<br>';
  }
?>


<form action="post.php" method='POST'>
  <input type="text" name='username'>
  <input type="password" name='password'>
  <input type="submit" value='push'>
</form>