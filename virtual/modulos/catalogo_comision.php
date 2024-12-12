<?php require("../php/sesion/logueo.php") ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> CONTROL DE GESTIÓN</title>
</head>
<body>
<input type="hidden" id="url_paginar" name="url_paginar" value="php/catalogo_comisiones/paginacion.php">
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
											<h6 class="text-white ps-3 title-pagina"><i class="fa-solid fa-route"></i> módulo de visualización de comisiones</h6>
										</div>
									</div>
                                    <div class="row justify-content-center">
                                        <form class="row g-3" id="buscar" name="buscar" onsubmit="return Pagination_catalogo_comsiones(1);">
                                            <div class="col-auto">
                                                <input type="text" id="fInicio" name="fInicio" class="form-control" placeholder="Fecha de Inicio" aria-label="Fecha de Inicio" aria-describedby="basic-addon1" data-provide="datepicker">
                                            </div>
                                            <div class="col-auto">
                                                <input type="text" id="fFin" name="fFin" class="form-control" placeholder="Fecha de Fin" aria-label="Fecha de Fin" aria-describedby="basic-addon1" data-provide="datepicker">
                                            </div>
                                            <div class="col-auto">
                                                <button type="submit" class="btn btn-outline-light mb-3">Buscar</button>
                                            </div>
                                        </form>
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
            Pagination_catalogo_comsiones(1);
			$(function () {
        		$("#fInicio").datepicker({
            		language: 'es',
					format: 'dd-mm-yyyy',
					autoclose: 'true'
        		});
        	});
            $(function () {
                $("#fFin").datepicker({
                    language: 'es',
                    format: 'dd-mm-yyyy',
                    autoclose: 'true'
                });
    		});
        });
    </script>
</body>
</html>