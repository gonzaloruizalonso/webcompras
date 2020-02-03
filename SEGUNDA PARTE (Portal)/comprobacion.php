<?php
  session_start();
  include_once("conexion.php");

  $usuario = $_POST['usr'];
  $clave  = $_POST['pas'];

  $sql="SELECT PASSWORD FROM CLIENTE WHERE USUARIO='$usuario'";
  $result = mysqli_query($conn, $sql);
  $fila = mysqli_fetch_assoc($result);
  $claveReal = $fila['PASSWORD'];

  if($clave!=$claveReal){
     echo "Login incorrecto<br>";
     echo "<a href=\"./login.php\">Volver al login</a>";
  } else {

     $sql2="SELECT NIF FROM CLIENTE WHERE USUARIO='$usuario'";
     $result = mysqli_query($conn, $sql2);
     $fila = mysqli_fetch_assoc($result);
     $nif = $fila['NIF'];


     $_SESSION['NIF']=$nif;
     header("location:usuario.php");
  }
?>
