<?php require("../php/sesion/logueo.php") ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> CONTROL DE GESTIÓN</title>
</head>
<body>
<input type="hidden" id="url_paginar" name="url_paginar" value="php/documento_ssa/paginacion.php">
<input type="hidden" id="url_departamento" name="url_departamento" value="php/departamentos/departamentos.php">
<input type="hidden" id="url_departamento_alta" name="url_departamento_alta" value="php/departamentos/departamentos_alta.php">
<input type="hidden" id="url_modificar" name="url_modificar" value="php/documento_ssa/modificar.php">
<input type="hidden" id="url_documento_envio" name="url_documento_envio" value="php/documento_ssa/documento_envio.php">
<input type="hidden" id="url_historial_documento" name="url_historial_documento" value="php/documento_ssa/documento_historial.php">
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
											<h6 class="text-white ps-3 title-pagina"><i class="fa-solid fa-file-lines"></i> módulo de documentos</h6>
										</div>
									</div>
									<div class="row justify-content-between">
										<div class="col-auto">
											<form id="buscar" name="buscar" onsubmit="return Pagination_documentos(1);">
												<div class="input-group mb-3 ps-3">
													<input type="text" name="busqueda" id="busqueda" class="form-control" placeholder="Buscar Documento">
													<button class="btn btn-outline-light" type="submit" id="button-addon2">Buscar</button>
												</div>  
											</form>
										</div>
										<div class="col-auto">
											<div class="d-flex justify-content-end ps-3 me-5">
												<button type="button" class="btn btn-outline-light" onclick="Modal_configuracion_documentos();">
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
		<div class="modal fade" id="modal_documento" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_documento_label" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title" id="modal_documento_label"></h6>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form  action="php/documento_ssa/registro.php" id="form_documento" name="form_documento" method="POST" onsubmit="return Registrar_documento_ssa();" enctype="multipart/form-data">
						<input class="form-control" type="hidden" name="proceso_documento" id="proceso_documento" required>
						<input class="form-control" type="hidden" name="id_documento" id="id_documento" value="0" required>
						<input class="form-control" type="hidden" name="valor_departamento" id="valor_departamento" value="0" required>
						<div class="modal-body">
							<div class="row justify-content-center">
								<div class="col-md-6">
									<label for="folio" class="form-label">Folio</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-receipt"></i></span>
										<input type="text" id="folio" name="folio" class="form-control" placeholder="Folio" aria-label="Folio" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-6">
									<label for="asunto" class="form-label">Asunto</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-folder-open"></i></span>
										<input type="text" id="asunto" name="asunto" class="form-control" placeholder="Asunto" aria-label="Asunto" aria-describedby="basic-addon1" required="">
									</div>
								</div>
								<div class="col-md-4">
									<label for="tipo_doc" class="form-label">Tipo de Documento</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-file-prescription"></i></span>
										<select class="form-select" name="tipo_doc" id="tipo_doc" onchange="return Pagination_departamentos_alta_select();" aria-label="Default select example" required="">
											<option value="" selected disabled>Selecciona</option>
											<option value="1">Oficio Circular</option>
											<option value="2">Oficio</option>
											<option value="3">Memorándum</option>
										</select>
										<!--<input type="text" id="tipo_doc" name="tipo_doc" class="form-control" placeholder="Tipo de Documento" aria-label="Tipo de Documento" aria-describedby="basic-addon1" required="">-->
									</div>
								</div>
								<div class="col-md-8">
									<label for="departamento" class="form-label">Departamento Origen</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-building-user"></i></span>
										<select class="form-select" name="departamento" id="departamento" aria-label="Default select example" required="">
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<label for="fCrea" class="form-label">Fecha de Creación</label>
									<div class="input-group mb-3 date">
										<span class="input-group-text"><i class="fa-regular fa-calendar-days"></i></span>
										<input type="text" id="fCrea" name="fCrea" class="form-control" placeholder="Fecha de Creación" aria-label="Fecha de Creación" aria-describedby="basic-addon1" required="" data-provide="datepicker">
									</div>
								</div>
								<div class="col-md-8">
									<label for="fuente_fin" class="form-label">Fuente de Financiamiento</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-sack-dollar"></i></span>
										<select class="selectpicker form-control" multiple name="fuente_fin[]" id="fuente_fin" aria-label="Default select example" onchange="return Pagination_inputs();">
											<option value="141">Captación de Derechos(141)</option> 	
											<option value="151">Federal(151)</option>
											<option value="161">Estatal(161)</option>
											<option value="145">Ingresos Propios(145)</option>
											<option value="07">Por Asignar</option>
										</select>
									</div>
								</div>
								<div class="col-md-4 columna_partida" style="display: none;" id="partida_cderechos">
									<label for="pcd" class="form-label">Partida C. de Derechos</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-user-tie"></i></span>
										<input type="text" id="pcd" name="pcd" class="form-control" placeholder="Partida Captación de Derechos" aria-label="Partida Captación de Derechos" aria-describedby="basic-addon1" disabled>
									</div>
								</div>
								<div class="col-md-4 columna_partida" style="display: none;" id="partida_federal">
									<label for="pf" class="form-label">Partida Federal</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-user-tie"></i></span>
										<input type="text" id="pf" name="pf" class="form-control" placeholder="Partida Federal" aria-label="Partida Federal" aria-describedby="basic-addon1" disabled>
									</div>
								</div>
								<div class="col-md-4 columna_partida" style="display: none;" id="partida_estatal">
									<label for="pe" class="form-label">Partida Estatal</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-user-tie"></i></span>
										<input type="text" id="pe" name="pe" class="form-control" placeholder="Partida Estatal" aria-label="Partida Estatal" aria-describedby="basic-addon1" disabled>
									</div>
								</div>
								<div class="col-md-4 columna_partida" style="display: none;" id="partida_ipropios">
									<label for="pip" class="form-label">Partida Ingresos Propios</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-user-tie"></i></span>
										<input type="text" id="pip" name="pip" class="form-control" placeholder="Partida Ingresos Propios" aria-label="Partida Ingresos Propios" aria-describedby="basic-addon1" disabled>
									</div>
								</div>
								<div class="col-md-4 columna_partida" style="display: none;" id="partida_pasignar">
									<label for="ppa" class="form-label">Partida Por Asignar</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-user-tie"></i></span>
										<input type="text" id="ppa" name="ppa" class="form-control" placeholder="Partida Por Asignar" aria-label="Partida Por Asignar" aria-describedby="basic-addon1" disabled>
									</div>
								</div>
								<div class="col-md-9">
									<label for="observacion" class="form-label">Observaciones</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-comments"></i></span>
										<textarea class="form-control" id="observacion" name="observacion" rows="2" placeholder="Observaciones" maxlength="200"></textarea>
									</div>
								</div>
								<div class="col-md-9">
									<label for="archivo" class="form-label">Seleccione o arrastre su documento aqui (Solo documentos PDF)</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-file-pdf"></i></span>
										<input class="form-control" type="file" id="archivo" name="archivo">
									</div>
								</div>
								<div class="col-md-9" id="alert_error_documento">
									<div class="alert alert-danger" role="alert">
										<strong><i class="fa-solid fa-triangle-exclamation"></i> ¡Error!</strong> El folio ya esta siendo usado por otro documento.
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-success" id="btn_agregar_documento"></button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modal_documento_envio" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_documento_envio_label" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title" id="modal_documento_envio_label"></h6>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form  action="php/documento_ssa/registro_envio.php" id="form_documento_envio" name="form_documento_envio" onsubmit="return Registrar_documento_envio_ssa();">
						<input class="form-control" type="hidden" name="proceso_documento_envio" id="proceso_documento_envio" required>
						<input class="form-control" type="hidden" name="id_documento_envio" id="id_documento_envio" value="0" required>
						<input class="form-control" type="hidden" name="fecha_envio_documento" id="fecha_envio_documento" value="0" required>
						<div class="modal-body">
							<div class="row justify-content-center">
								<div class="col-md-6">
									<label for="folio_envio" class="form-label">Folio</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-receipt"></i></span>
										<input type="text" id="folio_envio" name="folio_envio" class="form-control" placeholder="Folio" aria-label="Folio" aria-describedby="basic-addon1" disabled>
									</div>
								</div>
								<div class="col-md-6">
									<label for="asunto_envio" class="form-label">Asunto</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-folder-open"></i></span>
										<input type="text" id="asunto_envio" name="asunto_envio" class="form-control" placeholder="Asunto" aria-label="Asunto" aria-describedby="basic-addon1" disabled>
									</div>
								</div>
								<div class="col-md-8">
									<label for="departamento_envio" class="form-label">Departamento Destino</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-building-user"></i></span>
										<select class="form-select" name="departamento_envio" id="departamento_envio" aria-label="Default select example" required="">
										</select>
									</div>
								</div>
								<div class="col-md-4">
									<label for="fEnv" class="form-label">Fecha de Envio</label>
									<div class="input-group mb-3 date">
										<span class="input-group-text"><i class="fa-regular fa-calendar-days"></i></span>
										<input type="text" id="fEnv" name="fEnv" class="form-control" placeholder="Fecha de Envio" aria-label="Fecha de Envio" aria-describedby="basic-addon1" disabled>
									</div>
								</div>
								<div class="col-md-8" id="alert_error_documento_envio">
									<div class="alert alert-danger" role="alert">
										<strong><i class="fa-solid fa-triangle-exclamation"></i> ¡Error!</strong> El documento se encuentra en el mismo departamento al que lo quiere enviar.
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-success" id="btn_agregar_documento_envio">Enviar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal fade" id="modal_historial_documento" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_historial_documento_label" aria-hidden="true">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title" id="modal_historial_documento_label"></h6>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body" id="historial_documentos_table">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
					</div>
				</div>
			</div>
		</div>
    </main> 
	<script>
        $(document).ready(function(){
            Pagination_documentos(1);
			Pagination_departamentos_select(1);
			
			$(function () {
        		$("#fCrea").datepicker({
            		language: 'es',
					format: 'dd-mm-yyyy'
        		});
    		});
        });
    </script>
</body>
</html>