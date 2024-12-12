<?php require("../php/sesion/logueo.php") ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONTROL DE GESTIÓN</title>
</head>
<body>
    <main id="contenido_pagina">
		<div class="container-fluid mt-5">
			<input type="hidden" id="url_paginar" name="url_paginar" value="php/pagos/paginacion.php">
			<input type="hidden" id="url_descargar_plantilla_pagos" name="url_descargar_plantilla_pagos" value="php/pagos/descargar_plantilla_pagos.php">
			<input type="hidden" id="url_registrar_pe" name="url_registrar_pe" value="php/detalle_pagos/registro.php">
			<input type="hidden" id="url_eliminar_pe" name="url_eliminar_pe" value="php/detalle_pagos/eliminar_detalle_pe.php">
			<div class="wrraper">
				<div class="row">
					<div class="col-sm-12">
						<div class="card my-4">
							<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
								<div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 ">
									<div class="row justify-content-center">
										<div class="col-auto align-items-center">
											<h6 class="text-white ps-3 title-pagina"><i class="fa-solid fa-money-check-dollar"></i> módulo de Pagos</h6>
										</div>
									</div>
									<div class="row justify-content-between">
										<div class="col-auto">
											<form id="buscar" name="buscar" onsubmit="return Pagination_pagos(1);">
												<div class="input-group mb-3 ps-3">
													<input type="text" name="busqueda" id="busqueda" class="form-control" placeholder="Buscar Pago">
													<button class="btn btn-outline-light" type="submit" id="button-addon2">Buscar</button>
												</div>  
											</form>
										</div>
										<div class="col-auto">
											<div class="d-flex justify-content-end ps-3 me-5">
												<button type="button" class="btn btn-outline-light" onclick="Modal_configuracion_pago();">
													<i class="fa-solid fa-plus"></i>
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="container-fluid">
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
		<div class="modal fade" id="modal_pagos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_pagos_label" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title" id="modal_pagos_label"></h6>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form action="php/pagos/registro.php" method="POST" id="form_pagos" name="form_pagos" onsubmit="return Registrar_pagos();" enctype="multipart/form-data">
						<div class="modal-body">
							<input class="form-control" type="hidden" name="proceso_pagos" id="proceso_pagos" required>
							<input class="form-control" type="hidden" name="id_pagos" id="id_pagos" value="0" required>
							<div class="col-md-12">
								<label for="archivo_pagos" class="form-label">Seleccione o arrastre su documento aqui (Solo archivos .XLSX)</label>
								<div class="input-group mb-3">
									<span class="input-group-text"><i class="fa-regular fa-file-excel"></i></span>
									<input class="form-control" type="file" id="archivo_pagos" name="archivo_pagos">
								</div>
							</div>
							<div class="col-md-12 mb-3">
								<div class="progress" id="progress-container" style="display:none;">
									<div class="progress-bar progress-bar-striped progress-bar-animated bg-success" id="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
										<span id="progress-percent">0%</span><!--texto que se muestra dentro de la barra de loading-->
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<a href="#" class="btn btn-outline-success" onclick="Descargar_plantilla_pagos();"><i class="fa-solid fa-file-arrow-down"></i> Descargar Plantilla</a>
							</div>
							</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-success" id="btn_agregar_pagos">Registrar</button>
							<button type="submit" class="btn btn-success" id="btn_actualizar_pagos">Actualizar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
    </main>
	<script>
		$(document).ready(function(){
			Pagination_pagos(1);
		});
	</script>
</body>
</html>