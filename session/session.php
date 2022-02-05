<?php
session_start();
if(isset($_SESSION['VISIT_COUNT'])) {
  $_SESSION['VISIT_COUNT'] ++;
} else {
  $_SESSION['VISIT_COUNT'] = 1;
}
echo 'visit' . $_SESSION['VISIT_COUNT'] . 'times';  //  URLへのアクセス回数を表示
?>