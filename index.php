<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
.alert {
  font-weight: bold;
}
.navbar {
  background: #292C44;
}
button {
  margin-left: 10px;
}
a[href=logut.php]{
  padding: 100%;
}

      </style>
      <script>
      $('document').ready(function(){
        $('#dejt').datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: 0,
        maxDate: 30,
        firstDay: 1
        });
        $('#confirm').dialog({

      resizable: false,
      draggable: false,
      modal: true,
      autoOpen: false,
      buttons :{
        "Potwierdź" : function() {
          $('#remover').unbind('submit').submit();
        },
        "Anuluj" : function() {
          $('#remover').removeAttr("id");
          $('#confirm').dialog('close');
        }
      }
    });
      $('.rekordRemover').submit(function(event){
        event.preventDefault();
        $(this).attr("id","remover");
        $('#confirm').dialog('open');
      });

      });
      </script>
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
    <a class="nav-item nav-link active" href="index.php">Strona Główna</a>
    <a class="nav-item nav-link" href="wpisy.php">Wpisy</a>
    <a class="nav-item nav-link" href="harmonogram.php">Harmonogram</a>
    <a class="nav-item nav-link" href="informacje.php">Informacje</a>
    <?php
      if($_SESSION['mod']==1)
        echo '<a class="nav-item nav-link" href="listamod.php">Lista Moderatora</a>';
      ?>

  </div>
  <span class="navbar-text">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
      Dodaj rekord
    </button>
    <?php
      if($_SESSION['user']=="Patryk")
      {
        echo "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#cytat'>";
        echo "Uaktualnij cytat";
        echo "</button>";
      }
    ?>
    <button type="button" class="btn test-secondary  btn-warning">
      <a href="logout.php">Wyloguj się</a>
    </button>
   </span>
</div>
</nav>


	  <div id="content" class="container">
      <?php
      if(isset($_SESSION['ok']))
      {
        echo $_SESSION['ok'];
        unset($_SESSION['ok']);
      }
       ?>
     <div class="table-responsive-lg">
       <?php
       $rezultat = $polaczenie -> query("SELECT zadania.*, userzy.imie FROM `zadania`, `userzy` WHERE zadania.dodano_id_user = userzy.id ORDER BY zadania.data");
       $ile_kolumn = $rezultat -> num_rows;

       echo  "<table class='table table-dark' border='0' cellpadding='10' cellspacing='0' >";

       echo "<thead>"."<th scope='col'>Przedmiot</th>"."<th scope='col'>Typ zadania</th>"."<th scope='col'>Opis</th>"."<th scope='col'>Data</th>"."<th scope='col'>Dodano przez</th>";
       if($_SESSION['mod']==1)
       {
           echo "<th scope='col'>Usuń</th>";
       }

       echo "</thead><tbody>";

       while(list($id,$typ,$przedmiot,$opis,$data,$id_dodano, $dodano)=mysqli_fetch_row($rezultat))
       {
       echo "<tr><form method='post' class='rekordRemover' action='delete.php'>";
       if($_SESSION['mod']==1)
       {
        echo "<td style='display:none;'><input type='hidden' value=$id name='id'></td>";
       }
       echo "<td name='przedmiot'>".$przedmiot."</td>"."<td name='typ'>".$typ."</td>"."<td name='opis' value='$opis'>".$opis."</td>"."<td name='data' style='color:brown'><b>".$data."</b></td>"."<td name='dodano'>".$dodano."</td>";
   	  if($_SESSION['mod']==1)
   	  {
   		  echo "<td><input style='padding: 5px;' class='btn btn-secondary' type='submit' value='Usuń'></td></form>";
   	  }
 	    echo "</tr>";

       }

       echo  "</tbody></table>";

      $rezultat -> free_result();
      $polaczenie -> close();

      ?>
      </div>
    </div>



<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Dodawanie rekordu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="zadaniamod.php">
          <select class="form-control" name="przedmiot">
            <option>Matematyka</option>
     <option>Polski</option>
     <option>Projektowanie sieci</option>
     <option>Administracja Bazami Danych</option>
     <option>HIS</option>
     <option>Niemiecki | G1</option>
     <option>Niemiecki | G2</option>
     <option>Niemiecki | G3</option>
     <option>Angielski | G1</option>
     <option>Angielski | G2</option>
     <option>Informatyka</option>
     <option>Systemy Baz danych</option>
     <option>Programowanie aplikacji</option>
     <option>Witryny i aplikacje</option>
     <option>Sieci komputerowe</option>
          </select>
          <select class="form-control" name="typ">
            <option>Praca domowa</option>
            <option>Test</option>
            <option>Kartkówka</option>
            <option>Coco Jambo</option>
            <option>Na następnej lekcji</option>
          <input class="form-control" type="text" placeholder="opis zadania" name="opis">
          <input class="form-control" type="text" placeholder="data" id="dejt" name="date">
      </div>
      <div class="modal-footer">
        <input type="submit" class="btn btn-primary">
      </form>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>

      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="cytat" tabindex="-1" role="dialog" aria-labelledby="cytattitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cytattitle">Uaktualnianie cytatu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="update.php">

          <input class="form-control" type="text" placeholder="treść" name="area">
          <input class="form-control" type="text" placeholder="autor" id="dejt" name="autor">
      </div>
      <div class="modal-footer">
        <input type="submit" class="btn btn-primary">
      </form>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>

      </div>
    </div>
  </div>
</div>
    <footer class="footer">
         <div class="container">
           <span class="text-muted">Wyprodukowano w Polsce</span>
         </div>
       </footer>
       <div title="Potwierdź działania" id="confirm">
    <p>Czy jesteś pewien, że chcesz usunąć podany rekord z bazy?</p>
  </div>
  </body>
</html>
