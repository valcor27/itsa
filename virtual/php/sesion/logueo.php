<?php
session_start();

if (isset($_SESSION['id_software_sesion'])) {

	$id_software_sesion=$_SESSION["id_software_sesion"];
	$nombre_software_sesion = $_SESSION["nombre_software_sesion"];
	$nivel_sesion = $_SESSION["nivel_sesion"];
	$estructura_real = $_SESSION["estructura_real"];
}else{
	header("location: ../index.php");
}
?>