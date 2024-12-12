<?php require("../php/sesion/logueo.php") ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> CONTROL DE GESTIÓN</title>
</head>
<body>
<input type="hidden" id="url_paginar" name="url_paginar" value="php/licencia/paginacion.php">
<input type="hidden" id="url_modificar" name="url_modificar" value="php/licencia/modificar.php">
<input type="hidden" id="url_buscar_empleados" name="url_buscar_empleados" value="php/licencia/select_empleados.php">
<input type="hidden" id="url_buscar_info" name="url_buscar_info" value="php/licencia/buscar_info.php">
    <main id="contenido_pagina">
        <div class="container mt-5">
            <div class="wrraper">
				<div class="row">
					<div class="col-sm-12">
						<div class="card my-4">
							<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
								<div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 ">
									<div class="row justify-content-center">
										<div class="col-auto align-items-center">
											<h6 class="text-white ps-3 title-pagina"><i class="fa-regular fa-address-card"></i> módulo de licencias</h6>
										</div>
									</div>
									<div class="row justify-content-between">
										<div class="col-auto">
											<form id="buscar" name="buscar" onsubmit="return Pagination_licencia(1);">
												<div class="input-group mb-3 ps-3">
													<input type="text" name="busqueda" id="busqueda" class="form-control" placeholder="Buscar Licencia">
													<button class="btn btn-outline-light" type="submit" id="button-addon2">Buscar</button>
												</div>  
											</form>
										</div>
										<div class="col-auto">
											<div class="d-flex justify-content-end ps-3 me-5">
												<button type="button" class="btn btn-outline-light" onclick="Modal_configuracion_licencia();">
                                                    <i class="fa-solid fa-file-circle-plus"></i>
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
		<div class="modal fade" id="modal_licencia" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_licencia_label" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title" id="modal_licencia_label"></h6>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form  action="php/licencia/registro.php" id="form_licencia" name="form_licencia" method="POST" onsubmit="return Registrar_licencia();">
						<input class="form-control" type="hidden" name="proceso_licencia" id="proceso_licencia" required>
						<input class="form-control" type="hidden" name="id_licencia" id="id_licencia" value="0" required>
						<div class="modal-body">
							<div class="row justify-content-center">
								<div class="col-md-12">
									<label for="exp_emp_licencia" class="form-label">Empleado</label>
									<div class="input-group mb-3" id="licencia_empleado_licencia">
									</div>
								</div>
                                <div class="col-md-5">
									<label for="folio_l" class="form-label">Folio</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-ticket"></i></span>
										<input type="text" id="folio_l" name="folio_l" class="form-control" placeholder="Folio" aria-label="Folio" aria-describedby="basic-addon1" readonly>
									</div>
								</div>
                                <div class="col-md-7">
									<label for="concepto" class="form-label">Concepto</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-comment-dots"></i></span>
										<input type="text" id="concepto" name="concepto" class="form-control" placeholder="Concepto" aria-label="Concepto" aria-describedby="basic-addon1" required="">
									</div>
								</div>
                                <div class="col-md-6">
									<label for="fecha_ela_l" class="form-label">Fecha</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-calendar-days"></i></span>
										<input type="text" id="fecha_ela_l" name="fecha_ela_l" class="form-control" placeholder="Fecha" aria-label="Fecha" aria-describedby="basic-addon1" readonly>
									</div>
								</div>
                                <div class="col-md-6">
									<label for="hora_l" class="form-label">Hora</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-clock"></i></span>
										<input type="text" id="hora_l" name="hora_l" class="form-control" placeholder="Hora" aria-label="Hora" aria-describedby="basic-addon1" readonly>
									</div>
								</div>
								<div class="col-md-6">
									<label for="fInicio" class="form-label">Fecha Inicio</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-calendar-days"></i></span>
										<input type="text" id="fInicio" name="fInicio" class="form-control" placeholder="Fecha Inicio" aria-label="Fecha" aria-describedby="basic-addon1" required="" data-provide="datepicker">
									</div>
								</div>
								<div class="col-md-6">
									<label for="fFin" class="form-label">Fecha Fin</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-calendar-days"></i></span>
										<input type="text" id="fFin" name="fFin" class="form-control" placeholder="Fecha Fin" aria-label="Fecha" aria-describedby="basic-addon1" required="" data-provide="datepicker">
									</div>
								</div>
								<div class="col-md-11" id="alert_error">
									<div class="alert alert-danger" role="alert">
										<strong><i class="fa-solid fa-triangle-exclamation"></i> ¡Error!</strong> Ya existe una licencia para el empleado dentro del rango de fechas establecido.
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-success" id="btn_registrar_licencia">Registrar</button>
                            <button type="submit" class="btn btn-success" id="btn_actualizar_licencia">Actualizar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
    </main> 
	<script>
        $(document).ready(function(){
            Pagination_licencia(1);
			Pagination_empleados_licencia(1);
			$(function () {
        		$("#fInicio").datepicker({
            		language: 'es',
					format: 'dd-mm-yyyy',
					autoclose: 'true'
        		});
    		});
			$(function () {
        		$("#fFin").datepicker({
            		language: 'es',
					format: 'dd-mm-yyyy',
					autoclose: 'true'
        		});
    		});
			$(function () {
				$('.selectpicker').selectpicker();
			});
        });
    </script>
</body>
</html>