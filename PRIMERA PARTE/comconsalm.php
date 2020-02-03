<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Web compras</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
<h1>CONSULTA DE ALMACENES - Gonzalo Ruiz</h1>
<!-- Aprovisionar Productos(comaprpro.php):
asignar    productos    a    un    almacén.
Se seleccionaránlos  nombres  de  los  productos
y  los  números  de  los  almacenesdesde  listas desplegables -->
<?php
include "conexion.php";
mysqli_query($conn, "begin;");
$almacenes = obtenerAlmacenes($conn);
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
	<label for="alm">ALMACEN:</label>
	<select name="alm">
    <?php foreach($almacenes as $p) : ?>
      <option> <?php echo $p ?> </option>
    <?php endforeach; ?> <br>
	</select><br>
	</div>
	</BR>
<?php
	echo '<div><input type="submit" value="Enviar"></div>
	</form>';
} else {
	// Aquí va el código al pulsar submit
  $nomAlm = stripslashes(htmlspecialchars(trim($_REQUEST['alm'])));

    $sqlprevio = "SELECT NUM_ALMACEN as i FROM ALMACEN WHERE LOCALIDAD='$nomAlm' ";
    $result = mysqli_query($conn, $sqlprevio);
    $fila = mysqli_fetch_assoc($result);
    $numAlm = $fila['i'];
    if (mysqli_query($conn, $sqlprevio)) {
      echo "STOCK DEL ALMACEN: <br>";
      $datos=obtenerCantidadAlm($conn,$numAlm);
      foreach ($datos as $clave => $valor) {
        echo "$valor <br>";
      }

    }else {
      echo "Error: " . $sqlprevio2 . "<br>" . mysqli_error($conn);
      mysqli_query($conn, "rollback;");
    }

  mysqli_query($conn, "commit;");
  mysqli_close($conn);
}
?>

<?php
// Funciones utilizadas en el programa
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

function obtenerCantidadAlm($db,$numAux) {
  $res = array();
	$sql = "SELECT PRODUCTO.NOMBRE AS ID, CANTIDAD AS C FROM ALMACENA,PRODUCTO WHERE NUM_ALMACEN = '$numAux' AND ALMACENA.ID_PRODUCTO = PRODUCTO.ID_PRODUCTO";
	$resultado = mysqli_query($db, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$res[] = "Producto=".  $row['ID'] ." CANTIDAD=".$row['C'];
		}
	}
	return $res;
}
?>
</body>

</html>
