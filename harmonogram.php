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
    $idik = $_SESSION['id'];
    $tablica = array();
    $i = 0;
    $j = 0;
    function sprawdzDate($data, $i, $j, $tablica) {
      for($j;$j<$i;$j++)
      {
        if($tablica[$j] == $data )
          {
          return false;
          }
      }
    return true;
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
  margin-top: 50px;
  margin-bottom: 100px;
}
.btn {
  width: 100%;
}
.font-weight-bold{
  padding-top: 8px;
}
.card {
  margin-bottom: 5px;
  width: 100%;
}
.alert {
  font-weight: bold;
}
.navbar {
  background: #292C44;
}
      </style>

      </head>
      <script>
      $('document').ready(function(){
        $('#accordion').accordion({
        animate:200,
        active:10000
      });
      $('#dejt').datepicker({
      dateFormat: 'yy-mm-dd',
      minDate: 0,
      maxDate: 30,
      firstDay: 1
      });
      });
      </script>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark">
      <a class="navbar-brand" href="#">
  Listy zadań
 </a>
 <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
   <span class="navbar-toggler-icon"></span>
 </button>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
  <div class="navbar-nav mr-auto">
    <a class="nav-item nav-link" href="index.php">Strona Główna</a>
    <a class="nav-item nav-link" href="wpisy.php">Wpisy</a>
    <a class="nav-item nav-link active" href="harmonogram.php">Harmonogram</a>
    <a class="nav-item nav-link" href="informacje.php">Informacje</a>
    <?php
      if($_SESSION['mod']==1)
        echo '<a class="nav-item nav-link" href="listamod.php">Lista Moderatora</a>';
      ?>

  </div>
  <span class="navbar-text">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#harmon">
      Dodaj rekord
    </button>
   </span>
</div>
</nav>
  <div id="content" class="container">
    <div id="accordion">
      <?php
      if(isset($_SESSION['ok']))
      {
        echo $_SESSION['ok'];
        unset($_SESSION['ok']);
      }
    $rezultat = $polaczenie -> query("SELECT * FROM harmonogram WHERE user=0 OR user='$idik'");
    while(list($id,$data,$start,$text,$stop,$idik)=mysqli_fetch_row($rezultat))
    {
     $rezultat1 = $polaczenie -> query("SELECT * FROM harmonogram WHERE data='$data' AND data >= CURDATE() ");
     $ile_kolumn = $rezultat1 -> num_rows;

     if ($ile_kolumn>1 && sprawdzDate($data, $i, $j, $tablica))
      {
        $tablica[$i++] = $data;
        echo "<h3>$data</h3>";
        echo "<div class='akord'>";
        $rezultat2 = $polaczenie -> query("SELECT harmonogram.start, harmonogram.text, harmonogram.stop FROM harmonogram WHERE user=0 OR user='$idik' AND data='$data' AND data >= CURDATE()");
        while(list($start,$text,$stop)=mysqli_fetch_row($rezultat2))
        {
            echo "<p><span class='czasy'>$start - $stop</span>"."  <span class='texty'>".base64_decode($text)."</span></p><hr>";
        }
        echo "</div>";
      }  else if ($ile_kolumn == 1 && sprawdzDate($data, $i, $j, $tablica))   {
            echo "<h3>$data</h3>";
            echo "<div class='akord'><p><span class='czasy'>$start - $stop</span>"."  <span class='texty'>".base64_decode($text)."</span></p><hr></div>";
          }
    }
      ?>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="harmon" tabindex="-1" role="dialog" aria-labelledby="harmontitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="harmontitle">Dodawanie rekordu</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="harm.php">
            Godzina start:
            <input class="form-control" placeholder="godzina rozpoczęcia" name='godzinastart' type='time'>
            Godzina stop:
            <input class="form-control" placeholder="godzina rozpoczęcia" name='godzinastop' type='time'>
            <input class="form-control" placeholder="Opis" name='opis' type='text'>
            <input class="form-control" type="text" placeholder="Data" id="dejt" name="data">
            <div class='custom-control custom-checkbox my-1 mr-sm-2'>
              <?php
            if($_SESSION['mod']==1)
          {
          echo   "<input type='checkbox' class='custom-control-input' id='customControlInline'>";
          echo   "<label class='custom-control-label' for='customControlInline'>Zaznaczyć jeśli wydarzenie dotyczy całej klasy</label>";
          echo   "</div>";
          }
          ?>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-primary">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
        </form>
        </div>
      </div>
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
