<?php
// Inicio session
   session_start();
   include_once("conexion.php");
   if(!isset($_SESSION['NIF'])){
      header("location:login.php");
   } else {
      echo "<html>
      <link rel=\"stylesheet\" href=\"bootstrap.min.css\">
      <body>";
      $_SESSION['carrito']=array();
      echo "Bienvenido ";
      $nifAux=$_SESSION['NIF'];
      $sql="SELECT NOMBRE FROM CLIENTE WHERE NIF='$nifAux'";
      $result = mysqli_query($conn, $sql);
      $fila = mysqli_fetch_assoc($result);
      $nombre = $fila['NOMBRE'];
      $_SESSION['nombre']=$nombre;
      echo $_SESSION['nombre'];
      echo "<br> NIF: ".$_SESSION['NIF'];
      echo "<br><h1>MENU</h1>";
      echo "<a class=\"btn btn-primary\"
      href=\"./compro.php\">Comprar de productos</a><br><br>";
      echo "<a class=\"btn btn-primary\"
      href=\"./comconscom.php\">Consulta de compras</a><br>";


      echo "<br>Para cerrar la sesion, pulsa: <a href='logout.php'>logout</a>";
      echo "</body></html>";
   }
?>
