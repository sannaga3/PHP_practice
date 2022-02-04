<?php
if(!function_exists('fn3')) { // 外部ファイルの読み込みはグローバルスコープとなるので、ファンクション名の重複に考慮し、function_existsメソッドで確認する
  function fn3() {
    echo 'fn3 is called';
  }
}
$arry['num']++;
?>