<!-- Todoリスト作成 -->
<?php
session_start();
$self_url = $_SERVER['PHP_SELF'];   // フルパスを変数に格納
?>

<form action="<?php echo $self_url; ?>" method="POST"> <!-- 自身のURLをリロード -->
  <input type="text" name="title">
  <input type="submit" name="type" value="create">
</form>

<?php
// パラメータにtypeが設定されている場合、値に応じて処理を分岐する
if(isset($_POST['type'])) {
  if($_POST['type'] === 'create') {
    $_SESSION['todos'][] = $_POST['title'];
    echo 'added new task : ' . $_POST['title'];
  } else if($_POST['type'] === 'update') {
    $_SESSION['todos'][$_POST['id']] = $_POST['title'];
    echo 'task' . $_POST['id'] . ' was updated';
  } else if ($_POST['type'] === 'delete') {
    array_splice($_SESSION['todos'], $_POST['id'], 1);
    echo 'task' . $_POST['id'] . ' was deleted';
  }
}

if(empty($_SESSION['todos'])) {      // セッションにタスクが設定されていなければ、todosを配列として作成し、タスク追加の準備をする
  $_SESSION['todos'] = [];
  echo 'please input a task';
  die();                             // スクリプトを終了させる。プログラム中に挿入することで、その行まで正しく動作するか確認できる。
}
?>

<ul>
  <?php for($i = 0; $i < count($_SESSION['todos']); $i++): ?>
    <li>
      <form action="<?php echo $self_url; ?>" method="POST">
        <input type="hidden" name="id" value="<?php echo $i; ?>">        <!-- セッションのidを隠しフィールドで格納 -->
        <input type="text" name="title" value="<?php echo $_SESSION['todos'][$i] ?>">  <!-- セッションに格納されているタイトルの編集欄を表示 -->
        <input type="submit" name="type" value="delete">
        <input type="submit" name="type" value="update">
      </form>
    </li>
  <?php endfor;?>
</ul>