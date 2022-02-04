<?php
  $students = [
    '1' => [
        'name' => 'taro',
        'age' => 15,
    ],
    '2' => [
        'name' => 'hanako',
        'age' => 14,
    ],
    '3' => [
        'name' => 'jiro',
        'age' => 12,
    ],
  ];

  $id = $_GET['id'] ?? 1;     // idが振られてなければ１とする
  $student = $students[$id];  // $student一覧からparamのid
  $name = $student['name'];
  $age = $student['age'];

  print_r($students);
  //  URL末尾を　/index.php?id=3 などで 出力するstudentの切り替えができる
?>
<div><?php echo "{$name}は{$age}です"; ?></div>