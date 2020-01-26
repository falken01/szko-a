<html>
  <head>
    <?php
      session_start();
    require_once "connect.php";
    $polaczenie = new mysqli($host,$db_user,$db_password,$db_name);
    if (isset($_SESSION['logged']) && $_SESSION['mod']==1)
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
  margin-top: 50px;
  margin-bottom: 100px;
  max-height: 100%;
  overflow: auto;
}
.btn {
  width: 100%;
}
.font-weight-bold{
  padding-top: 8px;
}
input[type=checkbox]{
border:0;
width: 20px;
height: 30px;
border-radius: 11px;
}
.navbar {
  background-color: #292C44;
  padding-top: 15px;
  padding-bottom: 15px;
}
      </style>

      </head>
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
    <a class="nav-item nav-link" href="harmonogram.php">Harmonogram</a>
    <a class="nav-item nav-link" href="informacje.php">Informacje</a>
    <a class="nav-item nav-link active" href="listamod.php">Lista Moderatora</a>

  </div>
  <span class="navbar-text">
   </span>
</div>
</nav>
  <div id="content" class="container">
    <div class="table-responsive-md">
      <?php
      $rezultat = $polaczenie -> query("SELECT zadaniamod.*, userzy.imie FROM `zadaniamod`, `userzy` WHERE zadania.dodano_id_user  = userzy.id ORDER BY data");
     $ile_kolumn = $rezultat -> num_rows;
     if($ile_kolumn > 0)
     {
     echo  "<table class='table table-dark' border='0' cellpadding='10' cellspacing='0' >";
     echo "<thead>"."<th>Przedmiot</th>"."<th>Typ zadania</th>"."<th>Opis</th>"."<th>Data</th>"."<th>Dodano przez</th>"."<th>Usuń</th>"."<th>Akceptowanie działań</th>"."</th>";
     while(list($id,$typ,$przedmiot,$opis,$data,$dodano)=mysqli_fetch_row($rezultat))
     {
       echo "<tr><form action='maindb.php' method='post'>"."<td style='display:none;'><input class='form-control' value='$id' name='id' type='hidden'></td>"."<td><input class='form-control' type='text' name='typ' value='$typ'></td>"."<td> <input class='form-control' type='text' style='width:100px;' name='przedmiot' value='$przedmiot'></td>"."<td> <input type='text' class='form-control' name='opis' value='$opis' ></td>"."<td><input type='text' name='data' style='color:brown;font-weight:bold;' class='form-control' value='$data'></td>"."<td><p class='font-weight-bold'>$dodano<input type='hidden' name='dodano' value='$dodano'></p></td>"."<td>

        <input name='delete' type='checkbox'>
  </td>"."<td><input type='submit' class='btn btn-secondary' value='akceptuj'></td>"."</form></tr>";
     }
     echo  "</table>";
   } else {
     echo "<h1 class='text-info' style='text-align:center;'>Brak rekordów w bazie :)</h1>";
   }
    ?>
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
