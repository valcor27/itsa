<?php require("../php/sesion/logueo.php") ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> CONTROL DE GESTIÓN</title>
</head>
<body>
<input type="hidden" id="url_paginar" name="url_paginar" value="php/dias_inhabiles/paginacion.php">
<input type="hidden" id="url_modificar" name="url_modificar" value="php/dias_inhabiles/modificar.php">
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
											<h6 class="text-white ps-3 title-pagina"><i class="fa-solid fa-calendar-day"></i> módulo de días inhábiles</h6>
										</div>
									</div>
									<div class="row justify-content-between">
										<div class="col-auto">
											<form id="buscar" name="buscar" onsubmit="return Pagination_dia_inhabil(1);">
												<div class="input-group mb-3 ps-3">
													<input type="text" name="busqueda" id="busqueda" class="form-control" placeholder="Buscar Día Inhábil">
													<button class="btn btn-outline-light" type="submit" id="button-addon2">Buscar</button>
												</div>  
											</form>
										</div>
										<div class="col-auto">
											<div class="d-flex justify-content-end ps-3 me-5">
												<button type="button" class="btn btn-outline-light" onclick="Modal_configuracion_dia_inhabil();">
													<i class="fa-regular fa-calendar-plus"></i>
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
		<div class="modal fade" id="modal_dia_inhabil" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_dia_inhabil_label" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title" id="modal_dia_inhabil_label"></h6>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form  action="php/dias_inhabiles/registro.php" id="form_dia_inhabil" name="form_dia_inhabil" method="POST" onsubmit="return Registrar_dia_inhabil();">
						<input class="form-control" type="hidden" name="proceso_dia_inhabil" id="proceso_dia_inhabil" required>
						<input class="form-control" type="hidden" name="id_dia_inhabil" id="id_dia_inhabil" value="0" required>
						<div class="modal-body">
							<div class="row justify-content-center">
								<div class="col-md-12">
									<label for="fDia_i" class="form-label">Fecha</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-calendar-days"></i></span>
										<input type="text" id="fDia_i" name="fDia_i" class="form-control" placeholder="Fecha" aria-label="Fecha" aria-describedby="basic-addon1" required="" data-provide="datepicker">
									</div>
								</div>
								<div class="col-md-12">
									<label for="concepto_dia_i" class="form-label">Concepto</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-comments"></i></span>
										<textarea class="form-control" id="concepto_dia_i" name="concepto_dia_i" rows="2" placeholder="Concepto" maxlength="100" required></textarea>
									</div>
								</div>
								<div class="col-md-12" id="alert_error_dia_inhabil">
									<div class="alert alert-danger" role="alert">
										<strong><i class="fa-solid fa-triangle-exclamation"></i> ¡Error!</strong> Ya existe un registro con la fecha seleccionada.
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-success" id="btn_registrar_dia_i">Registrar</button>
                            <button type="submit" class="btn btn-success" id="btn_actualizar_dia_i">Actualizar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
    </main> 
	<script>
        $(document).ready(function(){
            Pagination_dia_inhabil(1);
			$(function () {
        		$("#fDia_i").datepicker({
            		language: 'es',
					format: 'dd-mm-yyyy',
					autoclose: 'true'
        		});
    		});
        });
    </script>
</body>
</html>