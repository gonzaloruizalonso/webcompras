<?php
/* Conexión BD */
define('DB_SERVER', '10.130.10.56');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'rootroot');
define('DB_DATABASE', 'COMPRASWEB');
$conn = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);

   if (!$conn) {
		die("Error conexión: " . mysqli_connect_error());
	}
?>
