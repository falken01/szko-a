<?php
	session_start();

	if (isset ($_POST['email']))
	{
    $ok = true;
    $nick = $_POST['nick'];
		//Sprawdzenie długości nicka
		if (strlen($nick) <3 || strlen($nick)>15 )
		{
			$ok = false;
			$_SESSION['e_nick'] = "Nick musi posiadać od 3 do 15 znaków";
		}
    if(ctype_alnum($nick) == false )
		{
			$ok= false;
			$_SESSION['e_nick'] = "Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
		}
    $imie = $_POST['imie'];
    if(ctype_alpha($imie) == false )
		{
			$ok= false;
			$_SESSION['e_imie'] = "Imię może składać się tylko z liter (bez polskich znaków)";
		}
    if (strlen($imie) <3 || strlen($imie)>15 )
		{
			$ok = false;
			$_SESSION['e_imie'] = "Imię musi posiadać od 3 do 20 znaków";
		}
    $nazwisko = $_POST['nazwisko'];
    if(ctype_alpha($nazwisko) == false )
		{
			$ok= false;
			$_SESSION['e_nazwisko'] = "Nazwisko może składać się tylko z liter (bez polskich znaków)";
		}
    if (strlen($nazwisko) <3 || strlen($nazwisko)>25 )
		{
			$ok = false;
			$_SESSION['e_nazwisko'] = "Nazwisko musi posiadać od 3 do 25 znaków";
		}
		// Sprawdź poprawnośc adresu e-mail
    $email = $_POST['email'];

		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);

		if((filter_var($emailB, FILTER_VALIDATE_EMAIL) == false) || ($emailB != $email))
		{
			$ok = false;
			$_SESSION['e_email'] = "Podaj poprawny email";
		}
    $haslo1 =$_POST['haslo1'];
		$haslo2 =$_POST['haslo2'];
		if (strlen($haslo1) <5 || strlen($haslo1) > 20 )
		{
			$ok = false;
			$_SESSION['e_haslo1'] = "Haslo ma miec od 5 do 20 znakow";
		}
    if($haslo1 != $haslo2)
		{
			$ok = false;
			$_SESSION['e_haslo2'] = "Podane hasla nie są identyczne";
		}
		$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);

  mysqli_report(MYSQLI_REPORT_STRICT);
  try {
		require_once "connect.php";
	  $polaczenie = new mysqli($host,$db_user,$db_password,$db_name);
    if($polaczenie -> connect_errno != 0)
    {
      throw new Exception(mysqli_connect_errno());
    } else {
      $rezultat = $polaczenie -> query("SELECT id FROM userzy WHERE email='$email'");
      $rezultat1 = $polaczenie -> query("SELECT id FROM userzy");
			$rezultat2 = $polaczenie -> query("SELECT id FROM userzy WHERE user='$nick'");
      if((!$rezultat) || (!$rezultat1)) throw new Exception ($polaczenie -> error);
			$ile_nickow = $rezultat1 -> num_rows;
      $ile_typow = $rezultat1 -> num_rows;
      $ile_takich_maili = $rezultat -> num_rows;
      if($ile_takich_maili>0)
      {
        $ok = false;
        $_SESSION['e_mail'] = "Istnieje już osoba za takim mailem";
      }	else if($ile_nickow > 0) {
				$_SESSION['e_nick'] = "Stworzono już użytkownika o tym nicku";
			}
      else if ($ile_typow > 34)
      {
          $ok = false;
          $_SESSION['e_typy'] = "Osiągnięto maksymalną liczbę użytkowników. Proszę spróbować 31.12.18";
      }
      if($ok == true)
      {

        if($polaczenie -> query("INSERT INTO userzy VALUES (NULL, '$nick', '$haslo_hash', 0,'$email','$imie','$nazwisko',0)"))
        {
          $_SESSION['out']="Zarejestrowano pomyślnie";
          header ('Location: index.php');
        } else {
          throw new Exception ($polaczenie->error);
          }
        }
        $polaczenie -> close();
      }
    }
    catch (Exception $e)
  		{
  				echo "Błąd serwera. Przepraszamy za niedogodności i prosimy o rejestracjęw innym terminie";
  				echo '<br> Informacja deweloperska:'.$e;
  		}
  	}

  ?>
<html>
<head>
  <link rel="stylesheet" href="rejestruj.css" type="text/css">
</head>
<body>
  <main>
    <aside>
      <p>Rejestracja</p>
      <form method="post">
        <span>Nick:  </span> <br><input  type="text" name="nick" id="nick"><br>
        <?php
        if (isset ($_SESSION['e_nick']))
        {
          echo '<div class="error">'.$_SESSION['e_nick'].'</div>';
          unset ($_SESSION['e_nick']);
        }
         ?>
        <span>  Imię:   </span> <br> <input name="imie" type="text" id="imie"><br>
        <?php
        if (isset ($_SESSION['e_imie']))
        {
          echo '<div class="error">'.$_SESSION['e_imie'].'</div>';
          unset ($_SESSION['e_imie']);
        }
         ?>
        <span>  Nazwisko:  </span>  <br> <input name="nazwisko" type="text" id="nazwisko"><br>
        <?php
        if (isset ($_SESSION['e_nazwisko']))
        {
          echo '<div class="error">'.$_SESSION['e_nazwisko'].'</div>';
          unset ($_SESSION['e_nazwisko']);
        }
         ?>
        <span>  E-mail:  </span>  <br><input name="email" type="text" id="email"><br>
        <?php
        if (isset ($_SESSION['e_email']))
        {
          echo '<div class="error">'.$_SESSION['e_email'].'</div>';
          unset ($_SESSION['e_email']);
        }
         ?>
         <span>  Hasło:  </span>  <br> <input name="haslo1" type="password" id="haslo1"><br>
         <?php
         if (isset ($_SESSION['e_haslo1']))
         {
           echo '<div class="error">'.$_SESSION['e_haslo1'].'</div>';
           unset ($_SESSION['e_haslo1']);
         }
          ?>
         <span>  Powtórz hasło:  </span>  <br> <input name="haslo2" type="password" id="haslo2"><br>
         <?php
     		if (isset ($_SESSION['e_haslo2']))
     		{
     			echo '<div class="error">'.$_SESSION['e_haslo2'].'</div>';
     			unset ($_SESSION['e_haslo2']);
     		}
     		 ?>
        <br><input type="submit" id="rej" value="Zarejestruj się">
      </form>
    </aside>
    <?php
    if (isset ($_SESSION['e_typy']))
    {
      echo '<div class="fail">'.$_SESSION['e_typy'].'</div>';
      unset ($_SESSION['e_typy']);
    }
     ?>
  </main>
</body>
</html>
