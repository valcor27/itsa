<?php 
    session_start();
    $tabla='';
	$intruso=1; 

    if (isset($_SESSION['id_software_sesion'])) {

		$id_software_sesion=$_SESSION["id_software_sesion"];
		$nombre_software_sesion = $_SESSION["nombre_software_sesion"];
		$nivel_sesion = $_SESSION["nivel_sesion"];
		//$estructura_real = $_SESSION["estructura_real"];


		/*Verificamos el nombre del usuario con sesion iniciada*/
	        if($nivel_sesion > 0){
				$tabla=$tabla.'
				<a class="nav-link dropdown-toggle" id="navbarDropdownSesion" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
					<span class="ic-user pull-right">
                   		<i class="fas fa-user"></i> '.$nombre_software_sesion.'          
                    </span>
				</a>
				<ul class="dropdown-menu" aria-labelledby="navbarDropdownSesion">
					<li onclick="Modificar_sesion_configuracion('.$id_software_sesion.');">
						<a class="dropdown-item" href="#">
							<i class="fas fa-user-cog icon-lg icon-fw"></i> Configuración
						</a>
					</li>
					<li><hr class="dropdown-divider" /></li>
					<li onclick="Logout('.$id_software_sesion.');">
						<a class="dropdown-item" href="#">
							<i class="fas fa-sign-out-alt icon-lg icon-fw"></i> Cerrar Sesión
						</a>
					</li>
				</ul>
				';
				$intruso=0;
			}
    	/*--------------------------------------------------------------------------------------------------------------*/ 
	}

    $array = array(
		0 => $tabla,
		1 => $intruso
	);
  	echo json_encode($array);
?>					