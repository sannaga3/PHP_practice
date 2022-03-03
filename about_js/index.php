<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <?php
    /* phpでは'0'はfalsy, javascriptではtruthy    https://zenn.dev/bugbearr/articles/69e1101ccc676a4b28b6*/
    $i = 0;
    $array1 = ['a', 'b', 'c', '0', 1];
    while($a = $array1[$i++]){
      echo "<div id='element$i'>$a</div>";
    }
  ?>
    <div></div>
  <script src="index.js"></script>
</body>
</html>