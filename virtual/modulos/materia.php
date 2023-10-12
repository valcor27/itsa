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
			<input type="hidden" id="url_paginar" name="url_paginar" value="php/materia/paginacion.php">
			<input type="hidden" id="url_modificar" name="url_modificar" value="php/materia/modificar.php">
            <input type="hidden" id="url_buscar_division" name="url_buscar_division" value="php/division/buscar_division.php">
            <div class="wrraper">
				<div class="row">
					<div class="col-sm-12">
						<div class="card my-4">
							<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
								<div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 ">
									<div class="row justify-content-center">
										<div class="col-auto align-items-center">
											<h6 class="text-white ps-3 title-pagina"><i class="fa-solid fa-laptop-file"></i> módulo de materias</h6>
										</div>
									</div>
									<div class="row justify-content-between">
										<div class="col-auto">
											<form id="buscar" name="buscar" onsubmit="return Pagination_materia(1);">
												<div class="input-group mb-3 ps-3">
													<input type="text" name="busqueda" id="busqueda" class="form-control" placeholder="Buscar Materia">
													<button class="btn btn-outline-light" type="submit" id="button-addon2">Buscar</button>
												</div>  
											</form>
										</div>
										<div class="col-auto">
											<div class="d-flex justify-content-end ps-3 me-5">
												<button type="button" class="btn btn-outline-light" onclick="Modal_configuracion_materia();">
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
		<div class="modal fade" id="modal_materia" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_materia_label" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title" id="modal_materia_label"></h6>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form action="php/materia/registro.php" id="form_materia" name="form_materia" onsubmit="return Registrar_materia();">
						<input class="form-control" type="hidden" name="proceso_materia" id="proceso_materia" required>
                        <input class="form-control" type="hidden" name="id_materia" id="id_materia" value="0" required>
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
									<label for="nombre" class="form-label">Nombre Materia</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-laptop-file"></i></span>
										<input type="text" id="nombre" name="nombre" maxlength="49" class="form-control" placeholder="Nombre Materia" aria-label="Nombre Materia" aria-describedby="basic-addon1" required="">
									</div>
								</div>
                                <div class="col-md-10" id="alert_error">
									<div class="alert alert-danger" role="alert">
										<strong><i class="fa-solid fa-triangle-exclamation"></i> ¡Error!</strong> El nombre ingresado ya esta dado de alta para otra materia en la misma división.
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-success" id="btn_agregar_materia">Registrar</button>
							<button type="submit" class="btn btn-success" id="btn_actualizar_materia">Actualizar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
    </main> 
    <script>
        $(document).ready(function(){
            Pagination_materia(1);
			Pagination_divisiones_select(1);
        });
    </script>
</body>
</html>