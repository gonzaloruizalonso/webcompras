<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Web compras</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
<h1>COMPRAR PRODUCTOS - Gonzalo Ruiz</h1>
<!-- Aprovisionar Productos(comaprpro.php):
asignar    productos    a    un    almacén.
Se seleccionaránlos  nombres  de  los  productos
y  los  números  de  los  almacenesdesde  listas desplegables -->
<?php
include "conexion.php";
mysqli_query($conn, "begin;");
$productos = obtenerProductos($conn);
$almacenes = obtenerAlmacenes($conn);
$dnis = obtenerDNIs($conn);
/* Se muestra el formulario la primera vez */
if (!isset($_POST) || empty($_POST)) {
    /* Se inicializa la lista valores*/
	echo '<form action="" method="post">';
?>
<div class="container ">
<!--Aplicacion-->
<div class="card border-success mb-3" style="max-width: 30rem;">
<div class="card-header">Introduce los datos:</div>
<div class="card-body">
	<div class="form-group">
    <label for="dni">DNI:</label>
  	<select name="dni">
      <?php foreach($dnis as $d) : ?>
        <option> <?php echo $d ?> </option>
      <?php endforeach; ?> <br>
  	</select><br>
	<label for="producto">Producto:</label>
	<select name="producto">
    <?php foreach($productos as $p) : ?>
      <option> <?php echo $p ?> </option>
    <?php endforeach; ?> <br>
	</select><br>
	<label for="almacen">Almacen:</label>
	<select name="almacen">
    <?php foreach($almacenes as $a) : ?>
      <option> <?php echo $a ?> </option>
    <?php endforeach; ?> <br>
	</select>
  <div class="form-group">
    CANTIDAD <input type="number" name="cantidad" required class="form-control">
  </div>
	</div>
	</BR>
<?php
	echo '<div><input type="submit" value="Enviar"></div>
	</form>';
} else {
	// Aquí va el código al pulsar submit
  $nomprod = stripslashes(htmlspecialchars(trim($_REQUEST['producto'])));
  $nomalm = stripslashes(htmlspecialchars(trim($_REQUEST['almacen'])));
  $cantidad = stripslashes(htmlspecialchars(trim($_REQUEST['cantidad'])));
  $dni = stripslashes(htmlspecialchars(trim($_REQUEST['dni'])));

  $sqlprevio1 = "SELECT NUM_ALMACEN as i FROM ALMACEN WHERE LOCALIDAD='$nomalm' ";
  $result = mysqli_query($conn, $sqlprevio1);
  $fila = mysqli_fetch_assoc($result);
  $numAlm = $fila['i'];
  if (mysqli_query($conn, $sqlprevio1)) {

    $sqlprevio2 = "SELECT ID_PRODUCTO as i FROM PRODUCTO WHERE NOMBRE='$nomprod' ";
    $result = mysqli_query($conn, $sqlprevio2);
    $fila = mysqli_fetch_assoc($result);
    $idProducto = $fila['i'];
    if (mysqli_query($conn, $sqlprevio2)) {

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
          echo "ERROR, NO HAY STOCK";
          mysqli_query($conn, "rollback;");
        }else {
          $sql5 = "UPDATE ALMACENA
          SET CANTIDAD=CANTIDAD-'$cantidad'
          WHERE NUM_ALMACEN='$numAlm' AND ID_PRODUCTO='$idProducto'";
          $sql6 = "INSERT INTO COMPRA (NIF,ID_PRODUCTO,FECHA_COMPRA,UNIDADES)
          VALUES ('$dni','$idProducto','$fecha_hoy','$cantidad')";
          //echo $sql5;
          if (mysqli_query($conn, $sql5) && mysqli_query($conn, $sql6)) {
            echo "Compra realizada correctamente";
          }else {
            echo "Error:<br>" . mysqli_error($conn);
            mysqli_query($conn, "rollback;");
          }
        }

      }else {
        echo "Error: " . $sql3 . "<br>" . mysqli_error($conn);
        mysqli_query($conn, "rollback;");
      }

    }else {
      echo "Error: " . $sqlprevio2 . "<br>" . mysqli_error($conn);
      mysqli_query($conn, "rollback;");
    }

  }else {
    echo "Error: " . $sqlprevio1 . "<br>" . mysqli_error($conn);
    mysqli_query($conn, "rollback;");
  }




  mysqli_query($conn, "commit;");
  mysqli_close($conn);
}
?>

<?php
// Funciones utilizadas en el programa
function obtenerProductos($db) {
	$productos = array();
	$sql = "SELECT NOMBRE FROM PRODUCTO";
	$resultado = mysqli_query($db, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$productos[] = $row['NOMBRE'];
		}
	}
	return $productos;
}
function obtenerAlmacenes($db) {
	$almacenes = array();
	$sql = "SELECT LOCALIDAD FROM ALMACEN";
	$resultado = mysqli_query($db, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$almacenes[] = $row['LOCALIDAD'];
		}
	}
	return $almacenes;
}
function obtenerDNIs($db) {
	$dnis = array();
	$sql = "SELECT NIF FROM CLIENTE";
	$resultado = mysqli_query($db, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$dnis[] = $row['NIF'];
		}
	}
	return $dnis;
}
?>



</body>

</html>
