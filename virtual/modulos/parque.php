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
			<input type="hidden" id="url_paginar" name="url_paginar" value="php/parque/paginacion.php">
			<input type="hidden" id="url_modificar" name="url_modificar" value="php/parque/modificar.php">
         	<div class="wrraper">
				<div class="row">
					<div class="col-sm-12">
						<div class="card my-4">
							<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
								<div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 ">
									<div class="row justify-content-center ">
										<div class="col-auto align-items-center">
											<h6 class="text-white ps-3 title-pagina"><i class="fa-solid fa-car"></i> módulo de parque vehicular</h6>
										</div>
									</div>
									<div class="row justify-content-between">
										<div class="col-auto">
											<form id="buscar" name="buscar" onsubmit="return Pagination_vehiculo(1);">
												<div class="input-group mb-3 ps-3">
													<input type="text" name="busqueda" id="busqueda" class="form-control" placeholder="Buscar Vehiculo">
													<button class="btn btn-outline-light" type="submit" id="button-addon2">Buscar</button>
												</div>  
											</form>
										</div>
										<div class="col-auto">
											<div class="d-flex justify-content-end ps-3 me-5">
												<button type="button" class="btn btn-outline-light" onclick="Modal_configuracion_vehiculo();">
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
		<div class="modal fade" id="modal_vehiculo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_vehiculo_label" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title" id="modal_vehiculo_label"></h6>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form action="php/parque/registro.php" id="form_vehiculo" name="form_vehiculo" onsubmit="return Registrar_vehiculo();">
						<input class="form-control" type="hidden" name="proceso_vehiculo" id="proceso_vehiculo" required>
                        <input class="form-control" type="hidden" name="id_vehiculo" id="id_vehiculo" value="0" required>
						<div class="modal-body">
							<div class="row justify-content-center">
								<div class="col-md-5">
									<label for="placa" class="form-label">Placas</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-address-card"></i></span>
										<input type="text" id="placa" name="placa" maxlength="20" class="form-control" placeholder="Placas" aria-label="Placas" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-7">
									<label for="noserie" class="form-label">No. Serie</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-address-card"></i></span>
										<input type="text" id="noserie" name="noserie" maxlength="99" class="form-control" placeholder="No. Serie" aria-label="No. Serie" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-6">
									<label for="kminicial" class="form-label">Km Inicial</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-gauge-high"></i></span>
										<input type="text" id="kminicial" name="kminicial" maxlength="11" class="form-control solonumeros" placeholder="Km Inicial" aria-label="Km Inicial" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-6">
									<label for="tipo" class="form-label">Tipo</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-car-side"></i></span>
										<input type="text" id="tipo" name="tipo" maxlength="99" class="form-control" placeholder="Tipo" aria-label="Tipo" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-4">
									<label for="cilindro" class="form-label">Cilindros</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-arrow-up-9-1"></i></span>
										<input type="text" id="cilindro" name="cilindro" maxlength="3" class="form-control solonumeros" placeholder="Cilindros" aria-label="Cilindros" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-4">
									<label for="kmporlitro" class="form-label">Km/Litro</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-gas-pump"></i></span>
										<input type="text" id="kmporlitro" name="kmporlitro" maxlength="4" class="form-control solonumeros" placeholder="Km/Litro" aria-label="Km/Litro" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-4">
									<label for="modelo" class="form-label">Modelo</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-calendar-check"></i></span>
										<input type="text" id="modelo" name="modelo" maxlength="5" class="form-control solonumeros" placeholder="Modelo" aria-label="Modelo" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-4">
									<label for="color" class="form-label">Color</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-brush"></i></span>
										<input type="text" id="color" name="color" maxlength="30" class="form-control" placeholder="Color" aria-label="Color" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-8">
									<label for="marca" class="form-label">Marca</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-copyright"></i></span>
										<input type="text" id="marca" name="marca" maxlength="99" class="form-control" placeholder="Marca" aria-label="Marca" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-8">
									<label for="submarca" class="form-label">Sub-Marca</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-copyright"></i></span>
										<input type="text" id="submarca" name="submarca" maxlength="99" class="form-control" placeholder="Sub-Marca" aria-label="Sub-Marca" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-10" id="alert_error">
									<div class="alert alert-danger" role="alert">
										<strong><i class="fa-solid fa-triangle-exclamation"></i> ¡Error!</strong> El vehiculo que trata de ingresar, ya esta dado de alta.
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-success" id="btn_agregar_vehiculo">Registrar</button>
							<button type="submit" class="btn btn-success" id="btn_actualizar_vehiculo">Actualizar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
    </main> 
    <script>
        $(document).ready(function(){
			Pagination_vehiculo(1);
			Solo_numeros();
        });
    </script>
</body>
</html>