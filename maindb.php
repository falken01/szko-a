<?php
session_start();
require_once "connect.php";
$polaczenie = new mysqli($host,$db_user,$db_password,$db_name);
if(isset($_POST['delete']))
    {
      $id = $_POST['id'];
      $dodano = $_POST['dodano'];
		$polaczenie -> query("DELETE FROM zadaniamod WHERE id='$id'");
		$_SESSION['ok'] = "<div class='alert alert-success' role='alert'>Poprawnie usunięto rekord z bazy</div>";
    $polaczenie -> query("UPDATE userzy SET punkty = punkty - 1 WHERE user = '$dodano'");
		header("Location: index.php");
	}

else if(isset($_POST['przedmiot']))
{
  $id = $_POST['id'];
  $przedmiot = $_POST['przedmiot'];
  $typ = $_POST['typ'];
  $opis = $_POST['opis'];
  $data = $_POST['data'];
  $dodano=$_POST['dodano'];
  $przedmiot = htmlentities($przedmiot, ENT_QUOTES, "UTF-8");
  $typ = htmlentities($typ, ENT_QUOTES, "UTF-8");
  $opis = htmlentities($opis, ENT_QUOTES, "UTF-8");
  $data = htmlentities($data, ENT_QUOTES, "UTF-8");
if($polaczenie -> query("INSERT INTO zadania VALUES (NULL,'$przedmiot', '$typ','$opis','$data','$dodano')"))
  {
    $polaczenie -> query("DELETE FROM zadaniamod WHERE id='$id'");
    $_SESSION['ok'] = "<div class='alert alert-success' role='alert'> Poprawnie dodano rekord do głównej bazy, Panie ".$_SESSION['nazwisko']."</div>";
    header("Location: index.php");
  }
  else {
    echo "Zjebało się";
    echo $polaczenie->error;
  }
}
 ?>
