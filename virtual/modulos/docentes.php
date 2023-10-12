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
			<input type="hidden" id="url_paginar" name="url_paginar" value="php/docentes/paginacion.php">
			<input type="hidden" id="url_modificar" name="url_modificar" value="php/docentes/modificar.php">
            <input type="hidden" id="url_buscar_docentes" name="url_buscar_docentes" value="php/docentes/select_docentes.php">
			<input type="hidden" id="url_estudios_docentes" name="url_estudios_docentes" value="php/docentes/estudios_docentes.php">
			<input type="hidden" id="url_paginar_nivel_estudios" name="url_paginar_nivel_estudios" value="php/docentes/select_nivel_estudios.php">
			<input type="hidden" id="url_modificar_estudios_docente" name="url_modificar_estudios_docente" value="php/docentes/modificar_estudios.php">
			<input type="hidden" id="url_eliminar_estudio_docente" name="url_eliminar_estudio_docente" value="php/docentes/eliminar_estudios.php">
			
            <!--<input type="hidden" id="url_buscar_division" name="url_buscar_division" value="php/division/buscar_division.php">-->
            <div class="wrraper">
				<div class="row">
					<div class="col-sm-12">
						<div class="card my-4">
							<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
								<div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 ">
									<div class="row justify-content-center">
										<div class="col-auto align-items-center">
											<h6 class="text-white ps-3 title-pagina"><i class="fa-solid fa-chalkboard-user"></i> módulo de docentes</h6>
										</div>
									</div>
									<div class="row justify-content-between">
										<div class="col-auto">
											<form id="buscar" name="buscar" onsubmit="return Pagination_docente(1);">
												<div class="input-group mb-3 ps-3">
													<input type="text" name="busqueda" id="busqueda" class="form-control" placeholder="Buscar Docente">
													<button class="btn btn-outline-light" type="submit" id="button-addon2">Buscar</button>
												</div>  
											</form>
										</div>
										<div class="col-auto">
											<div class="d-flex justify-content-end ps-3 me-5">
												<button type="button" class="btn btn-outline-light" onclick="Modal_configuracion_docente();">
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
		<div class="modal fade" id="modal_docente" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_docente_label" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title" id="modal_docente_label"></h6>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form action="php/docentes/registro.php" id="form_docente" name="form_docente" onsubmit="return Registrar_docente();">
						<input class="form-control" type="hidden" name="proceso_docente" id="proceso_docente" required>
                        <input class="form-control" type="hidden" name="id_docente" id="id_docente" value="0" required>
						<div class="modal-body">
							<div class="row justify-content-center">
                                <div class="col-md-12">
									<label for="exp_doc" class="form-label">Expediente Docente</label>
									<div class="input-group mb-3" id="docente_select_docente">
									</div>
								</div>
								<div class="col-md-12">
									<label for="clave_docente" class="form-label">Clave Docente</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-user"></i></span>
										<input type="text" id="clave_docente" name="clave_docente" maxlength="4" class="form-control" placeholder="Clave Docente" aria-label="Clave Docente" aria-describedby="basic-addon1" required="">
									</div>
								</div>
                                <div class="col-md-10" id="alert_error">
									<div class="alert alert-danger" role="alert">
										<strong><i class="fa-solid fa-triangle-exclamation"></i> ¡Error!</strong> El docente ingresado ya esta registrado.
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-success" id="btn_agregar_docente">Registrar</button>
							<button type="submit" class="btn btn-success" id="btn_actualizar_docente">Actualizar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modal_estudios_docentes" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_estudio_docentes_label" aria-hidden="true">
			<div class="modal-dialog modal-xl">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title" id="modal_estudio_docentes_label"></h6>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<input type="hidden" class="form-control" name="id_docente_estudio" id="id_docente_estudio" value="0">
						<div class="row justify-content-center" id="datos_docente">
							<div class="col-md-6">
								<label for="nom_docente" class="form-label">Nombre Docente</label>
								<div class="input-group mb-3">
									<span class="input-group-text"><i class="fa-solid fa-circle-user"></i></span>
									<input disabled type="text" id="nom_docente" name="nom_docente" class="form-control" placeholder="Nombre" aria-label="Nombre" aria-describedby="basic-addon1" value="0">
								</div>
							</div>
							<div class="col-md-3">
								<label for="exp_docente" class="form-label">Expediente</label>
								<div class="input-group mb-3">
									<span class="input-group-text"><i class="fa-regular fa-id-badge"></i></span>
									<input disabled type="text" id="exp_docente" name="exp_docente" class="form-control" placeholder="Expediente" aria-label="Expediente" aria-describedby="basic-addon1" value="0">
								</div>
							</div>
							<div class="col-md-3">
								<label for="cla_docente" class="form-label">Clave Docente</label>
								<div class="input-group mb-3">
									<span class="input-group-text"><i class="fa-regular fa-user"></i></span>
									<input disabled type="text" id="cla_docente" name="cla_docente" class="form-control" placeholder="Clave Docente" aria-label="Clave Docente" aria-describedby="basic-addon1" value="0">
								</div>
							</div>
						</div>
						<div id="historial_estudios_docentes">

						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
						<button type="button" class="btn btn-success" onclick="Modal_registro_estudio_docente();">Registrar Nuevo Estudio</button>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modal_estudio_docente" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_estudio_docente_label" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title" id="modal_estudio_docente_label"></h6>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form action="php/docentes/registro_estudio.php" id="form_estudio_docente" name="form_estudio_docente" onsubmit="return Registrar_estudio_docente();">
						<input class="form-control" type="hidden" name="proceso_estudio_docente" id="proceso_estudio_docente" required>
                        <input class="form-control" type="hidden" name="id_docente_nivel_estudio" id="id_docente_nivel_estudio" value="0" required>
						<input class="form-control" type="hidden" name="docentes_id_docentes" id="docentes_id_docentes">
						<div class="modal-body">
							<div class="row justify-content-center">
								<div class="col-md-12">
									<label for="select_nivel_estudio" class="form-label">Grado de Estudio</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-graduation-cap"></i></span>
										<select class="form-select" name="select_nivel_estudio" id="select_nivel_estudio" aria-label="Default select example" required=""> 
											<option value="" selected disabled>Selecciona</option>
											<option value="1">Licenciatura</option>
											<option value="2">Maestría</option>
											<option value="3">Doctorado</option>
										</select>
									</div>
								</div>
								<div class="col-md-12">
									<label for="titulo" class="form-label">Folio de Título</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-id-card"></i></span>
										<input type="text" id="titulo" name="titulo" class="form-control" placeholder="Folio de Título" aria-label="Folio de Título" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-12">
									<label for="cedula" class="form-label">Folio de Cédula</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-id-card"></i></span>
										<input type="text" id="cedula" name="cedula" class="form-control" placeholder="Folio de Cédula" aria-label="Folio de Cédula" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-12">
									<label for="escuela" class="form-label">Escuela de Egreso</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-school"></i></span>
										<input type="text" id="escuela" name="escuela" class="form-control" placeholder="Escuela de Egreso" aria-label="Escuela de Egreso" aria-describedby="basic-addon1" required="">
									</div>
								</div>
                                <div class="col-md-10" id="alert_error_estudios">
									<div class="alert alert-danger" role="alert">
										<strong><i class="fa-solid fa-triangle-exclamation"></i> ¡Error!</strong> El titulo o cedula ingresado ya esta registrado.
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-success" id="btn_agregar_estudio_docente">Registrar</button>
							<button type="submit" class="btn btn-success" id="btn_actualizar_estudio_docente">Actualizar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
    </main> 
    <script>
        $(document).ready(function(){
            Pagination_docente(1);
            Pagination_select_docente(1);
			//Pagination_divisiones_select(1);
            $(function () {
				$('#exp_doc').selectpicker();
			});
        });
    </script>
</body>
</html>