<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="Joan Santiago Valle Corona / Juan Carlos Valle Corona / FamilySystems ©">
    <title>CONTROL DE GESTIÓN</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="picker/bootstrap-datepicker3.standalone.min.css">
    <link rel="stylesheet" href="sweetalert/css/sweetalert.css">
	<link rel="stylesheet" href="bselect/css/bootstrap-select.min.css">	
</head>
<body>
    <input type="hidden" id="url_sesion" value="php/sesion/sesion.php">
    <input type="hidden" id="url_logout" value="php/sesion/logout.php">
    <input type="hidden" id="url_modificar_sesion_configuracion" name="url_modificar_sesion_configuracion" value="php/sesion_configuracion/modificar.php">
   <!----------------------------------navbar---------------------------------------------->
	<header>
		<nav class="navbar navbar-expand-lg">
			<div class="container-fluid">
            	<a class="navbar-brand" href="#"><img src="img/logo.png" alt="LOGO"></a>
            	<button class="btn btn-outline-menu me-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#aside_menu_cp" aria-controls="aside_menu_cp">
					   <i class="fa-solid fa-bars"></i>
				</button>
				<div class="lado-right">
					<div class="lado-dots">
						<div class="dropdown">
							<button type="button" class="btn btn-outline-danger btn-notificaciones dropdown-toggle sin-flecha" data-bs-toggle="dropdown" aria-expanded="false">
								<i class="fa-solid fa-bell icon-notificaciones"></i>
								<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
    								99+
    								<span class="visually-hidden">unread messages</span>
  								</span>
							</button>
  							<ul class="dropdown-menu" id="dropdown-notificaciones">
								<div class="dropdown-header justify-content-center">
							  		<optgroup class="text-center" label="Control de Notificaciones"></optgroup>
								</div>
								<div class="d-flex flex-column flex-md-row gap-4 align-items-center justify-content-center">
									<div class="list-group">
										<a class="list-group-item list-group-item-action d-flex gap-3 py-3" href="#" aria-current="true">
											<!--<img class="rounded-cricle flex-shrink-0" src="https://github.com/twbs.png" alt="twbs" width="32" height="32">-->
											<div class="d-flex gap-2 w-100 justify-content-between">
												<div>
													<h6 class="mb-0 folio-notificaciones">Documento SSA/MLGM/001</h6>
													<p class="mb-0 opacity-75 mensaje-notificaciones">Joan Santiago Valle Corona, Envió el documento a Recursos Materiales y Servicios</p>
												</div>
												<small class="opacity-50 text-nowrap fecha-notificaciones">30/10/2023</small>
											</div>
										</a>
									</div>
								</div>
							</ul>
						</div>
					</div>
					<div class="nav-item dropdown dropdown-user lado-btn-lg">
                		<div id="datos_sesion"></div>
            		</div>
				</div>
         	</div>
      	</nav>
   	</header> 
   <!-------------------------------------------------------------------------------->
   <!------------------------------------ aside---------------------------- -->
	<div class="offcanvas offcanvas-start offcanvas-menu" data-bs-backdrop="static" tabindex="-1" id="aside_menu_cp" aria-labelledby="staticBackdropLabel">
		<div class="offcanvas-header">
			<h5 class="offcanvas-title" id="staticBackdropLabel"><img src="img/logo.png" alt="LOGO"></h5>
			<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
		</div>
		<div class="offcanvas-body">
			<div class="container nav-offcanvas">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php require("php/navegacion/navigation.php"); ?>
				</ul>
			</div>
		</div>
	</div>
   <!---------------------------------------------------------------------------->
   <!------------------------------Contenido de la pagina---------------------------------------------->
   	<main id="contenido_pagina">
   		<div class="container-fluid px-4">
			<h6 class="mt-4 title-pagina"><i class="fa-solid fa-house-chimney"></i> SISTEMA PC_CONTROL</h6>
			<ol class="breadcrumb mb-4">
			</ol>
			<div class="row demo-nifty-panel">
				<div class="col-md 12">
					<div class="card image-container">
						<img src="img/itsa1.jpg" class="card-img img-home" alt="IMAGE HOME">
						<div class="card-img-overlay home-card">
							<h5 class="card-title">Bienvenidos</h5>
							<p class="card-text">Visita nuestras redes sociales.</p>
							<div class="row">
								<div class="col-md-12 redes">
								<a href="https://www.facebook.com/TecNMCampusAtlixco" class="fb" target="_blank"><i class="reicon fa-brands fa-facebook-f mr-4"></i></a>
								<a href="https://www.instagram.com/tecnmcampusatlixco/" class="ins" target="_blank"><i class="reicon fa-brands fa-instagram mr-4"></i></a>
								<a href="https://twitter.com/TecAtlixco" class="x" target="_blank"><i class="reicon fa-brands fa-twitter mr-4"></i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
   	</main> 
   <!----------------------------------footer------------------------------------------>
   <footer id="footer" class="mt-3">
   		<div class="d-grid gap-2 d-md-flex justify-content-md-end">
			<div class="copyright text-center text-sm text-muted text-lg-start me-2">
				© <script>
					document.write(new Date().getFullYear())
				</script>,
				made with <i class="fa fa-heart icon-footer"></i> by
				<a href="#" class="a-footer" target="_blank">FamilySystems</a>.
			</div>
		</div>
	</footer>
   <!---------------------------------------------------------------------------->
   <!--------------------------Modal sesión configuración del usuario-------------------------------------------------->
   <div class="modal fade" id="modal_sesion_configuracion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_sesion_configuracion_label" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="modal-title" id="modal_sesion_configuracion_label"></h6>
					<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form action="php/sesion_configuracion/registro.php" id="form_configuracion_sesion" name="form_configuracion_sesion" onsubmit="return Registrar_sesion_configuracion();">
					<input class="form-control" type="hidden" name="pro_sesion" id="pro_sesion" required>
             		<input class="form-control" type="hidden" name="id_sesion" id="id_sesion" value="0" required>
					<div class="modal-body">
						<div class="row justify-content-center">
                            <div class="col-md-4">
								<label for="expediente_sesion" class="form-label">Expediente</label>
								<div class="input-group mb-3">
									<span class="input-group-text"><i class="fa-regular fa-id-badge"></i></span>
									<input type="text" id="expediente_sesion" name="expediente_sesion" class="form-control" placeholder="Tipo Usuario" aria-label="Tipo Usuario" aria-describedby="basic-addon1" disabled="">
								</div>
							</div>
							<div class="col-md-8">
								<label for="nom_usuario_sesion" class="form-label">Nombre Usuario</label>
								<div class="input-group mb-3">
									<span class="input-group-text"><i class="fa-solid fa-circle-user"></i></span>
									<input type="text" id="nom_usuario_sesion" name="nom_usuario_sesion" class="form-control" placeholder="Nombre Usuario" aria-label="Nombre Usuario" aria-describedby="basic-addon1" disabled="">
								</div>
							</div>
							<div class="col-md-6">
								<label for="contrasena_sesion" class="form-label">Contraseña</label>
								<div class="input-group mb-3">
									<span class="input-group-text"><i class="fa-solid fa-user-lock"></i></span>
									<input type="password" id="contrasena_sesion" name="contrasena_sesion" class="form-control" placeholder="Contraseña" aria-label="Contraseña" aria-describedby="basic-addon1" required="">
								</div>
							</div>
							<div class="col-md-6">
								<label for="nivel_sesion" class="form-label">Nivel Usuario</label>
								<div class="input-group mb-3">
									<span class="input-group-text"><i class="fa-regular fa-address-book"></i></span>
									<input type="text" id="nivel_sesion" name="nivel_sesion" class="form-control" placeholder="Tipo Usuario" aria-label="Tipo Usuario" aria-describedby="basic-addon1" disabled="">
								</div>
							</div>
                            <div class="col-md-12">
								<label for="uareal" class="form-label">Unidad Adscrita</label>
								<div class="input-group mb-3">
									<span class="input-group-text"><i class="fa-regular fa-address-book"></i></span>
									<input type="text" id="uareal" name="uareal" class="form-control" placeholder="Tipo Usuario" aria-label="Tipo Usuario" aria-describedby="basic-addon1" disabled="">
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-success" id="btn_configuracion_sesion">Actualizar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
    <!---------------------------------------------------------------------------->
   <script src="jquery/jquery.min.js"></script>
	<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="fontawesome/js/all.min.js"></script>
    <script src="picker/bootstrap-datepicker.min.js"></script>
    <script src="picker/bootstrap-datepicker.es.min.js"></script>
	<script src="sweetalert/js/sweetalert.min.js"></script>
	<script src="bselect/js/bootstrap-select.min.js"></script>
	<script src="bselect/js/defaults-es_ES.min.js"></script>
	<script src="chart/chart.umd.min.js"></script>
	<script src="js/componentes.js"></script>
    <script src="js/vistas.js"></script>
    <script>
        $(document).ready(function(){
            Sesion_activa(1);
			$(function () {
				//$('.selectpicker').selectpicker();
			});
        });
    </script>
</body>
</html>