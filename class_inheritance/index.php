<?php
  class MyFileWriter {
    private $filename;
    private $content = '';
    public const APPEND = FILE_APPEND;

    function __construct($filename) {
      $this->filename = $filename;
    }
    function append($content) {
      $this->content .= $this->format($content);  // $this->content = $this->content . $content  と同じ
      return $this;
    }
    function newline() {
      $this->content .= PHP_EOL;
      return $this;
    }
    function commit($flag = null) {
      file_put_contents($this->filename, $this->content, $flag);
      $this->content = '';
      return $this;
    }
  }

  // $content = 'Hello, Bob';
  // $content .= PHP_EOL;    // WindowsやLinuxなど環境によって自動で改行コードの出し分けを行う定義済み定数。
  // $content .= 'Bye';
  // $content .= 'Bob. ';
  // $content .= PHP_EOL;
  // // echo $content;   => Hello, Bob ByeBob.

  // file_put_contents('sample.txt', $content);  // file_put_contentsメソッド  $contentの内容をファイルに上書き
  // $content = '';

  // $content = 'Good night, Bob.';

  // file_put_contents('sample.txt', $content, FILE_APPEND); // $contentの内容をファイルに追記
  // $content = '';


  $file = new MyFileWriter('sample.txt');
  // $file->append('Hello, Bob.')
  //      ->newline()
  //      ->append('abcdefgh')
  //      ->commit(MyFileWriter::APPEND);        //　FILE_APPEND　 filename がすでに存在する場合に、データをファイルに上書きするするのではなく追記する

  class LogWriter extends MyFileWriter {
    function format($content) {   // $contentをappendする時に呼び出す
      $time_str = date('Y/m/d H:i:s');
      return sprintf('%s %s', $time_str, $content); // 時刻と追記する内容を出力
    }
  }

  // $time_str = date('Y/m/d H:i:s');
  // sprintf('%s %s', $time_str, '文字列');

  $info = new LogWriter('info.log');     // ログファイルを作成し変数化
  $error = new LogWriter('error.log');   // エラーファイルを作成し変数化

  $info->append('通常ログ')
       ->newline()
       ->commit(LogWriter::APPEND);      // ファイルに追記
  $error->append('エラーログ')
        ->newline()
        ->commit(LogWriter::APPEND);     // ファイルに追記
?>
