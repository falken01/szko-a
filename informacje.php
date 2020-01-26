<html>
  <head>

    <?php
    session_start();
    require_once "connect.php";
    $polaczenie = new mysqli($host,$db_user,$db_password,$db_name);

    if (isset($_SESSION['logged']))
    {

    } else {
      $_SESSION['blad'] = '<span style="color:red"> Zaloguj się!!! </span>';
        header('Location: index1.php');
    }
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

      <style>
html {
position: relative;
min-height: 100%;
}
body {
margin-bottom: 60px;
background: #a5b2be;
}
.footer {
position: absolute;
bottom: 0;
width: 100%;
height: 60px;
line-height: 60px;
background-color: #292C44;
}

.form-control {
  margin-bottom: 10px;
}
#content {
  padding-top: 50px;
}
.card {
  text-align: center;
  margin-bottom: 51px;
}

tr.bg-light {
  border-width: 2px 0px 2px 0px;
  border-color: #f8f9fa;
  border-style: solid
}
.navbar {
  background-color: #292C44;
  padding-top: 15px;
  padding-bottom: 15px;
}

      </style>
        </head>
  <body >
    <nav class="navbar navbar-expand-lg navbar-dark">
      <a class="navbar-brand" href="#">
  Listy zadań
 </a>
 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
   <span class="navbar-toggler-icon"></span>
 </button>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
  <div class="navbar-nav mr-auto">
    <a class="nav-item nav-link " href="index.php">Strona Główna</a>
    <a class="nav-item nav-link" href="wpisy.php">Wpisy</a>
    <a class="nav-item nav-link" href="harmonogram.php">Harmonogram</a>
    <a class="nav-item nav-link active" href="informacje.php">Informacje</a>
    <?php
      if($_SESSION['mod']==1)
        echo '<a class="nav-item nav-link" href="listamod.php">Lista Moderatora</a>';
      ?>

  </div>

</div>
</nav>


	  <div id="content" class="container">
      <div class="row">
        <div class="col-12 col-lg-6">
          <div style="box-shadow:5px;" class="table-responsive-md ">
            <table class="table table-dark"  border='0' cellpadding='10' cellspacing='0'>
            <thead><th scope='col'>Miejsce</th><th>Nick</th><th>Zdobyte punky</th><th>Ziomeczek</th></thead>
      <?php
      $n = 1;
      $rezultat = $polaczenie -> query("SELECT userzy.user, userzy.punkty, userzy.imie, userzy.nazwisko FROM userzy WHERE punkty>0 ORDER BY punkty DESC");
      while(list($user, $punkty,$imie, $nazwisko)=mysqli_fetch_row($rezultat))
      {
        if($n==1)
        {
        echo "<tr class='bg-warning text-dark'><td>".$n++."</td><td>$user</td><td>$punkty</td><td>$imie $nazwisko</td></tr>";
        }
        else if($n==2)
        {
        echo "<tr class='bg-light text-dark'><td>".$n++."</td><td>$user</td><td>$punkty</td><td>$imie $nazwisko</td></tr>";
      }
      else if($n==3)
      {
      echo "<tr class='bg-info '><td>".$n++."</td><td>$user</td><td>$punkty</td><td>$imie $nazwisko</td></tr>";
    } else {
        echo "<tr><td>".$n++."</td><td>$user</td><td>$punkty</td><td>$imie $nazwisko</td></tr>";
    }
      }

      ?>
    </table>
          </div>
        </div>
        <div class="col-12 col-lg-6">


           <div class='card text-white bg-dark'>
     <div class='card-body'>
    <p>Michał Hutnik aka falken - Administrator</p><br>
   <P>Patryk Faltyn aka Patryk - Head Moderator</p><br>
   <P>Michał Długajczyk aka krupniok200 - Moderator</p><br>
   <P>Jan Staniszewski aka Rudy - Moderator</p><br>
   <P>Adam Buda aka HisuiKiba - Moderator</p><br>
      </div></div>
  </div>


  </div>
</div>
    <footer class="footer">
         <div class="container">
           <span class="text-muted">Wyprodukowano w Polsce</span>
         </div>
       </footer>
       <script src="particles.js"></script>
       <script src="app.js"> </script>
  </body>
</html>
