<?php  
	require ("../conexion/conexion_bd.php");
	require ("../sesion/logueo.php");
	require("../clases/limpiar.php");
	$id = $_POST["id_sesion"];
	$proceso = $_POST["pro_sesion"];
	$contrasena = $_POST["contrasena_sesion"];
	switch ($proceso) {
		case 'Edicion':
			$actualiza = "UPDATE empleados SET contrasena = '$contrasena' WHERE expediente = '$id' LIMIT 1";
			$resultado_actualiza = mysqli_query($conexion_database, $actualiza);
		break;
	}
	mysqli_close($conexion_database);
?>