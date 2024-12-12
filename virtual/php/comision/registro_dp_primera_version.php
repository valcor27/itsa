<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");
    $proceso = $_POST["proceso_comision_dp"];
    $id = $_POST["id_comision_dp"];
    $id_plaza = $_POST["id_plaza"];
    $expediente = $_POST["exp_emp_comision"];
    $lugar = $_POST["lugar"];
    $fecha = date("Y-m-d", strtotime($_POST["fecha_comision"]));
    $n_comi = $_POST["n_comi"];
    $folio = $_POST["folio_comision"];
    $cargo = $_POST["cargo"];
    $fecha_inicio = date("Y-m-d", strtotime($_POST["fInicio"]));
    $fecha_fin = date("Y-m-d", strtotime($_POST["fFin"]));
    $hora_inicio = date("H:i:s", strtotime($_POST["hora_incio"]));
    $hora_fin = date("H:i:s", strtotime($_POST["hora_fin"]));
    $finalidad = $_POST["finalidad"];
    $duracion = $_POST["duracion"];
    $pais = $_POST["pais"];
    $estado = $_POST["estado"];
    $municipio = $_POST["municipio"];
    $lugar_comision = $_POST["lugar_comision"];
    $usuario = $id_software_sesion;
    $estatus = 1;
    $comprobacion = "0";
    date_default_timezone_set('America/Mexico_City');
    $fecha_movimiento = date('Y-m-d');
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
    switch($proceso){
        case 'Registro':
            /**Corroboramos que no se dupliquen las fechas para el empleado en licencias o movimiento de personal */
            $consulta_comparar = "SELECT * FROM (
                SELECT id_incidencia AS id, 'incidencia' as tipo 
                FROM incidencia
                WHERE expediente = '$expediente' 
                    AND ('$fecha_inicio' BETWEEN fecha_inicio AND fecha_fin 
                        OR '$fecha_fin' BETWEEN fecha_inicio AND fecha_fin)
                    AND estatus = '1' 
            
                UNION
            
                SELECT id_licencia, 'licencia' as tipo 
                FROM licencia
                WHERE expediente_l = '$expediente' 
                    AND ('$fecha_inicio' BETWEEN fecha_inicio_l AND fecha_fin_l 
                        OR '$fecha_fin' BETWEEN fecha_inicio_l AND fecha_fin_l)
                    AND estatus = '1' 
            ) AS subquery
            LIMIT 1;            
            ";
            $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
            $filas_comparar = mysqli_num_rows($resultado_comparar);
            
            mysqli_free_result($resultado_comparar);
            /**--------------------------------------------------------- */
            if($filas_comparar == 0){
                /**Corroboramos que no se dupliquen alguna comision para el empleado */
                $consulta_comparar_2 = "SELECT id_comision FROM comision 
                    WHERE id_empleado = '$expediente' 
                    AND (
                        ('$fecha_inicio $hora_inicio' BETWEEN CONCAT(f_ini, ' ', h_ini) AND CONCAT(f_fin, ' ', h_fin))
                        OR ('$fecha_fin $hora_fin' BETWEEN CONCAT(f_ini, ' ', h_ini) AND CONCAT(f_fin, ' ', h_fin))
                        OR (CONCAT(f_ini, ' ', h_ini) BETWEEN '$fecha_inicio $hora_inicio' AND '$fecha_fin $hora_fin')
                        OR (CONCAT(f_fin, ' ', h_fin) BETWEEN '$fecha_inicio $hora_inicio' AND '$fecha_fin $hora_fin')
                    )
                    AND estatus = '1' 
                    LIMIT 1
                ";
                $resultado_comparar_2 = mysqli_query($conexion_database, $consulta_comparar_2);
                $filas_comparar_2 = mysqli_num_rows($resultado_comparar_2);
                mysqli_free_result($resultado_comparar_2);
                if($filas_comparar_2 == 0){
                    /**Insertamos si no se duplican--------------------------------- */
                    $inserta = "INSERT INTO comision(folio_comision, fecha_comision, id_empleado, nombre_empleado, id_plaza, n_comi, lugar, finalidad, f_ini, 
                    f_fin, h_ini, h_fin, duracion, pais, nombre_estado, nombre_municipio, lugar_comision, estatus, ultimo_movimiento, 
                    fecha_movimiento, usuario_movimiento)VALUES('$folio', '$fecha', '$expediente','$nombre_completo','$id_plaza','$n_comi','$lugar','$finalidad',
                    '$fecha_inicio','$fecha_fin','$hora_inicio','$hora_fin','$duracion','$pais','$estado','$municipio','$lugar_comision','$estatus','$proceso',
                    '$fecha_movimiento', '$usuario')";
                    $respuesta = mysqli_query($conexion_database, $inserta);
                    /***------------------------------------------------------------ */
                }else{
                    $comprobacion = "2";
                }
            }else{
                $comprobacion = "1";
            }    
        break;
        case 'Edicion':
            /**Corroboramos que no se dupliquen las fechas para el empleado en licencias o movimiento de personal */
            $consulta_comparar = "SELECT * FROM (
                SELECT id_incidencia AS id, 'incidencia' as tipo 
                FROM incidencia
                WHERE expediente = '$expediente' 
                    AND ('$fecha_inicio' BETWEEN fecha_inicio AND fecha_fin 
                        OR '$fecha_fin' BETWEEN fecha_inicio AND fecha_fin)
                    AND estatus = '1' 
            
                UNION
            
                SELECT id_licencia, 'licencia' as tipo 
                FROM licencia
                WHERE expediente_l = '$expediente' 
                    AND ('$fecha_inicio' BETWEEN fecha_inicio_l AND fecha_fin_l 
                        OR '$fecha_fin' BETWEEN fecha_inicio_l AND fecha_fin_l)
                    AND estatus = '1' 
            ) AS subquery
            LIMIT 1;            
            ";
            $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
            $filas_comparar = mysqli_num_rows($resultado_comparar);
            
            mysqli_free_result($resultado_comparar);
            /**--------------------------------------------------------- */
            if($filas_comparar == 0){
                /***Corroboramos que no se dupliquen las fechas para el empleado en diferente licencia  */
                $consulta_comparar_2 = "SELECT id_comision FROM comision 
                    WHERE id_comision <> '$id' AND  id_empleado = '$expediente' 
                    AND (
                        ('$fecha_inicio $hora_inicio' BETWEEN CONCAT(f_ini, ' ', h_ini) AND CONCAT(f_fin, ' ', h_fin))
                        OR ('$fecha_fin $hora_fin' BETWEEN CONCAT(f_ini, ' ', h_ini) AND CONCAT(f_fin, ' ', h_fin))
                        OR (CONCAT(f_ini, ' ', h_ini) BETWEEN '$fecha_inicio $hora_inicio' AND '$fecha_fin $hora_fin')
                        OR (CONCAT(f_fin, ' ', h_fin) BETWEEN '$fecha_inicio $hora_inicio' AND '$fecha_fin $hora_fin')
                    )
                    AND estatus = '1' 
                    LIMIT 1
                ";
                /*$consulta_comparar = "SELECT id_licencia FROM licencia WHERE id_licencia <> '$id' AND expediente_l = '$expediente' 
                AND ('$f_inicio' BETWEEN fecha_inicio_l AND fecha_fin_l 
                    OR '$f_fin' BETWEEN fecha_inicio_l AND fecha_fin_l)
                AND estatus = '1' 
                LIMIT 1";*/
                $resultado_comparar_2 = mysqli_query($conexion_database, $consulta_comparar_2);
                $filas_comparar_2 = mysqli_num_rows($resultado_comparar_2);
                /**-------------------------------------------------------------------------------------- */
                if($filas_comparar_2 == 0){
                    $actualiza = "UPDATE comision SET id_empleado = '$expediente', nombre_empleado = '$nombre_completo', id_plaza = '$id_plaza', 
                    n_comi  = '$n_comi', lugar = '$lugar', finalidad = '$finalidad', f_ini = '$fecha_inicio', f_fin = '$fecha_fin', h_ini = '$hora_inicio', 
                    h_fin = '$hora_fin', duracion = '$duracion', pais = '$pais', nombre_estado = '$estado', nombre_municipio = '$municipio', 
                    lugar_comision = '$lugar_comision', ultimo_movimiento = '$proceso', fecha_movimiento = '$fecha_movimiento', 
                    usuario_movimiento = '$usuario' WHERE id_comision = '$id'  LIMIT 1";
                    $respuesta = mysqli_query($conexion_database, $actualiza);
                }else{
                    $comprobacion = "2";
                }    
            }else{
                $comprobacion = "1";
            }
        break;
    }
    /**---------------------------------------------------- */
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
    $consulta = "SELECT id_comision AS id, id_empleado, nombre_empleado, folio_comision, f_ini, f_fin, h_ini, h_fin FROM comision WHERE folio_comision = '$folio' AND estatus = '1' LIMIT 1";
    $registro = mysqli_query($conexion_database, $consulta);
    $filas_venta = mysqli_num_rows($registro);
    /**-------------------------------------------------------------------- */
    $tabla = $tabla.'
      <div class="table-responsive">
        <table class="table table-striped table-bordered table-list table-hover">
          <thead>
              <tr>
                  <th><i class="fa-solid fa-gear"></i></th>
                  <th>Folio</th>
                  <th>Fecha De - Hasta</th>
                  <th>Empleado</th>
              </tr>
          </thead>
          <tbody>
      ';
      while($row = mysqli_fetch_array($registro)){
        $id = $row["id"];
        $expediente = $row["id_empleado"];
        $nombre = $row["nombre_empleado"];
        $folio = $row["folio_comision"];  
        $fecha_inicio = date("d-m-Y", strtotime($row["f_ini"]));
        $fecha_fin = date("d-m-Y", strtotime($row["f_fin"]));
        $hora_inicio = date("H:i", strtotime($row["h_ini"]));
        $hora_fin = date("H:i", strtotime($row["h_fin"]));
        $empleado = $expediente.' '.$nombre;
        $duracion = 'Del '.$fecha_inicio.' a las '.$hora_inicio.' Hasta el '. $fecha_fin.' a las '.$hora_fin;
        $consulta_3 = "SELECT id_viaticos_comision, comision_id_comision FROM viaticos_comision WHERE comision_id_comision = '$id' LIMIT 1";
        $id_viaticos = null;
        $registro_3 = mysqli_query($conexion_database, $consulta_3);
        while($row_3 = mysqli_fetch_array($registro_3)){
            $id_viaticos = $row_3["id_viaticos_comision"];
            $id_comision = $row_3["comision_id_comision"];
        }
        mysqli_free_result($registro_3);
    
        $consulta_4 = "SELECT id_parque_comision, comision_id_comision FROM parque_comision WHERE comision_id_comision = '$id' LIMIT 1";
        $id_parque = null;
        $registro_4 = mysqli_query($conexion_database, $consulta_4);
        while($row_4 = mysqli_fetch_array($registro_4)){
            $id_parque = $row_4["id_parque_comision"];
            $id_comision_parque = $row_4["comision_id_comision"];
        }
        mysqli_free_result($registro_4);
        if($id_viaticos != null && $id_comision != null){
            $valor_boton_viaticos = '
                <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Viaticos Comisión" onclick="Viaticos_comision('.$id_viaticos.','. $id_comision.');">
                    <i class="fa-solid fa-sack-dollar"></i>
                </button>
            ';
        }else{
            $valor_default = 0;
            $valor_boton_viaticos = '
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Viaticos Comisión" onclick="Viaticos_comision('.$valor_default.','. $id.');">
                    <i class="fa-solid fa-sack-dollar"></i>
                </button>
            ';
        }
        if($id_parque != null && $id_comision_parque != null){
            $valor_boton_parque = '
                <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Parque Vehicular Comisión" onclick="Parque_comision('.$id_parque.','.$id_comision_parque.');">
                    <i class="fa-solid fa-car"></i>
                </button>
            ';
        }else{
            $valor_default_parque = 0;
            $valor_boton_parque = '
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Parque Vehicular Comisión" onclick="Parque_comision('.$valor_default_parque.','.$id.');">
                    <i class="fa-solid fa-car"></i>
                </button>
            ';
        }
        $tabla = $tabla.'
            <tr>
                <td align="center">
                    <button type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Actualizar Comisión" onclick="Actualizar_comision_dp('.$id.');">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Eliminar Comisión" onclick="Eliminar_comision_dp('.$id.');">
                        <i class="far fa-trash-alt"></i>
                    </button>
                    '.$valor_boton_parque.' '.
                    $valor_boton_viaticos
                    .'
                    
                </td>
                <td>'.$folio.'</td>
                <td>'.$duracion.'</td>
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