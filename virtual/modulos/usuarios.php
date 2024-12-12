<?php require("../php/sesion/logueo.php") ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> CONTROL DE GESTIÓN</title>
</head>
<body>
    <main id="contenido_pagina">
        <div class="container mt-5">
			<input type="hidden" id="url_paginar" name="url_paginar" value="php/ssa_usuarios/paginacion.php">
			<input type="hidden" id="url_modificar" name="url_modificar" value="php/ssa_usuarios/modificar.php">
			<input type="hidden" id="url_modificar_domicilio" name="url_modificar_domicilio" value="php/domicilio/modificar.php">
			<input type="hidden" id="url_ver" name="url_ver" value="php/ssa_usuarios/ver.php">
			<input type="hidden" id="url_estado" name="url_estado" value="php/estado/estado.php">
			<input type="hidden" id="url_municipio" name="url_municipio" value="php/estado/municipio.php">
			<input type="hidden" id="url_paginacion_plaza" name="url_paginacion_plaza" value="php/plaza/paginacion_plaza.php">
            <div class="wrraper">
				<div class="row">
					<div class="col-sm-12">
						<div class="card my-4">
							<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
								<div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 ">
									<div class="row justify-content-center">
										<div class="col-auto align-items-center">
											<h6 class="text-white ps-3 title-pagina"><i class="fa-regular fa-user"></i> módulo de usuarios</h6>
										</div>
									</div>
									<div class="row justify-content-between">
										<div class="col-auto">
											<form id="buscar" name="buscar" onsubmit="return Pagination_usuarios(1);">
												<div class="input-group mb-3 ps-3">
													<input type="text" name="busqueda" id="busqueda" class="form-control" placeholder="Buscar Usuario">
													<button class="btn btn-outline-light" type="submit" id="button-addon2">Buscar</button>
												</div>  
											</form>
										</div>
										<div class="col-auto">
											<div class="d-flex justify-content-end ps-3 me-5">
												<button type="button" class="btn btn-outline-light" onclick="Modal_configuracion_usuarios();">
													<i class="fa-solid fa-user-plus"></i>
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="container">
								<div class="card-body px-0 pb-2">
									<div class="card mb-4">
										<div class="card-header cheader">
											<i class="fas fa-folder-open"></i>
											Listado de Registros
										</div>
										<div class="card-body">
											<div id="agrega-registros">Datos Tabla</div>     
										</div>
										<div class="card-footer text-muted">
											<div class="row">
												<div class="col-sm-6">
													<div id="pagination_info">Datos Paginas</div>
												</div>
												<div class="col-sm-6 d-flex justify-content-end">
													<nav aria-label="Page navigation example">
														<div id="pagination">No. de paginas</div>
													</nav>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
		<div class="modal fade" id="modal_usuarios_ssa" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_usuarios_ssa_label" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title" id="modal_usuarios_ssa_label"></h6>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form action="php/ssa_usuarios/registro.php" id="form_usuarios_ssa" name="form_usuarios_ssa" onsubmit="return Registrar_usuarios_ssa();">
						<input class="form-control" type="hidden" name="proceso" id="proceso" required>
						<div class="modal-body">
							<div class="row justify-content-center">
								<div class="col-md-10" id="alert_sugerencia">
									<div class="alert alert-info" role="alert">
										<strong><i class="fa-solid fa-circle-info"></i> ¡Atención!</strong> Se sugiere poner como contraseña el EXPEDIENTE del empleado, después él podrá modificar la contraseña desde su inicio.
									</div>
								</div>
								<div class="col-md-6">
									<label for="expediente" class="form-label">Expediente</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-id-badge"></i></span>
										<input type="text" id="expediente" maxlength="10" name="expediente" class="form-control" placeholder="Expediente" aria-label="Expediente" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-6">
									<label for="contrasena_usuario" class="form-label">Contraseña</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-user-lock"></i></span>
										<input type="password" id="contrasena_usuario" name="contrasena_usuario" class="form-control" placeholder="Contraseña" aria-label="Contraseña" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-4">
									<label for="nom_usuario" class="form-label">Nombres</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-circle-user"></i></span>
										<input type="text" id="nom_usuario" name="nom_usuario" class="form-control" placeholder="Nombres" aria-label="Nombres" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-4">
									<label for="primer_apellido" class="form-label">Primer Apellido</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-circle-user"></i></span>
										<input type="text" id="primer_apellido" name="primer_apellido" class="form-control" placeholder="Primer Apellido" aria-label="Primer Apellido" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-4">
									<label for="segundo_apellido" class="form-label">Segundo Apellido</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-circle-user"></i></span>
										<input type="text" id="segundo_apellido" name="segundo_apellido" class="form-control" placeholder="Segundo Apellido" aria-label="Segundo Apellido" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-4">
									<label for="sexo_usuario" class="form-label">Género</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-venus-mars"></i></span>
										<select class="form-select" name="sexo_usuario" id="sexo_usuario" aria-label="Default select example" required="">
										<option selected disabled>Género</option>
										<option value="1">Masculino</option>
										<option value="2">Femenino</option>
									</select>
									</div>
								</div>
								<div class="col-md-4">
									<label for="fNaci" class="form-label">Fecha de Nacimiento</label>
									<div class="input-group mb-3 date">
										<span class="input-group-text"><i class="fa-regular fa-calendar-days"></i></span>
										<input type="text" id="fNaci" name="fNaci" class="form-control" placeholder="Fecha de Nacimiento" aria-label="Fecha de Nacimiento" aria-describedby="basic-addon1" required="" data-provide="datepicker">
									</div>
								</div>
								<div class="col-md-4">
									<label for="rfc_usuario" class="form-label">RFC</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-id-card"></i></span>
										<input type="text" id="rfc_usuario" maxlength="14" name="rfc_usuario" class="form-control" placeholder="RFC" aria-label="RFC" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-4">
									<label for="curp_usuario" class="form-label">CURP</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-id-card"></i></span>
										<input type="text" id="curp_usuario" maxlength="19" name="curp_usuario" class="form-control" placeholder="CURP" aria-label="CURP" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-4">
									<label for="cel_usuario" class="form-label">Celular</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-mobile-screen-button"></i></span>
										<input type="text" id="cel_usuario" maxlength="10" name="cel_usuario" class="form-control" placeholder="Celular" aria-label="Celular" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-4">
									<label for="emailp_usuario" class="form-label">Email Personal</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-at"></i></span>
										<input type="email" id="emailp_usuario" name="emaip_usuario" class="form-control" placeholder="Email Personal" aria-label="Email Personal" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-4">
									<label for="emaili_usuario" class="form-label">Email Institucional</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-at"></i></span>
										<input type="email" id="emaili_usuario" name="emaili_usuario" class="form-control" placeholder="Email Institucional" aria-label="Email Institucional" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-4">
									<label for="fAlta" class="form-label">Fecha de Alta</label>
									<div class="input-group mb-3 date">
										<span class="input-group-text"><i class="fa-regular fa-calendar-days"></i></span>
										<input type="text" id="fAlta" name="fAlta" class="form-control" placeholder="Fecha de Alta" aria-label="Fecha de Alta" aria-describedby="basic-addon1" required="" data-provide="datepicker">
									</div>
								</div>
								<div class="col-md-4">
									<label for="nivel_usuario" class="form-label">Tipo de Usuario</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-address-book"></i></span>
										<select class="form-select" name="nivel_usuario" id="nivel_usuario" aria-label="Default select example" required="" onchange="return Pagination_inputs_empleados();">
										<option selected disabled>Tipo de usuario</option>
										<option value="1">Director General</option>
										<option value="2">Director</option>
										<option value="3">Subdirector</option>
										<option value="4">Jefe de Departamento</option>
										<option value="5">Administrativo</option>
										<option value="6">Jefe de División</option>
										<option value="7">Docente</option>
									</select>
									</div>
								</div>
								<div class="col-md-4">
									<label for="plaza_usuario" class="form-label">Plaza</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-address-book"></i></span>
										<select class="form-select" name="plaza_usuario" id="plaza_usuario" aria-label="Default select example" required="">
									</select>
									</div>
								</div>
								<div class="col-md-4">
									<label for="unidadReal_usuario" class="form-label">Unidad Adscrito Real</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-address-book"></i></span>
										<select class="form-select" name="unidadReal_usuario" id="unidadReal_usuario" aria-label="Default select example" required="">
											<option selected disabled>Unidad Adscrito Real</option>
											<option value="10000">Dirección General</option> 	
											<option value="11000">Dirección Académica</option>
											<option value="12000">Dirección de Planeación y Vinculación</option>
											<option value="10100">Subdirección de Servicios Administrativos</option>
											<option value="12100">Subdirección de Planeación </option>
											<option value="12200">Subdirección de Vinculación</option>
											<option value="11100">Subdirección de Posgrado e Investigación</option>
											<option value="11200">Subdirección Académica</option>
											<option value="10110">Departamento de Personal</option>
											<option value="10120">Departamento de Recursos Financieros </option>
											<option value="10130">Departamento de Recursos Materiales y Servicios</option>
											<option value="12110">Departamento de Planeación y Programación</option>
											<option value="12120">Departamento de Estadística y Evaluación</option>
											<option value="12130">Departamento de Control Escolar</option>
											<option value="12210">Departamento de Vinculación</option>
											<option value="12220">Departamento de Difusión y Concertación</option>
											<option value="12230">Departamento de Residencias Profesionales y Servicio Social</option>
											<option value="11110">Departamento de Posgrado e Investigación</option>
											<option value="11201">División de Ingeniería Bioquímica </option>
											<option value="11202">División de Ingeniería Electromecánica</option>
											<option value="11203">División de Gastronomía</option>
											<option value="11204">División de Ingeniería en Sistemas Computacionales</option>
											<option value="11205">División de Ingeniería Industrial</option>
											<option value="11206">División de Ingeniería Mecatrónica</option>
											<option value="11210">Departamento de Desarrollo Académico</option>
											<option value="11220">Departamento de Ciencias Básicas</option>	 	 		
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<label for="unidadReportada_usuario" class="form-label">Unidad Adscrito Reportada</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-address-book"></i></span>
										<select class="form-select" name="unidadReportada_usuario" id="unidadReportada_usuario" aria-label="Default select example" required="">
											<option selected disabled>Unidad Adscrito Reportada</option>
											<option value="10000">Dirección General</option> 	
											<option value="11000">Dirección Académica</option>
											<option value="12000">Dirección de Planeación y Vinculación</option>
											<option value="10100">Subdirección de Servicios Administrativos</option>
											<option value="12100">Subdirección de Planeación </option>
											<option value="12200">Subdirección de Vinculación</option>
											<option value="11100">Subdirección de Posgrado e Investigación</option>
											<option value="11200">Subdirección Académica</option>
											<option value="10110">Departamento de Personal</option>
											<option value="10120">Departamento de Recursos Financieros </option>
											<option value="10130">Departamento de Recursos Materiales y Servicios</option>
											<option value="12110">Departamento de Planeación y Programación</option>
											<option value="12120">Departamento de Estadística y Evaluación</option>
											<option value="12130">Departamento de Control Escolar</option>
											<option value="12210">Departamento de Vinculación</option>
											<option value="12220">Departamento de Difusión y Concertación</option>
											<option value="12230">Departamento de Residencias Profesionales y Servicio Social</option>
											<option value="11110">Departamento de Posgrado e Investigación</option>
											<option value="11201">División de Ingeniería Bioquímica </option>
											<option value="11202">División de Ingeniería Electromecánica</option>
											<option value="11203">División de Gastronomía</option>
											<option value="11204">División de Ingeniería en Sistemas Computacionales</option>
											<option value="11205">División de Ingeniería Industrial</option>
											<option value="11206">División de Ingeniería Mecatrónica</option>
											<option value="11210">Departamento de Desarrollo Académico</option>
											<option value="11220">Departamento de Ciencias Básicas</option>	 
										</select>
									</div>
								</div>
								<div class="col-md-4 columna_horario_admon" style="display: none;" id="hora_entrada_a">
									<label for="hora_entrada_admon" class="form-label">Hora Entrada</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-clock"></i></span>
										<input type="time" id="hora_entrada_admon" name="hora_entrada_admon" class="form-control" placeholder="Hora Entrada" aria-label="Hora Entrada" aria-describedby="basic-addon1" disabled>
									</div>
								</div>
								<div class="col-md-4 columna_horario_admon" style="display: none;" id="hora_salida_a">
									<label for="hora_salida_admon" class="form-label">Hora Salida</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-clock"></i></span>
										<input type="time" id="hora_salida_admon" name="hora_salida_admon" class="form-control" placeholder="Hora Salida" aria-label="Hora Salida" aria-describedby="basic-addon1" disabled>
									</div>
								</div>
								<div class="col-md-10" id="alert_error">
									<div class="alert alert-danger" role="alert">
										<strong><i class="fa-solid fa-triangle-exclamation"></i> ¡Error!</strong> El Expediente ingresado ya esta dado de alta para otro empleado.
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-success" id="btn_agregar_usuario">Registrar</button>
							<button type="submit" class="btn btn-success" id="btn_actualizar_usuario">Actualizar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modal_usuarios_ssa_v" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_usuarios_ssa_v_label" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title" id="modal_usuarios_ssa_v_label"></h6>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form  id="form_usuarios_ss_v" name="form_usuarios_ssa_v" >
						<div class="modal-body">
							<div class="row justify-content-center">
								<div class="col-md-3">
									<label for="expediente_v" class="form-label">Expediente</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-id-badge"></i></span>
										<input disabled type="text" id="expediente_v" name="expediente_v" class="form-control" placeholder="Expediente" aria-label="Expediente" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-9">
									<label for="nom_usuario_v" class="form-label">Nombre</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-circle-user"></i></span>
										<input disabled type="text" id="nom_usuario_v" name="nom_usuario_v" class="form-control" placeholder="Nombre" aria-label="Nombre" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-4">
									<label for="sexo_v" class="form-label">Género</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-venus-mars"></i></span>
										<input disabled type="text" id="sexo_v" name="sexo_v" class="form-control" placeholder="Género" aria-label="Género" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-3">
									<label for="fNaci_v" class="form-label">Fecha de Nacimiento</label>
									<div class="input-group mb-3 date">
										<span class="input-group-text"><i class="fa-regular fa-calendar-days"></i></span>
										<input disabled type="text" id="fNaci_v" name="fNaci_v" class="form-control" placeholder="Fecha de Nacimiento" aria-label="Fecha de Nacimiento" aria-describedby="basic-addon1" required="" data-provide="datepicker">
									</div>
								</div>
								<div class="col-md-5">
									<label for="rfc_usuario_v" class="form-label">RFC</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-id-card"></i></span>
										<input disabled type="text" id="rfc_usuario_v" name="rfc_usuario_v" class="form-control" placeholder="RFC" aria-label="RFC" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-6">
									<label for="curp_usuario_v" class="form-label">CURP</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-id-card"></i></span>
										<input disabled type="text" id="curp_usuario_v" name="curp_usuario_v" class="form-control" placeholder="CURP" aria-label="CURP" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-3">
									<label for="cel_usuario_v" class="form-label">Celular</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-mobile-screen-button"></i></span>
										<input disabled type="text" id="cel_usuario_v" name="cel_usuario_v" class="form-control" placeholder="Celular" aria-label="Celular" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-3">
									<label for="fAlta_v" class="form-label">Fecha de Alta</label>
									<div class="input-group mb-3 date">
										<span class="input-group-text"><i class="fa-regular fa-calendar-days"></i></span>
										<input disabled type="text" id="fAlta_v" name="fAlta_v" class="form-control" placeholder="Fecha de Alta" aria-label="Fecha de Alta" aria-describedby="basic-addon1" required="" data-provide="datepicker">
									</div>
								</div>
								<div class="col-md-6">
									<label for="emailp_usuario_v" class="form-label">Email Personal</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-at"></i></span>
										<input disabled type="email" id="emailp_usuario_v" name="emaip_usuario_v" class="form-control" placeholder="Email Personal" aria-label="Email Personal" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-6">
									<label for="emaili_usuario_v" class="form-label">Email Institucional</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-at"></i></span>
										<input disabled type="email" id="emaili_usuario_v" name="emaili_usuario_v" class="form-control" placeholder="Email Institucional" aria-label="Email Institucional" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-6">
									<label for="c_plaza_v" class="form-label">Código Plaza</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-address-book"></i></span>
										<input disabled type="text" id="c_plaza_v" name="c_plaza_v" class="form-control" placeholder="Código Plaza" aria-label="Código Plaza" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-6">
									<label for="n_plaza_v" class="form-label">Nombre Plaza</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-address-book"></i></span>
										<input disabled type="text" id="n_plaza_v" name="n_plaza_v" class="form-control" placeholder="Nombre Plaza" aria-label="Nombre Plaza" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-12">
									<label for="uaReal" class="form-label">Unidad Adscrito Real</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-address-book"></i></span>
										<input disabled type="text" id="uaReal" name="uaReal" class="form-control" placeholder="Unidad Adscrito Real" aria-label="Unidad Adscrito Real" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-12">
									<label for="uaReportada" class="form-label">Unidad Adscrito Reportada</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-address-book"></i></span>
										<input disabled type="text" id="uaReportada" name="uaReportada" class="form-control" placeholder="Unidad Adscrito Reportada" aria-label="Unidad Adscrito Reportada" aria-describedby="basic-addon1" required="">
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modal_domicilio" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_domicilio_label" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title" id="modal_domicilio_label"></h6>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form  action="php/domicilio/registro.php" id="form_domicilio" name="form_domicilio" onsubmit="return Registrar_domicilio_usuarios();">
					<input class="form-control" type="hidden" name="proceso_domicilio" id="proceso_domicilio" required>
					<input class="form-control" type="hidden" name="id_domicilio" id="id_domicilio" value="0" required>
					<input class="form-control" type="hidden" name="id_domicilio_usuario" id="id_domicilio_usuario" required>
					<input class="form-control" type="hidden" name="valor_municipio" id="valor_municipio" value="0">

						<div class="modal-body">
							<div class="row justify-content-center">
								<div class="col-md-6">
									<label for="calle" class="form-label">Calle</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-road"></i></span>
										<input type="text" id="calle" name="calle" class="form-control" placeholder="Calle" aria-label="Calle" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-3">
									<label for="next" class="form-label">No. Exterior</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-hashtag"></i></span>
										<input type="text" id="next" name="next" class="form-control" placeholder="No. Exterior" aria-label="No. Exterior" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-3">
									<label for="nint" class="form-label">No. Interior</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-hashtag"></i></span>
										<input type="text" id="nint" name="nint" class="form-control" placeholder="No. Interior" aria-label="No. Interior" aria-describedby="basic-addon1">
									</div>
								</div>
								<div class="col-md-5">
									<label for="col" class="form-label">Colonia</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-street-view"></i></span>
										<input type="text" id="col" name="col" class="form-control" placeholder="Colonia" aria-label="Colonia" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-3">
									<label for="cpostal" class="form-label">Código Postal</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-arrow-up-1-9"></i></span>
										<input type="text" id="cpostal" name="cpostal" class="form-control" placeholder="Código Postal" aria-label="Código Postal" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-4">
									<label for="local" class="form-label">Localidad</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-compass"></i></span>
										<input type="text" id="local" name="local" class="form-control" placeholder="Localidad" aria-label="Localidad" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-5">
									<label for="estado" class="form-label">Estado</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-earth-americas"></i></span>
										<select class="form-select" name="estado" id="estado" aria-label="Default select example" onchange="return Pagination_municipios();" required="">
										</select>
									</div>
								</div>
								<div class="col-md-7">
									<label for="municipio" class="form-label">Municipios</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-earth-americas"></i></span>
										<select class="form-select" name="municipio" id="municipio" aria-label="Default select example" required="">
										</select>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-success" id="btn_agregar_domicilio">Registrar</button>
							<button type="submit" class="btn btn-success" id="btn_actualizar_domicilio">Actualizar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
    </main> 
    <script>
        $(document).ready(function(){
            Pagination_usuarios(1);
			Pagination_estado(1);
			Pagination_plaza(1);
			$(function () {
        		$("#fNaci").datepicker({
            		language: 'es',
					format: 'dd-mm-yyyy',
					autoclose: 'true'
        		});
    		});
			$(function () {
        		$("#fAlta").datepicker({
            		language: 'es',
					format: 'dd-mm-yyyy',
					autoclose: 'true'
        		});
    		});
        });
    </script>
</body>
</html>