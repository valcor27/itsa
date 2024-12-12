<?php 
	require("../php/sesion/logueo.php");
	/*if($id_software_sesion == '191817' && $nivel_sesion == '1'){
		$input = '
		<div class="input-group mb-3">
			<span class="input-group-text"><i class="fa-solid fa-route"></i></span>
			<input type="text" id="km_inicial" name="km_inicial" class="form-control solonumeros" placeholder="KM Inicial" aria-label="KM Inicial" aria-describedby="basic-addon1">
		</div>';
	}else{
		$input = '
		<div class="input-group mb-3">
			<span class="input-group-text"><i class="fa-solid fa-route"></i></span>
			<input type="text" id="km_inicial" name="km_inicial" class="form-control solonumeros" placeholder="KM Inicial" aria-label="KM Inicial" aria-describedby="basic-addon1" readonly>
		</div>';
	}*/
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> CONTROL DE GESTIÓN</title>
</head>
<body>
<input type="hidden" id="url_paginar" name="url_paginar" value="php/compacto_comision/paginacion.php">
<input type="hidden" id="url_modificar" name="url_modificar" value="php/compacto_comision/modificar.php">
<input type="hidden" id="url_buscar_comisiones" name="url_buscar_comisiones" value="php/compacto_comision/buscar_comisiones.php">
<input type="hidden" id="url_gasolina_comision" name="url_gasolina_comision" value="php/compacto_comision/buscar_gasolina.php">
<input type="hidden" id="url_departamentos_comision" name="url_departamentos_comision" value="php/compacto_comision/buscar_departamentos.php">
<input type="hidden" id="url_validar_comision" name="url_validar_comision" value="php/compacto_comision/validar_comision.php">
<input type="hidden" id="url_suma_kilometros" name="url_suma_kilometros" value="php/compacto_comision/suma_kilometros.php">
    <main id="contenido_pagina">
        <!--<div class="container mt-5">
            <div class="wrraper">
				<div class="row">
					<div class="col-sm-12">
						<div class="card my-4">
							<div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
								<div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 ">
									<div class="row justify-content-center">
										<div class="col-auto align-items-center">
											<h6 class="text-white ps-3 title-pagina"><i class="fa-solid fa-folder-tree"></i> módulo de compactación de comisiones</h6>
										</div>
									</div>
									<div class="row justify-content-between">
										<div class="col-auto">
											<form id="buscar" name="buscar" onsubmit="return Pagination_compacto_comision(1);">
												<div class="input-group mb-3 ps-3">
													<input type="text" name="busqueda" id="busqueda" class="form-control" placeholder="Buscar Compacto">
													<button class="btn btn-outline-light" type="submit" id="button-addon2">Buscar</button>
												</div>  
											</form>
										</div>
										<div class="col-auto">
											<div class="d-flex justify-content-end ps-3 me-5">
												<button type="button" class="btn btn-outline-light" onclick="Modal_configuracion_compacto_comision();">
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
		<div class="modal fade" id="modal_compacto_comision" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_compacto_comision_label" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title" id="modal_compacto_comision_label"></h6>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form  action="php/compacto_comision/registro.php" id="form_compacto_comision" name="form_compacto_comision" method="POST" onsubmit="return Registrar_compacto_comision();">
						<input class="form-control" type="text" name="proceso" id="proceso" required>
						<input class="form-control" type="text" name="id" id="id" value="0" required>
						<input class="form-control" type="text" name="id_vehiculo" id="id_vehiculo" value="0" required>
						<div class="modal-body">
							<div class="row justify-content-center">
								<div class="col-md-12">
									<div class="alert alert-info" id="alert_info_gas" role="alert">
										<strong><i class="fa-solid fa-circle-info"></i></strong> Verifique que el precio del combustible este actualizado.
									</div>
								</div>
                                <div class="col-md-12">
									<label for="id_comisiones" class="form-label">Folio Comisiones</label>
									<div class="input-group mb-3" id="comision_id_comision">
									</div>
								</div>
								<div class="col-md-12 inputs_vehiculo_comision">
									<label for="nombre_vehiculo" class="form-label">Vehiculo</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-car"></i></span>
										<input type="text" id="nombre_vehiculo" name="nombre_vehiculo" class="form-control" placeholder="Vehiculo" aria-label="Vehiculo" aria-describedby="basic-addon1" disabled>
									</div>
								</div>
								<div class="col-md-6 inputs_vehiculo_comision" >
									<label for="km_inicial" class="form-label">KM Inicial</label>
									<?php echo $input;?>
								</div>
								<div class="col-md-6 inputs_vehiculo_comision">
									<label for="km_final" class="form-label">KM Final</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-route"></i></span>
										<input type="text" id="km_final" name="km_final" class="form-control solonumeros" placeholder="KM Final" aria-label="KM Final" aria-describedby="basic-addon1" required onchange="return Obtener_km_recorridos();">
									</div>
								</div>
								<div class="col-md-6 inputs_vehiculo_comision">
									<label for="km_recorridos" class="form-label">KM Recorridos</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-route"></i></span>
										<input type="text" id="km_recorridos" name="km_recorridos" class="form-control solonumeros" placeholder="KM Recorridos" aria-label="KM Recorridos" aria-describedby="basic-addon1" readonly>
									</div>
								</div>
								<div class="col-md-6 inputs_vehiculo_comision">
									<label for="casetas" class="form-label">Viaticos Casetas</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-circle-dollar-to-slot"></i></span>
										<input type="text" id="casetas" name="casetas" class="form-control solonumeros" placeholder="Viaticos Casetas" aria-label="Viaticos Casetas" aria-describedby="basic-addon1" required>
									</div>
								</div>
								<div class="col-md-6 inputs_vehiculo_comision">
									<label for="combustible" class="form-label">Viaticos Combustible</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-circle-dollar-to-slot"></i></span>
										<input type="text" id="combustible" name="combustible" class="form-control solonumeros" placeholder="Viaticos Combustible" aria-label="Viaticos Combustible" aria-describedby="basic-addon1" required>
									</div>
								</div>
								<div class="col-md-6 inputs_vehiculo_comision">
									<label for="tipo_gasolina" class="form-label">Gasolina</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-gas-pump"></i></span>
										<select class="form-select" name="tipo_gasolina" id="tipo_gasolina" aria-label="Default select example" required>
										</select>
									</div>
								</div>
								<div class="col-md-12 inputs_vehiculo_comision">
									<label for="id_departamentos" class="form-label">Departamentos</label>
									<div class="input-group mb-3" id="departamento_id_departamento">
									</div>
								</div>
								<div class="col-md-12" id="alert_error">
									<div class="alert alert-danger" role="alert">
										<strong><i class="fa-solid fa-triangle-exclamation"></i> ¡Error!</strong> Ya existe un registro con el(los) folio(s) de comision(es) seleccionado(s).
									</div>
								</div>
								<div class="col-md-12" id="alert_error_2">
									<div class="alert alert-danger" role="alert">
										<strong><i class="fa-solid fa-triangle-exclamation"></i> ¡Error!</strong> Verifique sus comisiones, tiene que ser el mismo vehiculo para poder compactar las comisiones.
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-success" id="btn_registrar">Registrar</button>
                            <button type="submit" class="btn btn-success" id="btn_actualizar">Actualizar</button>
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
            Pagination_compacto_comision(1);
			Pagination_comisiones_select(1);
			Buscar_gasolina_comision(1);
			Pagination_departamentos_comision_select(1);
			Solo_numeros();
			$(function () {
				$('.selectpicker').selectpicker();
			});
        });
    </script>
</body>
</html>