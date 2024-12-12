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
        <!--<div class="container mt-5">
			<input type="hidden" id="url_paginar" name="url_paginar" value="php/comision/paginacion.php">
			<input type="hidden" id="url_modificar_dp" name="url_modificar_dp" value="php/comision/modificar_dp.php">
			<input type="hidden" id="url_buscar_empleados" name="url_buscar_empleados" value="php/comision/select_empleados_comision.php">
			<input type="hidden" id="url_info_empleado_comision" name="url_info_empleado_comision" value="php/comision/info_empleados.php">
			<input type="hidden" id="url_validacion_comision" name="url_validacion_comision" value="php/comision/validacion_comision.php">
			<input type="hidden" id="url_info_comision" name="url_info_comision" value="php/comision/info_comision.php">
			<input type="hidden" id="url_suma_total" name="url_suma_total" value="php/comision/suma_total.php">
			<input type="hidden" id="url_modificar_viaticos" name="url_modificar_viaticos" value="php/comision/modificar_viaticos.php"> 
        	<input type="hidden" id="url_buscar_vehiculo" name="url_buscar_vehiculo" value="php/comision/vehiculos_comision.php">
			<input type="hidden" id="url_datos_vehiculo" name="url_datos_vehiculo" value="php/comision/datos_vehiculo_comision.php">
			<input type="hidden" id="url_fecha_hora_pv" name="url_fecha_hora_pv" value="php/comision/fecha_hora_pv.php">
			<input type="hidden" id="url_modificar_vehiculo" name="url_modificar_vehiculo" value="php/comision/modificar_vehiculo.php">
			<div class="wrraper">
				<div class="row">
					<div class="col-sm-12">
						<div class="card my-4">
							<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
								<div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 ">
									<div class="row justify-content-center">
										<div class="col-auto align-items-center">
											<h6 class="text-white ps-3 title-pagina"><i class="fa-solid fa-file-invoice"></i> módulo de comisiones</h6>
										</div>
									</div>
									<div class="row justify-content-between">
										<div class="col-auto">
											<form id="buscar" name="buscar" onsubmit="return Pagination_comision(1);">
												<div class="input-group mb-3 ps-3">
													<input type="text" name="busqueda" id="busqueda" class="form-control" placeholder="Buscar Comisión">
													<button class="btn btn-outline-light" type="submit" id="button-addon2">Buscar</button>
												</div>  
											</form>
										</div>
										<div class="col-auto">
											<div class="d-flex justify-content-end ps-3 me-5">
												<button type="button" class="btn btn-outline-light" onclick="Modal_configuracion_comision_dp();">
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
		<div class="modal fade" id="modal_comision_dp" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_comision_dp_label" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title" id="modal_comision_dp_label"></h6>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form action="php/comision/registro_dp.php" id="form_comision_dp" name="form_comision_dp" onsubmit="return Registrar_comision_dp();">
						<input class="form-control" type="text" name="proceso_comision_dp" id="proceso_comision_dp" required>
                        <input class="form-control" type="text" name="id_comision_dp" id="id_comision_dp" value="0" required>
						<input class="form-control" type="text" name="id_plaza" id="id_plaza" value="0" required>
						<div class="modal-body">
							<div class="row justify-content-center">
								<div class="col-md-12">
									<label for="exp_emp_comision" class="form-label">Empleado</label>
									<div class="input-group mb-3" id="comision_empleado_comision"> multiple
									</div>
								</div>
								<div class="col-md-6">
									<label for="lugar" class="form-label">Lugar</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-map-location-dot"></i></span>
										<input type="text" id="lugar" name="lugar" class="form-control" placeholder="Lugar" aria-label="Lugar" aria-describedby="basic-addon1" readonly>
									</div>
								</div>
								<div class="col-md-6">
									<label for="fecha_comision" class="form-label">Fecha</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-calendar-day"></i></span>
										<input type="text" id="fecha_comision" name="fecha_comision" class="form-control" placeholder="Fecha" aria-label="Fecha" aria-describedby="basic-addon1" readonly>
									</div>
								</div>
								<div class="col-md-6">
									<label for="n_comi" class="form-label">Cantidad</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-hashtag"></i></span>
										<input type="text" id="n_comi" name="n_comi" class="form-control" placeholder="Cantidad" aria-label="Cantidad" aria-describedby="basic-addon1" readonly>
									</div>
								</div>
								<div class="col-md-6">
									<label for="folio_comision" class="form-label">Folio</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-ticket"></i></span>
										<input type="text" id="folio_comision" name="folio_comision" class="form-control" placeholder="Folio" aria-label="Folio" aria-describedby="basic-addon1" readonly>
									</div>
								</div>
								<div class="col-md-12">
									<label for="cargo" class="form-label">Cargo</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-address-book"></i></span>
										<textarea class="form-control" id="cargo" name="cargo" rows="2" placeholder="Cargo" maxlength="50" readonly></textarea>
									</div>
								</div>
								<div class="col-md-6">
									<label for="fInicio" class="form-label">Fecha Inicio</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-calendar-days"></i></span>
										<input type="text" id="fInicio" name="fInicio" class="form-control" placeholder="Fecha Inicio" aria-label="Fecha" aria-describedby="basic-addon1" required="" data-provide="datepicker" onchange="return Pagination_validar_comision();">
									</div>
								</div>
								<div class="col-md-6">
									<label for="fFin" class="form-label">Fecha Fin</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-calendar-days"></i></span>
										<input type="text" id="fFin" name="fFin" class="form-control" placeholder="Fecha Fin" aria-label="Fecha" aria-describedby="basic-addon1" required="" data-provide="datepicker" onchange="return Pagination_validar_comision();">
									</div>
								</div>
								<div class="col-md-6">
									<label for="hora_incio" class="form-label">Hora Inicio</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-clock"></i></span>
										<input type="time" id="hora_incio" name="hora_incio" class="form-control" placeholder="Hora Inicio" aria-label="Hora Inicio" aria-describedby="basic-addon1" required onchange="return Pagination_validar_comision();">
									</div>
								</div>
								<div class="col-md-6">
									<label for="hora_fin" class="form-label">Hora Fin</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-clock"></i></span>
										<input type="time" id="hora_fin" name="hora_fin" class="form-control" placeholder="Hora Fin" aria-label="Hora Fin" aria-describedby="basic-addon1" required onchange="return Pagination_validar_comision();">
									</div>
								</div>
								<div class="col-md-12">
									<label for="finalidad" class="form-label">Finalidad</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-business-time"></i></span>
										<textarea class="form-control" id="finalidad" name="finalidad" rows="2" placeholder="Finalidad" maxlength="100" required></textarea>
									</div>
								</div>
								<div class="col-md-6">
									<label for="duracion" class="form-label">Duración Comisión</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-clock"></i></span>
										<input type="text" id="duracion" name="duracion" class="form-control" placeholder="Duración Comisión" aria-label="Duración Comisión" aria-describedby="basic-addon1" readonly>
									</div>
								</div>
								<div class="col-md-6">
									<label for="pais" class="form-label">País</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-earth-americas"></i></span>
										<input type="text" id="pais" name="pais" class="form-control" placeholder="País" aria-label="País" aria-describedby="basic-addon1" required>
									</div>
								</div>
								<div class="col-md-6">
									<label for="estado" class="form-label">Estado</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-earth-americas"></i></span>
										<input type="text" id="estado" name="estado" class="form-control" placeholder="Estado" aria-label="Estado" aria-describedby="basic-addon1" required>
									</div>
								</div>
								<div class="col-md-6">
									<label for="municipio" class="form-label">Municipio</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-earth-americas"></i></span>
										<input type="text" id="municipio" name="municipio" class="form-control" placeholder="Municipio" aria-label="Municipio" aria-describedby="basic-addon1" required>
									</div>
								</div>
								<div class="col-md-12">
									<label for="lugar_comision" class="form-label">Lugar de la Comisión</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-map-location-dot"></i></span>
										<textarea class="form-control" id="lugar_comision" name="lugar_comision" rows="2" placeholder="Lugar de la Comisión" maxlength="199" required></textarea>
									</div>
								</div>
								<div class="col-md-11" id="alert_error">
									<div class="alert alert-danger" role="alert">
										<strong><i class="fa-solid fa-triangle-exclamation"></i> ¡Error!</strong> Un empleado ya cuenta con una comisión en el horario y fecha establecidos.
									</div>
								</div>
								<div class="col-md-11" id="alert_error_2">
									<div class="alert alert-danger" role="alert">
										<strong><i class="fa-solid fa-triangle-exclamation"></i> ¡Error!</strong> Un empleado cuenta con un "movimiento de personal" y no puede ser comisionado en el rango de fecha seleccionado.
									</div>
								</div>
								<div class="col-md-11" id="alert_error_3">
									<div class="alert alert-danger" role="alert">
										<strong><i class="fa-solid fa-triangle-exclamation"></i> ¡Error!</strong> Un empleado cuenta con una "licencia" y no puede ser comisionado en el rango de fecha seleccionado.
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-success" id="btn_agregar_comision_dp">Registrar</button>
							<button type="submit" class="btn btn-success" id="btn_actualizar_comision_dp">Actualizar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modal_comision_rf" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_comision_rf_label" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title" id="modal_comision_rf_label"></h6>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form action="php/comision/registro_rf.php" id="form_comision_rf" name="form_comision_rf" onsubmit="return Registrar_comision_rf();">
						<input class="form-control" type="hidden" name="proceso_comision_rf" id="proceso_comision_rf" required>
                        <input class="form-control" type="hidden" name="id_comision_rf" id="id_comision_rf" value="0" required>
						<input class="form-control" type="hidden" name="comision_id_comision" id="comision_id_comision" value="0" required>
						<div class="modal-body">
							<div class="row justify-content-center">
								<div class="col-md-12">
									<label for="viatico" class="form-label">Viatico</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-dollar-sign"></i></span>
										<input type="text" id="viatico" name="viatico" value="00.00" class="form-control solonumeros" placeholder="Viatico" aria-label="Viatico" aria-describedby="basic-addon1" required onchange="return Suma_viaticos();">
									</div>
								</div>
								<div class="col-md-12">
									<label for="combustible" class="form-label">Combustible</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-dollar-sign"></i></span>
										<input type="text" id="combustible" name="combustible" value="00.00" class="form-control solonumeros" placeholder="Combustible" aria-label="Combustible" aria-describedby="basic-addon1" required onchange="return Suma_viaticos();">
									</div>
								</div>
								<div class="col-md-12">
									<label for="casetas" class="form-label">Casetas</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-dollar-sign"></i></span>
										<input type="text" id="casetas" name="casetas" value="00.00" class="form-control solonumeros" placeholder="Casetas" aria-label="Casetas" aria-describedby="basic-addon1" required onchange="return Suma_viaticos();">
									</div>
								</div>
								<div class="col-md-12">
									<label for="otros" class="form-label">Otros</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-dollar-sign"></i></span>
										<input type="text" id="otros" name="otros" value="00.00" class="form-control solonumeros" placeholder="Otros" aria-label="Otros" aria-describedby="basic-addon1" required onchange="return Suma_viaticos();">
									</div>
								</div>
								<div class="col-md-12 input-especificar" style="display: none;" id="input_especificar_rf">
									<label for="especificar" class="form-label">Especificar</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-comment-dots"></i></span>
										<input type="text" id="especificar" name="especificar" class="form-control" placeholder="Especificar" aria-label="Especificar" aria-describedby="basic-addon1" disabled="">
									</div>
								</div>
								<div class="col-md-12">
									<label for="total" class="form-label">Total</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-dollar-sign"></i></span>
										<input type="text" id="total" name="total" value="00.00" class="form-control" placeholder="Total" aria-label="Total" aria-describedby="basic-addon1" required readonly>
									</div>
								</div>
								<div class="col-md-11" id="alert_error_rf">
									<div class="alert alert-danger" role="alert">
										<strong><i class="fa-solid fa-triangle-exclamation"></i> ¡Error!</strong> Actualice la pagina, porfavor.
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-success" id="btn_agregar_comision_rf">Registrar</button>
							<button type="submit" class="btn btn-success" id="btn_actualizar_comision_rf">Actualizar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modal_comision_pv" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_comision_pv_label" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title" id="modal_comision_pv_label"></h6>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form action="php/comision/registro_pv.php" id="form_comision_pv" name="form_comision_pv" onsubmit="return Registrar_comision_pv();">
						<input class="form-control" type="hidden" name="proceso_comision_pv" id="proceso_comision_pv" required>
                        <input class="form-control" type="hidden" name="id_comision_pv" id="id_comision_pv" value="0" required>
						<input class="form-control" type="hidden" name="comision_id_comision_pv" id="comision_id_comision_pv" value="0" required>
						<input class="form-control" type="hidden" name="f_ini_pv" id="f_ini_pv" value="0" required>
						<input class="form-control" type="hidden" name="f_fin_pv" id="f_fin_pv" value="0" required>
						<input class="form-control" type="hidden" name="h_ini_pv" id="h_ini_pv" value="0" required>
						<input class="form-control" type="hidden" name="h_fin_pv" id="h_fin_pv" value="0" required>
						<div class="modal-body">
							<div class="row justify-content-center">
								<div class="col-md-12">
									<label for="tipo_vehiculo" class="form-label">Tipo Vehiculo</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-car-on"></i></span>
										<select class="form-select" name="tipo_vehiculo" id="tipo_vehiculo" aria-label="Default select example" onchange="return Pagination_tipo_vehiculo();" required>	
											<option selected disabled>Selecciona</option> 
											<option value="1">Particular</option>
											<option value="2">Oficial</option>
											<option value="3">Otro</option>
										</select>
									</div>
								</div>
								<div class="col-md-12" style="display: none;" id="input_especificar_pv">
									<label for="especificar_vehiculo" class="form-label">Especificar</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-comment-dots"></i></span>
										<input type="text" id="especificar_vehiculo" name="especificar_vehiculo" class="form-control" placeholder="Especificar" aria-label="Especificar" aria-describedby="basic-addon1" disabled="">
									</div>
								</div>
								<div class="col-md-12" style="display: none;" id="select_id_vehiculo">
									<label for="vehiculo_comision" class="form-label">Vehiculo</label>
									<div class="input-group mb-3" id="vehiculo_id_vehiculo"> 
									</div>
								</div>
								<div class="col-md-6" style="display: none;" id="input_placas">
									<label for="placas" class="form-label">Placas</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-barcode"></i></span>
										<input type="text" id="placas" name="placas" class="form-control" placeholder="Placas" aria-label="Placas" aria-describedby="basic-addon1" readonly>
									</div>
								</div>
								<div class="col-md-6" style="display: none;" id="input_km_inicial">
									<label for="km_inicial" class="form-label">KM Inicial</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-route"></i></span>
										<input type="text" id="km_inicial" name="km_inicial" class="form-control" placeholder="KM Inicial" aria-label="KM Inicial" aria-describedby="basic-addon1" readonly>
									</div>
								</div>
								<div class="col-md-11" id="alert_error_pv">
									<div class="alert alert-danger" role="alert">
										<strong><i class="fa-solid fa-triangle-exclamation"></i> ¡Error!</strong> El vehiculo seleccionado, cuenta con una comision para la fecha y hora establecida de la comision seleccionada.
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-success" id="btn_agregar_comision_pv">Registrar</button>
							<button type="submit" class="btn btn-success" id="btn_actualizar_comision_pv">Actualizar</button>
						</div>
					</form>
				</div>
			</div>
		</div>--> 
		<div id="mantenimiento" class="pt-5 pb-5 mt-5">
			<div class="container maintenance-container">
				<div class="maintenance-box">
					<div class="maintenance-image">
						<i class="fas fa-cog gear-icon"></i>
					</div>
					<h1>Estamos trabajando en ello</h1>
					<p>Disculpe las molestias, volveremos pronto.</p>
					<a href="index.php" class="btn btn-danger btn-lg">Volver al inicio</a>
				</div>
			</div>
	   </div>
    </main> 
    <script>		
        $(document).ready(function(){
			Pagination_comision(1);
			Pagination_empleados_comision(1);
			Pagination_vehiculo_comision(1);
			Solo_numeros();
			$(function () {
        		$("#fInicio").datepicker({
            		language: 'es',
					format: 'dd-mm-yyyy',
					autoclose: 'true',
					//startDate: new Date()
        		});
    		});
			$(function () {
        		$("#fFin").datepicker({
            		language: 'es',
					format: 'dd-mm-yyyy',
					autoclose: 'true',
					//startDate: new Date()
        		});
    		});
			$(function () {
				$('.selectpicker').selectpicker();
			});
        });
    </script>
</body>
</html>