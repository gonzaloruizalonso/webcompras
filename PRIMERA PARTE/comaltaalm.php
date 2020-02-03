<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Web compras</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>

<body>
<h1>ALTA ALMACENES - Gonzalo Ruiz</h1>
<!-- Alta  de  Almacenes(comaltaalm.php):
dar  de  alta  almacenes  en  diferentes  localidades.
El número de almacén será un númerosecuencial que comenzará
en 10 y se incrementará de 10 en 10 -->
<?php
include "conexion.php";
mysqli_query($conn, "begin;");

/* Se muestra el formulario la primera vez */
if (!isset($_POST) || empty($_POST)) {

    /* Se inicializa la lista valores*/
	echo '<form action="" method="post">';
?>
<div class="container ">
<!--Aplicacion-->
<div class="card border-success mb-3" style="max-width: 30rem;">
<div class="card-header">Datos Almacen</div>
<div class="card-body">
		<div class="form-group">
        NOMBRE LOCALIDAD <input type="text" name="nombre" placeholder="nombre" class="form-control">
        </div>

		</BR>
<?php
	echo '<div><input type="submit" value="Alta almacen"></div>
	</form>';
} else {
	// Aquí va el código al pulsar submit
    $nomloc=stripslashes(htmlspecialchars(trim($_REQUEST['nombre'])));

    $sqlprevio = "SELECT IFNULL(MAX(NUM_ALMACEN),0) as m FROM ALMACEN ";
    $result = mysqli_query($conn, $sqlprevio);
    $fila = mysqli_fetch_assoc($result);
    $maxNum = $fila['m'];

    if (mysqli_query($conn, $sqlprevio)) {
      $sqlprevio2 = "SELECT LOCALIDAD as l FROM ALMACEN WHERE LOCALIDAD='$nomloc' ";
      $result = mysqli_query($conn, $sqlprevio2);
      $fila = mysqli_fetch_assoc($result);
      $nomlocAux= $fila['l'];

      if (mysqli_query($conn, $sqlprevio2)) {
        if ($nomloc!=$nomlocAux) {
          $maxNum=$maxNum+10;
          $sql="INSERT INTO ALMACEN (NUM_ALMACEN,LOCALIDAD)
          VALUES ('$maxNum','$nomloc')";
          if (mysqli_query($conn, $sql)) {
            echo "Almacen agregado correctamente";
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            mysqli_query($conn, "rollback;");
          }
        }else {
          echo "Ya existe un almacen en esa localidad";
        }
      }else {
        echo "Error: " . $sqlprevio2 . "<br>" . mysqli_error($conn);
        mysqli_query($conn, "rollback;");
      }
    }else {
      echo "Error: " . $sqlprevio . "<br>" . mysqli_error($conn);
      mysqli_query($conn, "rollback;");
    }
}
mysqli_query($conn, "commit;");
mysqli_close($conn);
?>

<?php
// Funciones utilizadas en el programa

?>



</body>

</html>
