<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Web compras</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
<h1>CONSULTA DE STOCK - Gonzalo Ruiz</h1>
<!-- Aprovisionar Productos(comaprpro.php):
asignar    productos    a    un    almacén.
Se seleccionaránlos  nombres  de  los  productos
y  los  números  de  los  almacenesdesde  listas desplegables -->
<?php
include "conexion.php";
mysqli_query($conn, "begin;");
$productos = obtenerProductos($conn);
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
	<label for="producto">Producto:</label>
	<select name="producto">
    <?php foreach($productos as $p) : ?>
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
  $nomprod = stripslashes(htmlspecialchars(trim($_REQUEST['producto'])));

    $sqlprevio = "SELECT ID_PRODUCTO as i FROM PRODUCTO WHERE NOMBRE='$nomprod' ";
    $result = mysqli_query($conn, $sqlprevio);
    $fila = mysqli_fetch_assoc($result);
    $idProducto = $fila['i'];
    if (mysqli_query($conn, $sqlprevio)) {
      echo "STOCK DISPONIBLE: <br>";
      $datos=obtenerCantidadAlm($conn,$idProducto);
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

function obtenerCantidadAlm($db,$prodAux) {
  $res = array();
	$sql = "SELECT ALMACEN.LOCALIDAD AS N, CANTIDAD AS C FROM ALMACENA,ALMACEN WHERE ALMACENA.ID_PRODUCTO = '$prodAux' AND ALMACENA.NUM_ALMACEN = ALMACEN.NUM_ALMACEN";
	$resultado = mysqli_query($db, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$res[] = "ALMACEN=".  $row['N'] ." CANTIDAD=".$row['C'];
		}
	}
	return $res;
}
?>
</body>

</html>
