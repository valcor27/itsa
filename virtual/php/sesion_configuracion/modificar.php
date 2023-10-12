<?php  
	require("../conexion/conexion_bd.php");
	require("../sesion/logueo.php");

	$id = $_POST["id"];
	$nivel_idnivel = $nivel_sesion;	
	/*Consultamos la base de datos*/
	$consulta = "SELECT expediente, primerApellido, segundoApellido, 
	nombres, contrasena, real_nombreUnidad FROM empleados 
	WHERE expediente = '$id' LIMIT 1";
	$resultado = mysqli_query($conexion_database, $consulta);
	$datos = array();
	while($row = mysqli_fetch_array($resultado)){
		$expediente = $row['expediente'];
		$nombre = $row['nombres'];
		$apepat = $row['primerApellido'];
		$apemat = $row['segundoApellido'];
		$nombre_completo = $nombre.' '.$apepat.' '.$apemat;
		$contrasena = $row['contrasena'];
		$real = $row['real_nombreUnidad'];
	}
	if($nivel_idnivel == 1){
		$nombre_nivel_sesion = "Director General ";
	}else if($nivel_idnivel == 2){
		$nombre_nivel_sesion = "Director";
	}else if($nivel_idnivel == 3){
		$nombre_nivel_sesion = "Subdirector";
	}else if($nivel_idnivel == 4){
		$nombre_nivel_sesion = "Jefe de Departamento";
	}else if($nivel_idnivel == 5){
		$nombre_nivel_sesion = "Administrativo";
	}else if($nivel_idnivel == 6){
		$nombre_nivel_sesion = "Jefe de División";
	}else if($nivel_idnivel == 7){
		$nombre_nivel_sesion = "Docente";
	}

	$datos = array(
		0 => $expediente,
		1 => $nombre_completo,
		2 => $contrasena,
		3 => $nombre_nivel_sesion,
		4 => $real
	);
	echo json_encode($datos);
	mysqli_free_result($resultado);
	mysqli_close($conexion_database);
?>