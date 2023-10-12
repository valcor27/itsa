<?php  
	$hostname="localhost";
	$username="root";
	$passname="";
	$database="control_gestion";

	$conexion_database = mysqli_connect($hostname, $username, $passname, $database);
	if(mysqli_connect_errno()){
		printf("Conexion Fallida: %s\n", mysqli_connect_error());
		exit();
	}
	mysqli_set_charset($conexion_database,'utf8');  
	mysqli_query($conexion_database, "SET NAMES 'utf8'"); 
	mysqli_query($conexion_database, "SET CHARACTER SET utf8"); 
	mysqli_query($conexion_database, "SET COLLATION_CONNECTION = 'utf8_general_ci'");
?>