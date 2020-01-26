<?php
  session_start();

  require_once "connect.php";
  $polaczenie = new mysqli($host,$db_user,$db_password,$db_name);

  $area = $_POST['area'];
  $autor = $_POST['autor'];

  if($polaczenie -> query("UPDATE cytat SET texkt='$area', autor='$autor' WHERE id=1"))
  {
    $_SESSION['ok']="<div class='alert alert-success' role='alert'>Poprawnie zaktualizowano cytat na stronie głównej Panie Faltyn.</div>";
    header("Location: index.php");
  } else {
    echo "zjebało się 2";
  }

 ?>
