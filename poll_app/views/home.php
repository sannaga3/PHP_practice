<?php
  require_once '../config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/index.css">    <!-- 定数を扱った記述も可能  <link rel="stylesheet" href="<? // php echo BASE_CSS_PATH . "index.js" ?>"> -->
  <title>Document</title>
</head>
<body>
  <h1>トップページ</h1>
  <img src="<?php echo BASE_IMAGE_PATH . "logo.png" ?>" alt="logo">
  <script src="<?php echo BASE_JS_PATH . "index.js" ?>"></script>
</body>
</html>