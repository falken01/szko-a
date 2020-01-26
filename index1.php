<?php
  session_start();
  require_once "connect.php";
  $polaczenie = new mysqli($host,$db_user,$db_password,$db_name);

 ?>
 <html>
 <head>
    <title>Listy Zadań</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="jq/jquery-ui.min.css">
    <link rel="stylesheet" type="text/css" href="indexxx.css">
    <script>
      var mnoznik = 1920/innerWidth;
      var kres = document.getElementsByTagName("panel").offsetWidth;
      kres *= mnoznik;
      $('.panel').css({'width': kres});
    </script>
  </head>
  <body>
    <header>
      <?php
      if(isset(  $_SESSION['out']))
      {
        echo   "<div id='signup'>".$_SESSION['out']."</div>";
        unset($_SESSION['out']);
      }
      ?>
    </header>
      <main>
        <div class="panel" id="policja">
          <p class="paragraf" href="rejestracja.php">Listy zadań</p>
        </div>
        <div class="panel"  id="logowanie">
        <p class="paragraf">Panel logowania</p>
          <div>
            <form method="post" action="loguj.php">
                <span>Login:</span><br>
              <input id="login" name="login" type="text"><br>
                <span>Hasło:</span><br>
              <input id="haslo" name="haslo" type="password"><br>
              <?php
          		if (isset ($_SESSION['blad']))
          		{
          			echo '<div style="color:FF6159; font-family:Helvetica; font-size:15px;font-weight: bold;>'.$_SESSION['blad'].'</div>';
          			unset ($_SESSION['blad']);
          		}

          		 ?>
               <input type="submit" id="wyslij" type="wyslij" value="Wyślij">
            </form>
          </div>
        </div>
        <div class="panel" id="rejestracja">
        <p><a class="paragraf" href="rejestracja.php">Zarejestruj się</a></p>
        </div>
        <aside class="panel" id="cytat">
          <?php
          $rezultat = $polaczenie -> query("SELECT * FROM cytat WHERE id='1'");
          $wiersz = $rezultat -> fetch_assoc();
          echo '<p>"'.$wiersz['texkt'].'"</p>';
          echo "<span>~".$wiersz['autor']."</span>";
          ?>
        </aside>
      </main>

    </body>
