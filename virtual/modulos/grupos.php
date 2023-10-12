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
			<input type="hidden" id="url_paginar" name="url_paginar" value="php/grupos/paginacion.php">
			<input type="hidden" id="url_modificar" name="url_modificar" value="php/grupos/modificar.php">
			<input type="hidden" id="url_buscar_division" name="url_buscar_division" value="php/division/buscar_division.php">
            <div class="wrraper">
				<div class="row">
					<div class="col-sm-12">
						<div class="card my-4">
							<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
								<div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 ">
									<div class="row justify-content-center">
										<div class="col-auto align-items-center">
											<h6 class="text-white ps-3 title-pagina"><i class="fa-solid fa-users"></i> módulo de grupos</h6>
										</div>
									</div>
									<div class="row justify-content-between">
										<div class="col-auto">
											<form id="buscar" name="buscar" onsubmit="return Pagination_grupo(1);">
												<div class="input-group mb-3 ps-3">
													<input type="text" name="busqueda" id="busqueda" class="form-control" placeholder="Buscar Grupo">
													<button class="btn btn-outline-light" type="submit" id="button-addon2">Buscar</button>
												</div>  
											</form>
										</div>
										<div class="col-auto">
											<div class="d-flex justify-content-end ps-3 me-5">
												<button type="button" class="btn btn-outline-light" onclick="Modal_configuracion_grupo();">
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
		<div class="modal fade" id="modal_grupo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_grupo_label" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title" id="modal_grupo_label"></h6>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form action="php/grupos/registro.php" id="form_grupo" name="form_grupo" onsubmit="return Registrar_grupo();">
						<input class="form-control" type="hidden" name="proceso_grupo" id="proceso_grupo" required>
                        <input class="form-control" type="hidden" name="id_grupo" id="id_grupo" value="0" required>
						<div class="modal-body">
							<div class="row justify-content-center">
								<div class="col-md-12">
									<label for="division" class="form-label">División</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-address-book"></i></span>
										<select class="form-select" name="division" id="division" aria-label="Default select example" required=""> 
										</select>
									</div>
								</div>
								<div class="col-md-12">
									<label for="nombre" class="form-label">Nombre Grupo</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-building-columns"></i></span>
										<input type="text" id="nombre" name="nombre" maxlength="19" class="form-control" placeholder="Nombre Grupo" aria-label="Nombre Grupo" aria-describedby="basic-addon1" required="">
									</div>
								</div>
                                <div class="col-md-10" id="alert_error">
									<div class="alert alert-danger" role="alert">
										<strong><i class="fa-solid fa-triangle-exclamation"></i> ¡Error!</strong> El nombre ingresado ya esta dado de alta para otro grupo.
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-success" id="btn_agregar_grupo">Registrar</button>
							<button type="submit" class="btn btn-success" id="btn_actualizar_grupo">Actualizar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
    </main> 
    <script>
        $(document).ready(function(){
            Pagination_grupo(1);
			Pagination_divisiones_select(1);
        });
    </script>
</body>
</html>