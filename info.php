<?php
session_start();
require_once "connect.php";
$polaczenie = new mysqli($host,$db_user,$db_password,$db_name);
if(isset($_POST['info']))
{

  $dodano = $_SESSION['user'];
  $info = $_POST['info'];
  $info = htmlentities($info, ENT_QUOTES, "UTF-8");
  if(strlen($info)>250 || $info=="")
  {
  $_SESSION['ok'] = "Przekroczono długość łańcucha lub nic nie wpisano";
  header("Location: index.php");
  }
  else if($polaczenie -> query("INSERT INTO informacje VALUES (NULL,'$info',now(),'$dodano')"))
  {
    $id = $_SESSION['id'];
    $polaczenie -> query("UPDATE userzy SET punkty = punkty + 2 WHERE id = $id");
    $_SESSION['ok'] = "<div class='alert alert-success' role='alert'>Poprawnie dodano wpis.</div>";
    header("Location: wpisy.php");
  }
  else {
    echo "Zjebało się";
    echo $polaczenie->error;
  }
}
?>
