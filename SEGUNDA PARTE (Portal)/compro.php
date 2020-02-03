<?php
// Inicio session
   session_start();
   //include_once("conexion.php");
   if(!isset($_SESSION['NIF'])){
      header("location:login.php");
   }
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Web compras</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
<h1>COMPRAR PRODUCTOS -<?php  echo $_SESSION['nombre']; ?></h1>
<!-- Aprovisionar Productos(comaprpro.php):
asignar    productos    a    un    almacén.
Se seleccionaránlos  nombres  de  los  productos
y  los  números  de  los  almacenesdesde  listas desplegables -->
<?php
include "conexion.php";
mysqli_query($conn, "begin;");
$productos = obtenerProductos($conn);
$almacenes = obtenerAlmacenes($conn);
function mostrarFormulario($conn,$productos,$almacenes){
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
  <input type="text" readonly name="dni"
  class="form-text text-muted"
  value="<?php echo $_SESSION['NIF'] ?>">
   <br><br>
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
echo '<div><input type="submit" value="Agregar al carrito"></div>
</form><br>';
}
/* Se muestra el formulario la primera vez */
if (!isset($_POST) || empty($_POST)) {
  mostrarFormulario($conn,$productos,$almacenes);
  echo '<br>
  <a class="btn btn-primary" href="./usuario.php">Volver a usuario</a>';
} else {
	// Aquí va el código al pulsar submit
  mostrarFormulario($conn,$productos,$almacenes);
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
      //TRAS COMPROBACIONES Guardo en el array
      $productoAux = array($idProducto,$nomprod,$numAlm,$nomalm,$cantidad);
      array_push($_SESSION['carrito'], $productoAux);

      echo "<h4>Carrito</h4>";
      echo "<table class=\"table table-dark\">";
      echo "<tr><th>Nombre</th><th>Almacen</th><th>Cantidad</th></tr>";
      foreach ($_SESSION['carrito'] as $key => $value) {
        echo "<tr>";
        echo "<td>$value[1]</td><td>$value[3]</td><td>$value[4]</td>";
        echo "</tr>";
        //echo "Nombre: ".$value[1]." Almacen: ".$value[3]." Cantidad: ".$value[4] ;
        echo "<br>";
      }
      echo "</table>";
      echo '<br>
      <a class="btn btn-secondary" href="./procesarCompra.php">Procesar compra</a><br>';


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
  echo '<br>
  <a class="btn btn-primary" href="./usuario.php">Volver a usuario</a>';
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

?>



</body>

</html>
