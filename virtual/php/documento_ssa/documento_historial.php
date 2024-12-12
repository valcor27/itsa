<?php 
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");
	$id = $_POST["id"];
	$tabla = '';
    /***---------Consultamos la BD para mostrar los registros------ */
    $consulta = "SELECT 
		documentos.folio AS folio_documento,
    	COALESCE(dep_anterior.nombreUnidad, 'Sin departamento anterior') AS nombre_departamento_anterior,
    	COALESCE(dep_actual.nombreUnidad, 'Sin departamento anterior') AS nombre_departamento_actual,
    	historial_movimientos.fecha AS fecha_envio,
		historial_movimientos.estatus_documento AS estatus
		FROM 
    		historial_movimientos
		JOIN 
			documentos ON historial_movimientos.documento_id_documento = documentos.id_documento
		LEFT JOIN 
			estructuraorganica AS dep_anterior ON historial_movimientos.departamento_anterior = dep_anterior.claveUnidad
		JOIN 
			estructuraorganica AS dep_actual ON historial_movimientos.departamento_actual = dep_actual.claveUnidad
		WHERE historial_movimientos.documento_id_documento = '$id' ORDER BY historial_movimientos.id_historial
	";
	$registro = mysqli_query($conexion_database, $consulta);
	$no_filas = mysqli_num_rows($registro);
    /**------------------------------------------------------------ */
	$tabla = $tabla.'
		<div class="row justify-content-center">
			<div class="table-responsive">
				<table class="table table-hover table-bordered">
	';
	if($no_filas > 0){
		$tabla = $tabla.'
			<thead>
				<tr> 
					<th>Folio</th>
					<th>Departamento Anterior</th>
					<th>Departamento Actual</th>
					<th>Fecha de Envio</th>
					<th>Estatus del Documento al Enviarse</th>
				</tr>
			</thead>
			<tbody>
		';
		while($row = mysqli_fetch_array($registro)){
			$folio = $row["folio_documento"];
			$dep_ant = $row["nombre_departamento_anterior"];
			$dep_act = $row["nombre_departamento_actual"];
			$fecha = date("d-m-Y", strtotime($row["fecha_envio"]));
			$estatus = $row["estatus"];
			if($estatus == 0){
				$valor_estatus = '<span class="badge text-bg-danger">Cancelado</span>';
			}else if($estatus == 1){
				$valor_estatus = '<span class="badge text-bg-warning">En proceso</span>';
			}else if($estatus == 2){
				$valor_estatus = '<span class="badge text-bg-success">Aceptado</span>';
			}
			$tabla = $tabla.'
				<tr>
					<td>'.$folio.'</td>
					<td>'.$dep_ant.'</td>
					<td>'.$dep_act.'</td>
					<td>'.$fecha.'</td>
					<td>'.$valor_estatus.'</td>
				</tr>
			';
		}
		$tabla = $tabla.'
			</tbody>
		';
	}else{
		$tabla = $tabla.'
            <div class="alert alert-info">
                <strong>Mensaje!</strong> No se encontro ningún registro.
            </div>  
        ';
	}
	$tabla = $tabla.'
				</table>
			</div>
		</div>
	';
	$array = array(
		0 => $tabla
	);
	echo json_encode($array);

	mysqli_free_result($registro);
	mysqli_close($conexion_database);
?>		