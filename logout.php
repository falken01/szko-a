<?php
  session_start();

  session_unset();
  $_SESSION['out'] = "Wylgowano poprawnie!";
  header('Location: index1.php');


 ?>
