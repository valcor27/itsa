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
        <input type="hidden" name="url_paginar" id="url_paginar" value="php/detalle_pagos/paginacion.php">
        <input type="hidden" name="url_modificar" id="url_modificar" value="php/detalle_pagos/modificar.php">
        <input type="hidden" name="url_paginar_departamentos" id="url_paginar_departamentos" value="php/departamentos/selectpicker_estructura_organica.php">
        <input type="hidden" name="url_paginar_select_busqueda" id="url_paginar_select_busqueda" value="php/departamentos/selectpicker_busqueda_estructura_organica.php">
        <input class="form-control" type="hidden" name="x_pago" id="x_pago" required>
        <div class="container-fluid mt-5">
            <div class="wrraper">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                                <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 ">
                                    <div class="row justify-content-center">
                                        <div class="col-auto align-items-center">
                                            <h6 class="text-white ps-3 title-pagina"><i class="fa-solid fa-receipt"></i> detalle pago</h6>
                                        </div>
                                    </div>
                                    <!--<div class="row justify-content-between">
										<div class="col-auto" id="form_select_detalle_pago"></div>
									</div>-->
                                    <div class="container-fluid text-center">
                                        <div class="row justify-content-evenly row-cols-auto" id="detalle_del_pago"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid">
                                <div class="card-body px-0 pb-2">
                                    <div class="card mb-4">
                                        <div class="card-header cheader">
                                            <div class="row align-items-center justify-content-between">
                                                <div class="col-auto">
                                                    <i class="fas fa-folder-open"></i>
                                                    Listado de Registros
                                                </div>
                                                <div class="col-auto me-5">
                                                    <button type="button" class="btn btn-outline-danger" onclick="Modal_configuracion_detalle_pago();">
                                                        <i class="fa-solid fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div id="agrega-registros">Datos Tabla</div>     
                                        </div>
                                        <!--<div class="card-footer text-muted">
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
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_detalle_pagos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_detalle_pagos_label" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title" id="modal_detalle_pagos_label"></h6>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form action="php/detalle_pagos/registro.php" method="POST" id="form_detalle_pago" name="form_detalle_pago" onsubmit="return Registrar_detalle_pago();">
						<div class="modal-body">
							<input class="form-control" type="hidden" name="proceso_detalle_pago" id="proceso_detalle_pago" required>
							<input class="form-control" type="hidden" name="id_detalle_pago" id="id_detalle_pago" value="0" required>
							<div class="col-md-12">
                                <label for="monto_detalle_pago" class="form-label">Monto Detalle Pago</label>
                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="fa-solid fa-sack-dollar"></i></span>
                                    <input type="text" id="monto_detalle_pago" name="monto_detalle_pago" class="form-control solonumeros" placeholder="Monto" aria-label="Monto" aria-describedby="basic-addon1" required="">
                                </div>
                            </div>                    							
                            <div class="col-md-12">
                                <label for="id_departamentos" class="form-label">Departamento</label>
                                <div class="input-group mb-3" id="departamento_select_departamento"></div>
                            </div>
                            <div class="col-md-12" id="aler_detalle_pago">
                                <div class="alert alert-danger" role="alert">
                                    <strong><i class="fa-solid fa-triangle-exclamation"></i> ¡Error!</strong> El monto del detalle supera ya a la suma del monto del Pago Total, Verifique el monto del detalle.
                                </div>
                            </div>
                        </div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-success" id="btn_agregar_detalle_pago">Registrar</button>
							<button type="submit" class="btn btn-success" id="btn_actualizar_detalle_pago">Actualizar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
    </main>
    <script>
        $(document).ready(function(){
            Paginacion_departamento_detalle_pago(1);
            //Paginacion_select_busqueda_detalle_pago(1);
            Solo_numeros();
            $(function () {
				$('.selectpicker').selectpicker();
			});
        });
    </script>
</body>
</html>