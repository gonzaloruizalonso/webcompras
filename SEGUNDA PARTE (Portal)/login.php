<?php
session_start();
if(isset($_SESSION['NIF'])){
  header("location:usuario.php");
}else {
?>
  <html><head><title>Login </title><link rel="stylesheet" href="bootstrap.min.css"></head>
     <body>
     <h1>Identificate</h1>
          <form action="comprobacion.php" method="POST">
               Usuario: <input type="text" name="usr"><br>
               Clave: <input type="password" name="pas"><br>
               <br><input type="submit" value="Entrar" class="btn btn-primary">
               <br><br>No tienes usuario? <a href="./registro.php">Registrate</a>
          </form>
      </body></html>

<?php
}
?>
