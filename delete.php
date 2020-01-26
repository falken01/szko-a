<?php
session_start();
require_once "connect.php";
$polaczenie = new mysqli($host,$db_user,$db_password,$db_name);
if(isset($_POST['id']))
{
  $id = $_POST['id'];
  if($polaczenie -> query("DELETE FROM zadania WHERE id='$id'"))
  {
    $_SESSION['ok'] = "<div class='alert alert-success' role='alert'>Poprawnie usunięto rekord z bazy</div>";
    header("Location: index.php");
  }
  else {
    echo "Zjebało się";
    echo $polaczenie->error;
  }
} else {
  echo "ni ma :9";
}
?>
