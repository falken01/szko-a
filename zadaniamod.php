<?php
session_start();
require_once "connect.php";
$polaczenie = new mysqli($host,$db_user,$db_password,$db_name);
if(isset($_POST['przedmiot']))
{
  $dodano = $_SESSION['user'];
  $przedmiot = $_POST['przedmiot'];
  $typ = $_POST['typ'];
  $opis =  $_POST['opis'];
  $data = $_POST['date'];
  $przedmiot = htmlentities($przedmiot, ENT_QUOTES, "UTF-8");
  $typ = htmlentities($typ, ENT_QUOTES, "UTF-8");
  $opis = htmlentities($opis, ENT_QUOTES, "UTF-8");
  $data = htmlentities($data, ENT_QUOTES, "UTF-8");
  if($polaczenie -> query("INSERT INTO zadaniamod VALUES (NULL,'$przedmiot','$typ','$opis','$data','$dodano')"))
  {
    $id = $_SESSION['id'];
    $polaczenie -> query("UPDATE userzy SET punkty = punkty + 1 WHERE id = $id");
    $_SESSION['ok'] = "<div class='alert alert-success' role='alert'>
                        Poprawnie dodano rekord do bazy oczekującej!
                        </div>";
    header("Location: index.php");
  }
  else {
    echo "Zjebało się";
    echo $polaczenie->error;
  }
}
?>
