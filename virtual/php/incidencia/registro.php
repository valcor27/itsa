<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");
    $proceso = $_POST["proceso_incidencia"];
    $id = $_POST["id_incidencia"];
    $folio = $_POST["incidencia_folio"];
    $hora = date("H:i:s", strtotime($_POST["incidencia_hora"]));
    $expediente = $_POST["exp_emp_incidencia"];
    $f_inicio = date("Y-m-d", strtotime($_POST["fInicio"]));
    $f_fin = date("Y-m-d", strtotime($_POST["fFin"]));
    $f_elaboracion = date("Y-m-d", strtotime($_POST["fElaboracion"]));
    $clave_mov = $_POST["id_clave_mov"];
    $observacion = $_POST["observacion"];
    $estatus = 1;
    $comprobacion = "0";
    date_default_timezone_set('America/Mexico_City');
    $fecha = date('Y-m-d');
    $usuario = $id_software_sesion;
    /**Buscamos el nombre del empleado--------------------- */
    if($expediente >= 1){
        $consulta_empleado = "SELECT primerApellido, segundoApellido, nombres FROM empleados WHERE expediente = '$expediente' LIMIT 1";
        $resultado_empleado = mysqli_query($conexion_database, $consulta_empleado);
        while($reg_empleado = mysqli_fetch_array($resultado_empleado)){
            $apepat = $reg_empleado["primerApellido"];
            $apemat = $reg_empleado["segundoApellido"];
            $nombre = $reg_empleado["nombres"];
            $nombre_completo = $nombre.' '.$apepat.' '.$apemat;
            $nombre_completo = sanear_string($nombre_completo);
        }
        mysqli_free_result($resultado_empleado);
    }
    /**---------------------------------------------------- */
    switch($proceso){
        case 'Registro':
            /**Corroboramos que no se dupliquen las fechas para el empleado en diferente incidencia */
            $consulta_comparar = "SELECT id_incidencia FROM incidencia WHERE expediente = '$expediente' AND fecha_inicio = '$f_inicio' AND fecha_fin = '$f_fin' AND estatus = '1' LIMIT 1";
            $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
            $filas_comparar = mysqli_num_rows($resultado_comparar);
            
            mysqli_free_result($resultado_comparar);
            /**--------------------------------------------------------- */
            if($filas_comparar == 0){
                /**Insertamos si no se duplican--------------------------------- */
                $inserta = "INSERT INTO incidencia(folio_incidencia, hora_incidencia, expediente, nombre_empleado, fecha_inicio,
                fecha_fin, fecha_elaboracion, id_clave_mov, observacion, estatus, fecha_movimiento, ultimo_movimiento, usuario_movimiento)VALUES('$folio',
                '$hora','$expediente','$nombre_completo','$f_inicio','$f_fin','$f_elaboracion','$clave_mov','$observacion','$estatus',
                '$fecha', '$proceso', '$usuario')";
                $respuesta = mysqli_query($conexion_database, $inserta);
                /***------------------------------------------------------------ */
            }else{
                $comprobacion = "1";
            }    
        break;
        case 'Edicion':
            /***Corroboramos que no se dupliquen las fechas para el empleado en diferente incidencia  */
            $consulta_comparar = "SELECT id_incidencia FROM incidencia WHERE id_incidencia <> '$id' AND expediente = '$expediente' AND fecha_inicio = '$f_inicio' AND fecha_fin = '$f_fin' AND estatus = '1' LIMIT 1";
            $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
            $filas_comparar = mysqli_num_rows($resultado_comparar);
            /**-------------------------------------------------------------------------------------- */
            if($filas_comparar == 0){
                $actualiza = "UPDATE incidencia SET hora_incidencia = '$hora', 
                expediente = '$expediente', nombre_empleado = '$nombre_completo', 
                fecha_inicio = '$f_inicio', fecha_fin = '$f_fin', fecha_elaboracion = '$f_elaboracion', 
                id_clave_mov = '$clave_mov', observacion = '$observacion', 
                fecha_movimiento = '$fecha', ultimo_movimiento = '$proceso', usuario_movimiento = '$usuario' 
                WHERE id_incidencia = '$id' LIMIT 1";
                $respuesta = mysqli_query($conexion_database, $actualiza);
            }else{
                $comprobacion = "1";
            }    
        break;
    }
    $lista_info = '';
  $lista = '';
  $tabla = '';
  /*--Lista de informacion de paginas---------------------- */
  $lista_info = $lista_info.'Pag. 1/1';
  /**------------------------------------------------------ */
  /**Realizamos la paginacion para tabletas y pc----------- */
  $lista = $lista.'
    <ul class="pagination linea_derecha">
      <li class="page-item disabled">
        <a class="page-link" href="#Anterior">
          <i class="fas fa-arrow-alt-circle-left"></i>
        </a>
      </li>

      <li class="page-item active">
        <a class="page-link" href="#Paginar">1</a>
      </li>

      <li class="page-item disabled">
        <a class="page-link" href="#Siguiente">
          <i class="fas fa-arrow-alt-circle-right"></i>
        </a>
      </li>
    </ul>
  ';
  /**------------------------------------------------------ */
  /**Consultamos la base de datos completa para mostrar el registro------ */
  $consulta = "SELECT id_incidencia AS id, expediente, nombre_empleado, folio_incidencia, fecha_inicio, fecha_fin, id_clave_mov FROM incidencia WHERE folio_incidencia = '$folio' AND estatus = '1' LIMIT 1";
  $registro = mysqli_query($conexion_database, $consulta);
  $filas_venta = mysqli_num_rows($registro);
  /**-------------------------------------------------------------------- */
  $tabla = $tabla.'
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-list table-hover">
        <thead>
            <tr>
                <th><i class="fa-solid fa-gear"></i></th>
                <th>Folio Incidencia</th>
                <th>Clave Movimiento</th>
                <th>Fecha De - Hasta</th>
                <th>Empleado</th>
            </tr>
        </thead>
        <tbody>
    ';
    while($row = mysqli_fetch_array($registro)){
        $id = $row["id"];
        $expediente = $row["expediente"];
        $nombre = $row["nombre_empleado"];
        $folio = $row["folio_incidencia"];  
        $fecha_inicio = date("d-m-Y", strtotime($row["fecha_inicio"]));
        $fecha_fin = date("d-m-Y", strtotime($row["fecha_fin"]));
        $clave = $row["id_clave_mov"];
        $empleado = $expediente.' '.$nombre;
        $fechas = $fecha_inicio.' - '.$fecha_fin;
        $tabla = $tabla.'
            <tr>
                <td align="center">
                    <button type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Actualizar Incidencia" onclick="Actualizar_incidencia('.$id.');">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Eliminar Incidencia" onclick="Eliminar_incidencia('.$id.');">
                        <i class="far fa-trash-alt"></i>
                    </button>
                </td>
                <td>'.$folio.'</td>
                <td>'.$clave.'</td>
                <td>'.$fechas.'</td>
                <td>'.$empleado.'</td>
            </tr>
        ';
    }
    $tabla = $tabla.'
        </tbody>
      </table>
    </div>
    ';
    $array = array(
        0 => $tabla,
        1 => $lista_info,
        2 => $lista,
        3 => $comprobacion
    );

  echo json_encode($array);
  mysqli_free_result($registro);
  mysqli_close($conexion_database);
?>