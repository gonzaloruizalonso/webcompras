<?php
// Inicio session
   session_start();
   //include_once("conexion.php");
   if(!isset($_SESSION['NIF'])){
      header("location:login.php");
   }
?>

<?php
echo "<link rel=\"stylesheet\" href=\"bootstrap.min.css\">";
  include "conexion.php";
  mysqli_query($conn, "begin;");
  $dni = $_SESSION['NIF'];
  foreach ($_SESSION['carrito'] as $key => $value) {
    usleep(1000000);
    procesarCompra($conn,$value,$dni);
  }
  echo '<br>
  <a class="btn btn-primary" href="./usuario.php">Volver</a>';

  mysqli_query($conn, "commit;");
  mysqli_close($conn);


  function procesarCompra($conn,$arrayDatos,$dni){
    usleep(1000000);
    //Carga de variables
    $idProducto=$arrayDatos[0];
    $nomprod=$arrayDatos[1];
    $numAlm=$arrayDatos[2];
    $nomalm=$arrayDatos[3];
    $cantidad=$arrayDatos[4];

    //Compra

        $sql3 = "SELECT SYSDATE() as hoy";
        $result2 = mysqli_query($conn, $sql3);
        $fila2 = mysqli_fetch_assoc($result2);
        $fecha_hoy = $fila2['hoy'];

        if (mysqli_query($conn, $sql3)) {
          //echo $fecha_hoy;
          $sql4 = "SELECT IFNULL(SUM(CANTIDAD),0) AS i FROM ALMACENA WHERE ID_PRODUCTO = '$idProducto' AND NUM_ALMACEN = '$numAlm'";
          $result = mysqli_query($conn, $sql4);
          $fila = mysqli_fetch_assoc($result);
          $cantidadAux = $fila['i'];
          if ($cantidad > $cantidadAux) {
            echo "<br>";
            echo "ERROR, NO HAY STOCK DEL PRODUCTO: ".$nomprod." EN EL ALMACEN DE ".$nomalm;
            echo "<br>";
            mysqli_query($conn, "rollback;");
          }else {
            $sql5 = "UPDATE ALMACENA
            SET CANTIDAD=CANTIDAD-'$cantidad'
            WHERE NUM_ALMACEN='$numAlm' AND ID_PRODUCTO='$idProducto'";
            $sql6 = "INSERT INTO COMPRA (NIF,ID_PRODUCTO,FECHA_COMPRA,UNIDADES)
            VALUES ('$dni','$idProducto','$fecha_hoy','$cantidad')";
            //echo $sql5;
            if (mysqli_query($conn, $sql5) && mysqli_query($conn, $sql6)) {
              echo "<hr>";
              echo "COMPRA PROCESADA CORRECTAMENTE <br>".
              $nomprod." en ".$nomalm." Cantidad: ".$cantidad;
              echo "<hr>";
              mysqli_query($conn, "commit;");
            }else {
              echo "Error:<br>" .$sql5." XD ".$sql6." ".mysqli_error($conn);
              mysqli_query($conn, "rollback;");
            }
          }

        }else {
          echo "Error: " . $sql3 . "<br>" . mysqli_error($conn);
          mysqli_query($conn, "rollback;");
        }

  }

 ?>
