<?php
  require("../conexion/conexion_bd.php");
  require("../sesion/logueo.php");
  require("../clases/limpiar.php");
  date_default_timezone_set('America/Mexico_City');
  $fecha_movimiento = date('Y-m-d');
  $usuario = $id_software_sesion;
  $proceso = "Registro";

  $id_asistencia = $_POST["idasistencia"];
  $estatus = 1;

  $detalle_quincena='';
  $tabla='';

  /**Consultamos la base de datos para obtener los datos de quincena */
  $consulta_q = "SELECT id_asistencia, nombre_txt, fecha_inicio, fecha_fin FROM asistencia WHERE id_asistencia = '$id_asistencia' LIMIT 1";
  $resultado_q = mysqli_query($conexion_database, $consulta_q);

  while($row = mysqli_fetch_array($resultado_q)){
    $idasistencia = $row["id_asistencia"];
    $nombre_archivo = $row["nombre_txt"];
    $fecha_inicio = date("d-m-Y", strtotime($row["fecha_inicio"]));
    $fecha_fin = date("d-m-Y", strtotime($row["fecha_fin"]));
    $fecha_inicio_normal = $row["fecha_inicio"];
    $fecha_fin_normal = $row["fecha_fin"];
  }
  mysqli_free_result($resultado_q);
  $ruta_archivo = "../../documentos_asistencia/";
  $archivo_buscar = $ruta_archivo . $nombre_archivo;
  /**--------------------------------------------------------------- */
  /**Mostrar los datos de la quincena------------------------------- */
  $detalle_quincena = $detalle_quincena.'
    <div class="col-auto">
      <p class="datos_quincena">Quincena Iniciada: <span>' . $fecha_inicio .'</span> Y Finalizada: <span>' . $fecha_fin .'</span></p>
    </div>
  ';
  /**--------------------------------------------------------------- */
  /**-----Corroboramos de que no existan las detalles de la carga--- */
  $consulta_comparar = "SELECT id_asistencia FROM detalle_asistencia WHERE id_asistencia = '$id_asistencia'";
  $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
  $filas_comparar = mysqli_num_rows($resultado_comparar);

  mysqli_free_result($resultado_comparar);
  /**--------------------------------------------------------------- */
  /***Insertamos registros si no existen---------------------------- */
  if($filas_comparar == 0){
    $archivo = $archivo_buscar;
    $fecha_inicio_quincena = date("Y-m-d", strtotime($fecha_inicio));
    $fecha_fin_quincena = date("Y-m-d", strtotime($fecha_fin));
    $fechas_rango = [];
    $registros = array();

    if (($gestor = fopen($archivo, 'r')) !== false) {
        while (($linea = fgets($gestor)) !== false) {
            $datos = explode("\t", $linea);
            $idEmpleado = $datos[0];
            $fecha = $datos[1];
            $hora = $datos[2];

            $horaDateTime = DateTime::createFromFormat('d/m/Y H:i:s', "$fecha $hora");

            if ($horaDateTime === false) {
                echo "Error al interpretar la fecha y hora: $fecha $hora<br>";
            }

            if (!isset($registros[$idEmpleado][$fecha]['primeraEntrada']) || $horaDateTime < $registros[$idEmpleado][$fecha]['primeraEntrada']) {
                $registros[$idEmpleado][$fecha]['primeraEntrada'] = $horaDateTime;
            }

            if (!isset($registros[$idEmpleado][$fecha]['ultimaSalida']) || $horaDateTime > $registros[$idEmpleado][$fecha]['ultimaSalida']) {
                $registros[$idEmpleado][$fecha]['ultimaSalida'] = $horaDateTime;
            }
        }

        fclose($gestor);

        $valores = array();
        foreach ($registros as $idEmpleado => $fechas) {
            foreach ($fechas as $fecha => $datos) {
                // Verificar si no es sábado ni domingo
                if (date('w', strtotime($fecha)) != 0) {
                  // Obtener las horas en el formato correcto
                  $primeraEntrada = $datos['primeraEntrada']->format('H:i:s');
                  $ultimaSalida = $datos['ultimaSalida']->format('H:i:s');
                  // Convertir la fecha al formato correcto
                  $fechaDateTime = DateTime::createFromFormat('d/m/Y', $fecha);
                  $fecha = $fechaDateTime->format('Y-m-d');
                  // Almacenar los datos en un array
                  $valores[] = "('$idasistencia', '$idEmpleado', '$fecha', '$primeraEntrada', '$ultimaSalida', '$estatus', '$proceso', '$fecha_movimiento', '$usuario')";
                    
                }
            }
        }

        // Verificar si hay datos para insertar
        if (!empty($valores)) {
            // Construir la consulta SQL con múltiples filas
            $inserta = "INSERT INTO detalle_asistencia(id_asistencia, expediente_empleado, fecha_asistencia,
            hora_entrada, hora_salida, estatus, ultimo_movimiento, fecha_movimiento, usuario_movimiento) 
            VALUES " . implode(', ', $valores);

            // Ejecutar la consulta
            $respuesta_inserta = mysqli_query($conexion_database, $inserta);
            if ($respuesta_inserta === TRUE) {
              //  echo "Registros insertados correctamente<br>";
            } else {
              //  echo "Error al insertar los registros: " . $conexion_database->error . "<br>";
            }
        } else {
      //    echo "No hay datos para insertar<br>";
        }
        //mysqli_close($conexion_database);
    } else {
      //echo 'No se pudo abrir el archivo.';
    }
    $fecha_actual = new DateTime($fecha_inicio_quincena);
    $fecha_fin = new DateTime($fecha_fin_quincena);

    while ($fecha_actual <= $fecha_fin) {
        // Descartar domingos
        if ($fecha_actual->format('w') != 0) {
            $fechas_rango[] = $fecha_actual->format('Y-m-d');
        }

        $fecha_actual->modify('+1 day');
    }

    // Query para seleccionar las fechas y usuarios que ya tienen registros
    $selectQuery = "SELECT DISTINCT expediente_empleado, fecha_asistencia, id_asistencia FROM detalle_asistencia
                    WHERE fecha_asistencia BETWEEN '$fecha_inicio_quincena' AND '$fecha_fin_quincena'";

    // Ejecutar la consulta
    $resultado = mysqli_query($conexion_database, $selectQuery);

    if ($resultado) {
        // Obtener las fechas y usuarios que ya tienen registros
        $registros_existen = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $registros_existen[$fila['expediente_empleado']][] = $fila['fecha_asistencia'];
        }

        // Insertar registros con valores nulos para las fechas sin registros
        $valores_insert = [];
        foreach ($registros_existen as $expediente => $fechas_registradas) {
            $fechas_sin_registros = array_diff($fechas_rango, $fechas_registradas);

            foreach ($fechas_sin_registros as $fecha) {
                $valores_insert[] = "('$idasistencia', '$expediente', '$fecha', NULL, NULL, '$estatus', '$proceso', '$fecha_movimiento', '$usuario')";
            }
        }

        // Construir la consulta SQL con múltiples filas
        $insertQuery = "INSERT INTO detalle_asistencia(id_asistencia, expediente_empleado, fecha_asistencia,
                        hora_entrada, hora_salida, estatus, ultimo_movimiento, fecha_movimiento, usuario_movimiento) 
                        VALUES " . implode(', ', $valores_insert);

        // Ejecutar la consulta de inserción si hay datos para insertar
        if (!empty($valores_insert)) {
            $respuesta_inserta = mysqli_query($conexion_database, $insertQuery);

            if ($respuesta_inserta === TRUE) {
                //echo "Registros insertados correctamente<br>";
            } else {
                //echo "Error al insertar los registros: " . mysqli_error($conexion_database) . "<br>";
            }
        } else {
            //echo "No hay fechas sin registros para insertar<br>";
        }

        // Liberar el resultado
        mysqli_free_result($resultado);
    } else {
        // Manejar el error si la consulta no fue exitosa
        echo "Error en la consulta: " . mysqli_error($conexion_database);
    }

  }
  /**--------------------------------------------------------------- */
  /**Demo de lo que seria la tabla */
  $tabla = $tabla.'
    <ul class="nav nav-pills mb-3 justify-content-center" id="pills-detalle-asistencia" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="pills-administrativos-tab" data-bs-toggle="pill" data-bs-target="#pills-administrativos" type="button" role="tab" aria-controls="pills-administrativos" aria-selected="true">Administrativos</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="pills-docentes-tab" data-bs-toggle="pill" data-bs-target="#pills-docentes" type="button" role="tab" aria-controls="pills-docentes" aria-selected="false">Docentes</button>
      </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">';
      $consulta_admon="
        SELECT
          e.expediente,
          e.nombres,
          e.primerApellido,
          e.segundoApellido,
          e.hora_entrada,
          e.hora_salida,
          da.fecha_asistencia,
          da.id_asistencia,
          da.hora_entrada AS detalle_hora_entrada,
          da.hora_salida AS detalle_hora_salida,
          da.expediente_empleado,
          (
              SELECT TIME_FORMAT(SEC_TO_TIME(TIME_TO_SEC(e.hora_entrada) + (14 * 60 + 59)), '%H:%i:%s')
          ) AS hora_entrada_asistencia_sumada,
          (
              SELECT TIME_FORMAT(SEC_TO_TIME(TIME_TO_SEC(e.hora_entrada) + (29 * 60 + 59)), '%H:%i:%s')
          ) AS hora_entrada_retardo_sumada,
          CASE
              WHEN da.hora_entrada > (SELECT TIME_FORMAT(SEC_TO_TIME(TIME_TO_SEC(e.hora_entrada) + (14 * 60 + 59)), '%H:%i:%s'))
                  AND da.hora_entrada <= (SELECT TIME_FORMAT(SEC_TO_TIME(TIME_TO_SEC(e.hora_entrada) + (29 * 60 + 59)), '%H:%i:%s'))
                  AND da.hora_salida >= e.hora_salida THEN 'RETARDO'
              WHEN da.hora_entrada > (SELECT TIME_FORMAT(SEC_TO_TIME(TIME_TO_SEC(e.hora_entrada) + (29 * 60 + 59)), '%H:%i:%s'))
                  AND da.hora_salida >= e.hora_salida THEN 'FALTA'
              WHEN da.hora_entrada > (SELECT TIME_FORMAT(SEC_TO_TIME(TIME_TO_SEC(e.hora_entrada) + (29 * 60 + 59)), '%H:%i:%s'))
                  OR da.hora_salida < e.hora_salida THEN 'FALTA'
              WHEN da.hora_entrada IS NULL OR da.hora_salida IS NULL OR da.hora_entrada IS NULL AND da.hora_salida IS NULL THEN 'FALTA' 
              ELSE 'ASISTENCIA'
          END AS estado_asistencia
        FROM
          detalle_asistencia da
        JOIN
          empleados e ON da.expediente_empleado = e.expediente
        WHERE
          DAYOFWEEK(da.fecha_asistencia) != 1 AND DAYOFWEEK(da.fecha_asistencia) != 7 AND e.nivel_idNivelUsuario != 7 
          AND da.id_asistencia = '$idasistencia' AND (
              (
                  da.hora_entrada > (SELECT TIME_FORMAT(SEC_TO_TIME(TIME_TO_SEC(e.hora_entrada) + (14 * 60 + 59)), '%H:%i:%s'))
                  AND da.hora_entrada <= (SELECT TIME_FORMAT(SEC_TO_TIME(TIME_TO_SEC(e.hora_entrada) + (29 * 60 + 59)), '%H:%i:%s'))
                  AND da.hora_salida >= e.hora_salida
              ) OR (
                  da.hora_entrada > (SELECT TIME_FORMAT(SEC_TO_TIME(TIME_TO_SEC(e.hora_entrada) + (29 * 60 + 59)), '%H:%i:%s'))
                  AND da.hora_salida >= e.hora_salida
              ) OR (
                  da.hora_entrada > (SELECT TIME_FORMAT(SEC_TO_TIME(TIME_TO_SEC(e.hora_entrada) + (29 * 60 + 59)), '%H:%i:%s'))
                  OR da.hora_salida < e.hora_salida
              ) OR (
                da.hora_entrada IS NULL OR da.hora_salida IS NULL OR da.hora_entrada IS NULL AND da.hora_salida IS NULL
              )
          ) AND da.fecha_asistencia BETWEEN '$fecha_inicio_normal' AND '$fecha_fin_normal'
          AND NOT EXISTS (
              SELECT 1
              FROM incidencia i
              WHERE da.expediente_empleado = i.expediente
                  AND i.id_clave_mov IN (1, 2, 3, 4, 6, 8, 10, 11, 12, 13)
                  AND i.estatus = 1
                  AND da.fecha_asistencia BETWEEN i.fecha_inicio AND i.fecha_fin
          )
          AND NOT EXISTS (
            SELECT 1
            FROM dia_inhabil di
            WHERE da.fecha_asistencia = di.fecha_dia_inhabil
              AND di.estatus = 1   
          )
          AND NOT EXISTS(
              SELECT 1 
              FROM comision c
              WHERE da.expediente_empleado = c.id_empleado
              AND c.estatus = 1
              AND da.fecha_asistencia BETWEEN c.f_ini AND c.f_fin
            )
        ORDER BY
          da.expediente_empleado, da.fecha_asistencia
      ";
      $resultado_admon = mysqli_query($conexion_database, $consulta_admon);
      if (!$resultado_admon) {
        die("Error en la consulta: " . mysqli_error($conexion_database));
      }
      $no_filas = mysqli_num_rows($resultado_admon);
      $tabla = $tabla.'
      <div class="tab-pane fade show active" id="pills-administrativos" role="tabpanel" aria-labelledby="pills-administrativos-tab">
        <div class="container">
          <div class="table-responsive">
            <table class="table table-hover table-bordered">';
          if($no_filas > 0){
            $tabla = $tabla.'
              <thead>
                <tr>
                  <th>Empleado</th>
                  <th>Fecha</th>
                  <th>Estatus</th>
                </tr>
              </thead>
              <tbody>
            ';
            while($row = mysqli_fetch_array($resultado_admon)){
              $expediente = $row["expediente"];
              $apepat = $row["primerApellido"];
              $apemat = $row["segundoApellido"];
              $nombre = $row["nombres"];
              $fecha_asistencia = date("d-m-Y", strtotime($row["fecha_asistencia"]));
              $estado = $row["estado_asistencia"];
              $empleado = $expediente.' - '.$nombre.' '.$apepat.' '.$apemat;
              if($estado == 'RETARDO'){
                $estado_final='<span class="badge rounded-pill bg-warning text-white">RETARDO</span>';
              }elseif($estado == 'FALTA'){
                $estado_final='<span class="badge rounded-pill bg-danger">FALTA</span>';
              }
              $tabla = $tabla.'
                <tr>
                  <td>'.$empleado.'</td>
                  <td>'.$fecha_asistencia.'</td>
                  <td>'.$estado_final.'</td>
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
      </div>';
      mysqli_free_result($resultado_admon);
      //$consulta_docente_set = "SET lc_time_names = \'es_MX\';";
      $consulta_configuracion = "SET lc_time_names = 'es_MX';";
      mysqli_query($conexion_database, $consulta_configuracion);
      $consulta_docente ="
        SELECT
          da.expediente_empleado,
          da.fecha_asistencia,
          dc.clave_docente,
          e.primerApellido,
          e.segundoApellido,
          e.nombres, 
          CASE
            WHEN da.hora_entrada <= (
              SELECT TIME_FORMAT(
                SEC_TO_TIME(TIME_TO_SEC(MIN(dc.hora_entrada)) + (10 * 60 + 59)), '%H:%i:%s'
              )
            )
              AND da.hora_salida >= MAX(dc.hora_salida) THEN 'ASISTENCIA'
            WHEN da.hora_entrada > (
              SELECT TIME_FORMAT(
                SEC_TO_TIME(TIME_TO_SEC(MIN(dc.hora_entrada)) + (10 * 60 + 59)), '%H:%i:%s'
              )
            )
              AND da.hora_entrada <= (
                SELECT TIME_FORMAT(
                  SEC_TO_TIME(TIME_TO_SEC(MIN(dc.hora_entrada)) + (29 * 60 + 59)), '%H:%i:%s'
                )
              )
              AND da.hora_salida >= MAX(dc.hora_salida) THEN 'RETARDO'
            WHEN da.hora_entrada > (
              SELECT TIME_FORMAT(
                SEC_TO_TIME(TIME_TO_SEC(MIN(dc.hora_entrada)) + (29 * 60 + 59)), '%H:%i:%s'
              )
            )
              AND da.hora_salida >= MAX(dc.hora_salida) THEN 'FALTA'
            WHEN da.hora_entrada > (
              SELECT TIME_FORMAT(
                SEC_TO_TIME(TIME_TO_SEC(MIN(dc.hora_entrada)) + (29 * 60+ 59)), '%H:%i:%s'
              )
            )
              OR da.hora_salida < MAX(dc.hora_salida) THEN 'FALTA'
            WHEN da.hora_entrada IS NULL OR da.hora_salida IS NULL THEN 'FALTA'
            ELSE 'FALTA'
          END AS estado_asistencia
          FROM detalle_asistencia da 
          JOIN empleados e ON da.expediente_empleado = e.expediente
          JOIN detalle_carga dc ON dc.expediente_docente = da.expediente_empleado
          WHERE 
            e.estatus = 1 
            AND e.nivel_idNivelUsuario = 7 
            AND da.id_asistencia = '$idasistencia' 
            AND da.fecha_asistencia BETWEEN '$fecha_inicio_normal' AND '$fecha_fin_normal'
            AND UPPER(DATE_FORMAT(STR_TO_DATE(da.fecha_asistencia, '%Y-%m-%d'), '%W')) = dc.dia
            AND NOT EXISTS (
              SELECT 1
              FROM incidencia i
              WHERE da.expediente_empleado = i.expediente
                  AND i.id_clave_mov IN (1, 2, 3, 4, 6, 8, 10, 11, 12, 13)
                  AND i.estatus = 1
                  AND da.fecha_asistencia BETWEEN i.fecha_inicio AND i.fecha_fin
            )
            AND NOT EXISTS (
              SELECT 1
              FROM dia_inhabil di
              WHERE da.fecha_asistencia = di.fecha_dia_inhabil
                AND di.estatus = 1   
            )
            AND NOT EXISTS(
              SELECT 1 
              FROM comision c
              WHERE da.expediente_empleado = c.id_empleado
              AND c.estatus = 1
              AND da.fecha_asistencia BETWEEN c.f_ini AND c.f_fin
            )
          GROUP BY
            da.expediente_empleado, da.fecha_asistencia, dc.clave_docente
          HAVING
            MIN(dc.hora_entrada) IS NOT NULL
            AND MAX(dc.hora_salida) IS NOT NULL
            AND estado_asistencia IN ('RETARDO', 'FALTA')
          ORDER BY
            da.expediente_empleado, da.fecha_asistencia
        ";
      //mysqli_query($conexion_database, $consulta_docente_set);
      $resultado_docente = mysqli_query($conexion_database, $consulta_docente);
      if(!$resultado_docente){
        die("Error en la consulta: " . mysqli_error($conexion_database));
      }
      $no_filas_docente = mysqli_num_rows($resultado_docente); 
      $tabla = $tabla.'
      <div class="tab-pane fade" id="pills-docentes" role="tabpanel" aria-labelledby="pills-docentes-tab">
        <div class="container">
          <div class="table-responsive">
            <table class="table table-hover table-bordered">';
            if($no_filas_docente > 0){
            $tabla = $tabla.'
              <thead>
                <tr>
                  <th>Empleado</th>
                  <th>Clave Docente</th>
                  <th>Fecha</th>
                  <th>Estatus</th>
                </tr>
              </thead>
              <tbody>
            ';
            while($row = mysqli_fetch_array($resultado_docente)){
              $expediente = $row["expediente_empleado"];
              $apepat = $row["primerApellido"];
              $apemat = $row["segundoApellido"];
              $nombre = $row["nombres"];
              $fecha_asistencia = date("d-m-Y", strtotime($row["fecha_asistencia"]));
              $clave_docente = $row["clave_docente"];
              $estado = $row["estado_asistencia"];
              $empleado = $expediente.' - '.$nombre.' '.$apepat.' '.$apemat;
              if($estado == 'RETARDO'){
                $estado_final='<span class="badge rounded-pill bg-warning text-white">RETARDO</span>';
              }elseif($estado == 'FALTA'){
                $estado_final='<span class="badge rounded-pill bg-danger">FALTA</span>';
              }
              $tabla = $tabla.'
                <tr>
                  <td>'.$empleado.'</td>
                  <td>'.$clave_docente.'</td>
                  <td>'.$fecha_asistencia.'</td>
                  <td>'.$estado_final.'</td>
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
            mysqli_free_result($resultado_docente);
      $tabla = $tabla.'
            </table>
          </div>
        </div>
      </div>
    </div>
  ';
  /**----------------------------- */
  $array = array(
      0 => $detalle_quincena,
      1 => $tabla,
      2 => $idasistencia        
  );
  echo json_encode($array);
  mysqli_close($conexion_database);
?>