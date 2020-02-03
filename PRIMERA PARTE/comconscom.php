<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Web compras</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
<h1>Consulta de Compras - Gonzalo Ruiz</h1>
<!-- Consulta  de Compras(comconscom.php):
se  mostrarán  los en  un  desplegablelos  NIF
de los clientes, una fecha desde y una fecha hasta.
Se mostrará por pantallala información de las
compras  realizadas  por  los  clientes  en  ese  periodo
(producto,  nombre  producto,  precio compra)
así como el montante total de todas las compras. -->
<?php
include "conexion.php";
mysqli_query($conn, "begin;");
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
    <label for="desde">Fecha desde</label>
    <input type="date" name="desde" value=""><br>
    <label for="hasta">Fecha hasta</label>
    <input type="date" name="hasta" value=""><br>

	</div>
	</BR>
<?php
	echo '<div><input type="submit" value="Enviar"></div>
	</form>';
} else {
	// Aquí va el código al pulsar submit
  $dni = stripslashes(htmlspecialchars(trim($_REQUEST['dni'])));
  $fechaDesde = $_REQUEST['desde'];
  $fechaHasta = $_REQUEST['hasta'];

  $productos = obtenerProductosNIF($conn,$dni,$fechaDesde,$fechaHasta);

  echo "<h3>PRODUCTOS: </h3>";
  foreach ($productos as $key => $value) {
    echo $value."<br>";
  }

  mysqli_query($conn, "commit;");
  mysqli_close($conn);
}
?>

<?php
// Funciones utilizadas en el programa
function obtenerProductosNIF($db,$dni,$fechaDesde,$fechaHasta) {
	$productos = array();
	$sql = " SELECT PRODUCTO.NOMBRE AS N,UNIDADES AS U,FECHA_COMPRA AS F FROM COMPRA,PRODUCTO WHERE COMPRA.ID_PRODUCTO=PRODUCTO.ID_PRODUCTO AND NIF='$dni' AND FECHA_COMPRA BETWEEN '$fechaDesde' AND '$fechaHasta'";
	$resultado = mysqli_query($db, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$productos[] = "NOMBRE: ".$row['N']." UNIDADES: ".$row['U']." FECHA: ".$row['F'];
		}
	}
	return $productos;
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
