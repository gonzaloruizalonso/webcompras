<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Web compras</title>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>

<body>
<h1>ALTA CLIENTE - Gonzalo Ruiz</h1>
<?php
include "conexion.php";
mysqli_query($conn, "begin;");
$categorias = obtenerCategorias($conn);
/* Se muestra el formulario la primera vez */
if (!isset($_POST) || empty($_POST)) {

    /* Se inicializa la lista valores*/
	echo '<form action="" method="post">';
?>
<div class="container ">
<!--Aplicacion-->
<div class="card border-success mb-3" style="max-width: 30rem;">
<div class="card-header">Datos CLIENTE</div>
<div class="card-body">
		<div class="form-group">
        NIF <input type="text" name="nif" placeholder="nif" class="form-control">
        </div>
		<div class="form-group">
        NOMBRE <input type="text" name="nombre" placeholder="nombre" class="form-control">
        </div>
		<div class="form-group">
        APELLIDO <input type="text" name="apellido" placeholder="apellido" class="form-control">
        </div>
    <div class="form-group">
        CP <input type="text" name="cp" placeholder="cp" class="form-control">
    </div>
    <div class="form-group">
        DIRECCION <input type="text" name="direccion" placeholder="direccion" class="form-control">
    </div>
    <div class="form-group">
        CIUDAD <input type="text" name="ciudad" placeholder="ciudad" class="form-control">
    </div>
	</BR>
<?php
	echo '<div><input type="submit" value="Alta cliente"></div>
	</form>';
} else {
	// Aquí va el código al pulsar submit
  $nif = stripslashes(htmlspecialchars(trim($_REQUEST['nif'])));
  $nombre = stripslashes(htmlspecialchars(trim($_REQUEST['nombre'])));
  $apellido = stripslashes(htmlspecialchars(trim($_REQUEST['apellido'])));
  $cp = stripslashes(htmlspecialchars(trim($_REQUEST['cp'])));
  $direccion = stripslashes(htmlspecialchars(trim($_REQUEST['direccion'])));
  $ciudad = stripslashes(htmlspecialchars(trim($_REQUEST['ciudad'])));

  $user = strtolower($nombre);
  $pass = strtolower($apellido);
  $pass = strrev($pass);

  function dniEsValido($string) {
    if (strlen($string) != 9 ||
        preg_match('/^[XYZ]?([0-9]{7,8})([A-Z])$/i', $string) !== 1) {
        return false;
    }else {
      return true;
    }
}
  if (dniEsValido($nif)) {

      $sqlprevio = "SELECT NIF FROM CLIENTE WHERE NIF='$nif' ";
      $result = mysqli_query($conn, $sqlprevio);
      $fila = mysqli_fetch_assoc($result);
      $idcat = $fila['NIF'];
      if (mysqli_query($conn, $sqlprevio)) {
        if ($idcat!=$nif) {
          //INSERT
          $sql="INSERT INTO CLIENTE (NIF,NOMBRE,APELLIDO,USUARIO,PASSWORD,CP,DIRECCION,CIUDAD)
          VALUES ('$nif','$nombre','$apellido','$user','$pass','$cp','$direccion','$ciudad')";
          if (mysqli_query($conn, $sql)) {
            echo "Cliente agregado correctamente";
          } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            mysqli_query($conn, "rollback;");
          }
        }else {
          echo "Ya existe un cliente con ese DNI";
        }
      }else {
        echo "Error: <br>" . mysqli_error($conn);
        mysqli_query($conn, "rollback;");
      }
      mysqli_query($conn, "commit;");
      mysqli_close($conn);


  }else {
    // NIF MAL
    echo "NIF INCORRECTO";
  }



}
?>

<?php
// Funciones utilizadas en el programa
function obtenerCategorias($db) {
	$categorias = array();
	$sql = "SELECT NOMBRE FROM CATEGORIA";
	$resultado = mysqli_query($db, $sql);
	if ($resultado) {
		while ($row = mysqli_fetch_assoc($resultado)) {
			$categorias[] = $row['NOMBRE'];
		}
	}
	return $categorias;
}







?>



</body>

</html>
