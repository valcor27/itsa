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
			<input type="hidden" id="url_paginar" name="url_paginar" value="php/chofer/paginacion.php">
			<input type="hidden" id="url_modificar" name="url_modificar" value="php/chofer/modificar.php">
			<input type="hidden" id="url_buscar_empleados" name="url_buscar_empleados" value="php/chofer/select_empleados.php">
         	<div class="wrraper">
				<div class="row">
					<div class="col-sm-12">
						<div class="card my-4">
							<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
								<div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 ">
									<div class="row justify-content-center ">
										<div class="col-auto align-items-center">
											<h6 class="text-white ps-3 title-pagina"><i class="fa-solid fa-user-tie"></i> módulo de choferes</h6>
										</div>
									</div>
									<div class="row justify-content-between">
										<div class="col-auto">
											<form id="buscar" name="buscar" onsubmit="return Pagination_chofer(1);">
												<div class="input-group mb-3 ps-3">
													<input type="text" name="busqueda" id="busqueda" class="form-control" placeholder="Buscar Chofer">
													<button class="btn btn-outline-light" type="submit" id="button-addon2">Buscar</button>
												</div>  
											</form>
										</div>
										<div class="col-auto">
											<div class="d-flex justify-content-end ps-3 me-5">
												<button type="button" class="btn btn-outline-light" onclick="Modal_configuracion_chofer();">
													<i class="fa-solid fa-plus"></i>
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
		<div class="modal fade" id="modal_chofer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_chofer_label" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title" id="modal_chofer_label"></h6>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form action="php/chofer/registro.php" id="form_chofer" name="form_chofer" onsubmit="return Registrar_chofer();">
						<input class="form-control" type="hidden" name="proceso_chofer" id="proceso_chofer" required>
                        <input class="form-control" type="hidden" name="id_chofer" id="id_chofer" value="0" required>
						<div class="modal-body">
							<div class="row justify-content-center">
								<div class="col-md-12">
									<label for="exp_emp_chofer" class="form-label">Empleado</label>
									<div class="input-group mb-3" id="chofer_empleado_chofer">
									</div>
								</div>
								<div class="col-md-12" id="alert_error">
									<div class="alert alert-danger" role="alert">
										<strong><i class="fa-solid fa-triangle-exclamation"></i> ¡Error!</strong> El empleado seleccionado, ya esta registrado como chofer.
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-success" id="btn_agregar_chofer">Registrar</button>
							<button type="submit" class="btn btn-success" id="btn_actualizar_chofer">Actualizar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
    </main> 
    <script>
        $(document).ready(function(){
			Pagination_chofer(1);
			Pagination_empleados_chofer(1);
			$(function () {
				$('.selectpicker').selectpicker();
			});
        });
    </script>
</body>
</html>