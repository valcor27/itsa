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
			<input type="hidden" id="url_paginar" name="url_paginar" value="php/salones/paginacion.php">
			<input type="hidden" id="url_modificar" name="url_modificar" value="php/salones/modificar.php">
			<input type="hidden" id="url_buscar_edificio" name="url_buscar_edificio" value="php/edificios/buscar_edificio.php">
            <div class="wrraper">
				<div class="row">
					<div class="col-sm-12">
						<div class="card my-4">
							<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
								<div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 ">
									<div class="row justify-content-center">
										<div class="col-auto align-items-center">
											<h6 class="text-white ps-3 title-pagina"><i class="fa-solid fa-building-columns"></i> módulo de salones</h6>
										</div>
									</div>
									<div class="row justify-content-between">
										<div class="col-auto">
											<form id="buscar" name="buscar" onsubmit="return Pagination_salon(1);">
												<div class="input-group mb-3 ps-3">
													<input type="text" name="busqueda" id="busqueda" class="form-control" placeholder="Buscar Salón">
													<button class="btn btn-outline-light" type="submit" id="button-addon2">Buscar</button>
												</div>  
											</form>
										</div>
										<div class="col-auto">
											<div class="d-flex justify-content-end ps-3 me-5">
												<button type="button" class="btn btn-outline-light" onclick="Modal_configuracion_salon();">
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
		<div class="modal fade" id="modal_salon" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_salon_label" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title" id="modal_salon_label"></h6>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form action="php/salones/registro.php" id="form_salon" name="form_salon" onsubmit="return Registrar_salon();">
						<input class="form-control" type="hidden" name="proceso_salon" id="proceso_salon" required>
                        <input class="form-control" type="hidden" name="id_salon" id="id_salon" value="0" required>
						<div class="modal-body">
							<div class="row justify-content-center">
								<div class="col-md-5">
									<label for="edificio" class="form-label">Edificio</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-building"></i></span>
										<select class="form-select" name="edificio" id="edificio" aria-label="Default select example" required=""> 
										</select>
									</div>
								</div>
								<div class="col-md-7">
									<label for="nombre" class="form-label">Nombre Salón</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-building-columns"></i></span>
										<input type="text" id="nombre" name="nombre" maxlength="19" class="form-control" placeholder="Nombre Salón" aria-label="Nombre Salón" aria-describedby="basic-addon1" required="">
									</div>
								</div>
                                <div class="col-md-10" id="alert_error">
									<div class="alert alert-danger" role="alert">
										<strong><i class="fa-solid fa-triangle-exclamation"></i> ¡Error!</strong> El nombre ingresado ya esta dado de alta para otro salón.
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-success" id="btn_agregar_salon">Registrar</button>
							<button type="submit" class="btn btn-success" id="btn_actualizar_salon">Actualizar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
    </main> 
    <script>
        $(document).ready(function(){
            Pagination_salon(1);
			Pagination_buscar_edificio(1);
        });
    </script>
</body>
</html>