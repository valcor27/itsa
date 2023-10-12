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
		<input type="hidden" id="url_paginar_carga_materia" name="url_paginar_carga_materia" value="php/carga/paginacion_carga_materia.php">
		<input type="hidden" id="url_paginar_carga_grupo" name="url_paginar_carga_grupo" value="php/carga/paginacion_carga_grupo.php">
		<input type="hidden" id="url_paginar_carga_salon" name="url_paginar_carga_salon" value="php/carga/paginacion_carga_salon.php">
        <input type="hidden" id="url_modificar_carga_materia" name="url_modificar_carga_materia" value="php/carga/modificar_carga_docente.php">
        <input type="hidden" id="url_eliminar_carga_materia" name="url_eliminar_carga_materia" value="php/carga/eliminar_carga_docente.php">
        <input type="hidden" name="x_clave" id="x_clave">
        <input type="hidden" name="x_carga" id="x_carga">
            <div class="wrraper">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card my-4">
                            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
								<div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3 ">
									<div class="row justify-content-center">
										<div class="col-auto align-items-center">
											<h6 class="text-white ps-3 title-pagina"><i class="fa-solid fa-chalkboard-user"></i> carga académica</h6>
										</div>
									</div>
									<div class="row justify-content-around" id="detalle_docente"></div>
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
        <div class="modal fade" id="modal_carga_materia" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_carga_materia_label" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h6 class="modal-title" id="modal_carga_materia_label"></h6>
						<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<form action="php/carga/registro_carga_docente.php" id="form_carga_materia" name="form_carga_materia" onsubmit="return Registrar_carga_materia();">
						<input class="form-control" type="hidden" name="pro" id="pro" required>
                        <input class="form-control" type="hidden" name="id" id="id" value="0" required>
						<input class="form-control" type="hidden" name="hora" id="hora" required>
                        <input class="form-control" type="hidden" name="punto" id="punto" required>
                        <input class="form-control" type="hidden" name="clave" id="clave" required>
                        <input class="form-control" type="hidden" name="carga_idcarga" id="carga_idcarga" required>
                        <input class="form-control" type="hidden" name="valor_materia" id="valor_materia" value="0">  
						<div class="modal-body">
							<div class="row justify-content-center">
								<div class="col-md-6">
									<label for="salon_idsalon" class="form-label">Salón</label>
									<div class="input-group mb-3" id="salon_select_salon">
									</div>
								</div>
								<div class="col-md-6">
									<label for="grupo_idgrupo" class="form-label">Grupo</label>
									<div class="input-group mb-3" id="grupo_select_grupo">
									</div>
								</div>
								<div class="col-md-6">
									<label for="materia_idmateria" class="form-label">Materia</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-solid fa-laptop-file"></i></span>
										<select class="form-select" name="materia_idmateria" id="materia_idmateria" required="">
        								<!--<option value="" selected disabled>Selecciona</option>-->
									</select>
									</div>
								</div>
								<div class="col-md-6">
									<label for="hora_oculta" class="form-label">Horario</label>
									<div class="input-group mb-3">
										<span class="input-group-text"><i class="fa-regular fa-clock"></i></span>
										<input type="text" id="hora_oculta" name="hora_oculta" class="form-control" placeholder="Horario" aria-label="Horario" aria-describedby="basic-addon1" disabled="">
									</div>
								</div>
								<!--
                                <div class="col-md-10" id="alert_error">
									<div class="alert alert-danger" role="alert">
										<strong><i class="fa-solid fa-triangle-exclamation"></i> ¡Error!</strong> El titulo o cedula ingresado ya esta registrado.
									</div>
								</div>-->
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
							<button type="submit" class="btn btn-success" id="registra">Registrar</button>
							<button type="submit" class="btn btn-success" id="editar">Actualizar</button>
                            <button type="button" class="btn btn-danger" id="eliminar" onclick="Eliminar_carga_materia(1);">Eliminar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
    </main>
    <script>
        $(document).ready(function(){
			Pagination_carga_docente_salon(1);
			Pagination_carga_docente_grupo(1);
			$(function () {
				$('.selectpicker').selectpicker();
			});
        });
    </script>
</body>
</html>