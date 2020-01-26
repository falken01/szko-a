<?php
session_start();
require_once "connect.php";
$polaczenie = new mysqli($host,$db_user,$db_password,$db_name);

if($polaczenie -> connect_errno != 0)
{
  echo "Error".$polaczenie->connect_errno." Opis: ".$polaczenie->connect_error;
}

else {
  $login = $_POST['login'];
  $haslo = $_POST['haslo'];

$login = htmlentities ($login, ENT_QUOTES,"UTF-8");
if($rezultat = @$polaczenie -> query(
sprintf("SELECT * FROM userzy WHERE user='%s'",
mysqli_real_escape_string($polaczenie,$login))))
{
  $ilu_userow  = $rezultat->num_rows;
  if ($ilu_userow > 0)
  {

      $wiersz = $rezultat -> fetch_assoc();
      if(password_verify($haslo, $wiersz['pass']))
      {
        $_SESSION['user'] = $wiersz['user'];
        $_SESSION['pkt'] = $wiersz['punkty'];
        $_SESSION['id'] = $wiersz['id'];
        $_SESSION['mod'] = $wiersz['moderator'];
        $_SESSION['nazwisko'] = $wiersz['nazwisko'];
        echo $_SESSION['logged'] = "Zostałeś pomyślnie zalogowany. <br> Witaj ".$_SESSION['user'].'.'." Liczba dodanych przez Ciebie wpisów: ".$_SESSION['pkt'];
        unset($_SESSION['blad']);
        $rezultat -> free_result();
        header ('Location: index.php');
      }
      else {
              $_SESSION['blad'] = '<span style="color:red"> Wprowadź poprawne dane </span>';
              header ('Location: index1.php');
           }
  }
  else {
          $_SESSION['blad'] = '<span style="color:red"> Wprowadź poprawne dane </span>';
          header ('Location: index1.php');
       }


}


  $polaczenie -> close();
}
 ?>
