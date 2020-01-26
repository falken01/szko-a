<?php
session_start();
require_once "connect.php";
$polaczenie = new mysqli($host,$db_user,$db_password,$db_name);

$id = $_SESSION['id'];
$start = $_POST['godzinastart'];
$stop = $_POST['godzinastop'];
$opis = $_POST['opis'];
$opis = base64_encode($opis);
$date = $_POST['data'];


if($start > 0 && $start < 24 && $stop>0 && $stop<24 && $stop>$start && strlen($opis)<250)
{
  if(isset($_POST['all']))
  {
  $polaczenie -> query("INSERT INTO harmonogram VALUES (NULL,'$date','$start','$opis','$stop',0)");
  $_SESSION['ok'] = "<div class='alert alert-success' role='alert'>Poprawnie dodano wpis do harmonogramu</div>";
  header('Location: harmonogram.php');
} else{
  $polaczenie -> query("INSERT INTO harmonogram VALUES (NULL,'$date','$start','$opis','$stop','$id')");
  $_SESSION['ok'] = "<div class='alert alert-success' role='alert'>Poprawnie dodano wpis do harmonogramu</div>";
  header('Location: harmonogram.php');
}
} else {
  $_SESSION['ok'] = "<div class='alert alert-danger' role='alert'>Błędnie wprowadzone dane</div>";
  header('Location: harmonogram.php');
}

 ?>
