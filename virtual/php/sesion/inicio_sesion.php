<?php  
session_start();
require("../conexion/conexion_bd.php");

$respuesta = 0;
$expediente = $_POST["expediente"];
$contrasena = $_POST["contrasena"];

$consulta = "SELECT expediente, nombres, primerApellido, segundoApellido, nivel_idNivelUsuario, estructuraReal FROM empleados WHERE expediente = '$expediente' AND contrasena = '$contrasena' AND estatus = '1' LIMIT 1";
$resultado = mysqli_query($conexion_database, $consulta);
$filas = mysqli_num_rows($resultado);

while($row = mysqli_fetch_array($resultado)){
	$expediente = $row["expediente"];
	$nombres = $row["nombres"];
	$primerApellido = $row["primerApellido"];
	$segundoApellido = $row["segundoApellido"];
	$nombre_completo = $nombres.' '.$primerApellido.' '.$segundoApellido;
	$nivel_idNivelUsuario = $row["nivel_idNivelUsuario"];
	$estructuraReal = $row["estructuraReal"];

	$_SESSION["id_software_sesion"] = $expediente;
	$_SESSION["nombre_software_sesion"] = $nombre_completo;
	$_SESSION["nivel_sesion"] = $nivel_idNivelUsuario;
	$_SESSION["estructura_real"] = $estructuraReal;

	//identificacion de niveles de usuario
	if($nivel_idNivelUsuario >= 1){
		$respuesta = "virtual/index.php";
	}
}
echo $respuesta;

mysqli_free_result($resultado);
mysqli_close($conexion_database);
?>