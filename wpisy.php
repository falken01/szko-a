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
  margin-bottom: 9px;
  width: 100%;
  border: 1px solid green;
  border-radius: 10px;
}
.navbar {
  background: #292C44;
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
    <a class="nav-item nav-link active" href="wpisy.php">Wpisy</a>
    <a class="nav-item nav-link" href="harmonogram.php">Harmonogram</a>
    <a class="nav-item nav-link" href="informacje.php">Informacje</a>
    <?php
      if($_SESSION['mod']==1)
        echo '<a class="nav-item nav-link" href="listamod.php">Lista Moderatora</a>';
      ?>

  </div>
  <span class="navbar-text">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong">
      Dodaj post
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

   $rezultat = $polaczenie -> query("SELECT informacje.*, userzy.imie FROM `informacje`, `userzy` WHERE zadania.dodano_id_user  = userzy.id ORDER BY id DESC");
   while(list($id,$informacja,$data,$user)=mysqli_fetch_row($rezultat))
   {
     echo  "<div class='card text-white bg-dark'>";
     echo "<div class='card-body'><h5 class='card-title'>".$user."</h5>";
     echo "<h6 class='card-subtitle mb-2 text-muted'>".$data."</h6>";
     echo "<p class='card-text'>".$informacja."</p>";
     echo  "</div></div>";
   }

     ?>
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
             <form method="post" action="info.php">
             <input class="form-control" type="text" name="info">
           </div>
           <div class="modal-footer">
             <input type="submit" class="btn btn-primary">
           </form>
             <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>

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
