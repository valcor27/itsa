<?php require("../php/sesion/logueo.php") ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> CONTROL DE GESTIÓN</title>
</head>
<body>
<input type="hidden" id="url_paginar" name="url_paginar" value="php/incidencia/paginacion.php">
<input type="hidden" id="url_modificar" name="url_modificar" value="php/incidencia/modificar.php">
<input type="hidden" id="url_buscar_empleados" name="url_buscar_empleados" value="php/incidencia/select_empleados.php">
<input type="hidden" id="url_buscar_claves_movimiento" name="url_buscar_claves_movimiento" value="php/incidencia/select_claves_movimientos.php">
<input type="hidden" id="url_buscar_info" name="url_buscar_info" value="php/incidencia/buscar_info.php">
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
											<h6 class="text-white ps-3 title-pagina"><i class="fa-solid fa-school-circle-exclamation"></i> módulo de movimiento de personal</h6>
										</div>
									</div>
									<div class="row justify-content-between">
										<div class="col-auto">
											<form id="buscar" name="buscar" onsubmit="return Pagination_incidencia(1);">
												<div class="input-group mb-3 ps-3">
													<input type="text" name="busqueda" id="busqueda" class="form-control" placeholder="Buscar Movimiento de Personal">
													<button class="btn btn-outline-light" type="submit" id="button-addon2">Buscar</button>
												</div>  
											</form>
										</div>
										<div class="col-auto">
											<div class="d-flex justify-content-end ps-3 me-5">
												<button type="button" class="btn btn-outline-light" onclick="Modal_configuracion_incidencia();">
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
		<div class="modal fade" id="modal_incidencia" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_incidencia_label" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title" id="modal_incidencia_label"></h6>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form  action="php/incidencia/registro.php" id="form_incidencia" name="form_incidencia" method="POST" onsubmit="return Registrar_incidencia();">
						<input class="form-control" type="hidden" name="proceso_incidencia" id="proceso_incidencia" required>
						<input class="form-control" type="hidden" name="id_incidencia" id="id_incidencia" value="0" required>
						<div class="modal-body">
							<div class="row justify-content-center">
								<div class="col-md-12">
									<label for="exp_emp_incidencia" class="form-label">Empleado</label>
									<div class="input-group mb-3" id="incidencia_empleado_incidencia">
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
								<div class="col-md-6">
									<label for="incidencia_folio" class="form-label">Folio</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-ticket"></i></span>
										<input class="form-control" type="text" name="incidencia_folio" id="incidencia_folio" value="0" readonly="">
									</div>
								</div>
								<div class="col-md-6">
									<label for="incidencia_hora" class="form-label">Hora</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-clock"></i></span>
										<input class="form-control" type="text" name="incidencia_hora" id="incidencia_hora" value="0" readonly="">
									</div>
								</div>
								<div class="col-md-6">
									<label for="fElaboracion" class="form-label">Fecha Elaboración</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-calendar-days"></i></span>
										<input type="text" id="fElaboracion" name="fElaboracion" class="form-control" placeholder="Fecha Elaboración" aria-label="Fecha" aria-describedby="basic-addon1" readonly="">
									</div>
								</div>
								<div class="col-md-6">
									<label for="id_clave_mov" class="form-label">Movimientos</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-boxes-packing"></i></span>
										<select class="form-select" name="id_clave_mov" id="id_clave_mov" required=""></select>
									</div>
								</div>
								<div class="col-md-9">
									<label for="observacion" class="form-label">Observaciones</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-comments"></i></span>
										<textarea class="form-control" id="observacion" name="observacion" rows="2" placeholder="Observaciones" maxlength="200"></textarea>
									</div>
								</div>
								<div class="col-md-9" id="alert_error_incidencia">
									<div class="alert alert-danger" role="alert">
										<strong><i class="fa-solid fa-triangle-exclamation"></i> ¡Error!</strong> Ya existe una incidencia para el empleado con las mismas fechas.
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-success" id="btn_registrar_incidencia">Registrar</button>
                            <button type="submit" class="btn btn-success" id="btn_actualizar_incidencia">Actualizar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
    </main> 
	<script>
        $(document).ready(function(){
            Pagination_incidencia(1);
			Pagination_select_empleados(1);
			Pagination_select_claves_movimiento(1);
			//Pagination_info_incidencia(1);
			$(function () {
        		$("#fInicio").datepicker({
            		language: 'es',
					format: 'dd-mm-yyyy',
					autoclose: true
        		});
    		});
			$(function () {
        		$("#fFin").datepicker({
            		language: 'es',
					format: 'dd-mm-yyyy',
					autoclose: true
        		});
    		});
            /*$(function () {
        		$("#fElaboracion").datepicker({
            		language: 'es',
					format: 'dd-mm-yyyy'
        		});
    		});*/
			$(function () {
				$('.selectpicker').selectpicker();
			});
        });
    </script>
</body>
</html>