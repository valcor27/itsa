<?php require("../php/sesion/logueo.php") ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> CONTROL DE GESTIÓN </title>
</head>
<body>
    <main id="contenido_pagina">
        <div class="container mt-5">
        <!--<input type="hidden" name="x_clave" id="x_clave">-->
        <input type="hidden" name="x_identificador" id="x_identificador">
            <div class="wrraper">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
								<div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 ">
									<div class="row justify-content-center">
										<div class="col-auto align-items-center">
											<h6 class="text-white ps-3 title-pagina"><i class="fa-solid fa-clipboard-user"></i> detalle de asistencia</h6>
										</div>
									</div>
									<div class="row justify-content-around" id="detalle_quincena"></div>
								</div>
							</div>
							<div class="container">
								<div class="card-body px-0 pb-2">
                                    <div id="agrega_tabla">Datos Tabla</div>
								</div>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
    </main>
    <script>
        $(document).ready(function(){
        });
    </script>
</body>
</html>