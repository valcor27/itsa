<?php
require("../conexion/conexion_bd.php");
require("../sesion/logueo.php");
require("../clases/limpiar.php");
date_default_timezone_set('America/Mexico_City');
$fecha = date('Y-m-d');
$usuario = $id_software_sesion;
$proceso = "Registro";

$docente_iddocente = $_POST["iddocente"];
$estatus = 1;

$detalle_docente = '';
$tabla = '';

/**consultamos la base de datos completa-------------------------------------------------------------------- */
$consulta_u = "SELECT empleados_expediente, clave, nombre_docente FROM docentes WHERE id_docentes = ? LIMIT 1";
$stmt_u = mysqli_prepare($conexion_database, $consulta_u);
mysqli_stmt_bind_param($stmt_u, "i", $docente_iddocente);
mysqli_stmt_execute($stmt_u);
mysqli_stmt_bind_result($stmt_u, $expediente, $clave, $nombre_docente);
mysqli_stmt_fetch($stmt_u);

$nombre_docente = sanear_string($nombre_docente);

mysqli_stmt_close($stmt_u);
/**--------------------------------------------------------------------------------------------------------- */

/**-----------Corroboramos que no exista la carga----------------------------------------------------------- */
$consulta_comparar = "SELECT idcarga FROM carga WHERE docente_iddocente = ? AND estatus = '1' LIMIT 1";
$stmt_comparar = mysqli_prepare($conexion_database, $consulta_comparar);
mysqli_stmt_bind_param($stmt_comparar, "i", $docente_iddocente);
mysqli_stmt_execute($stmt_comparar);
mysqli_stmt_store_result($stmt_comparar);

$filas_comparar = mysqli_stmt_num_rows($stmt_comparar);

mysqli_stmt_close($stmt_comparar);
/**--------------------------------------------------------------------------------------------------------- */

/**----------Insertamos registros si no hay datos duplicados------------------------------------------------ */
if ($filas_comparar == 0) {
    $inserta = "INSERT INTO carga(docente_iddocente, fecha_movimiento, ultimo_movimiento, usuario_movimiento, nombre_docente, estatus) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_inserta = mysqli_prepare($conexion_database, $inserta);
    mysqli_stmt_bind_param($stmt_inserta, "issssi", $docente_iddocente, $fecha, $proceso, $usuario, $nombre_docente, $estatus);
    mysqli_stmt_execute($stmt_inserta);
    mysqli_stmt_close($stmt_inserta);
}
/**--------------------------------------------------------------------------------------------------------- */

/**-------Mostrar datos del docente en pantalla------------------------------------------------------------- */
$detalle_docente = $detalle_docente . '
    <div class="col-auto">
        <p class="datos_docente">Nombre: <span id="nombre_docente"> ' . $nombre_docente . ' </span></p>
    </div>
    <div class="col-auto">
        <p class="datos_docente">Expediente: <span id="expediente_doc"> ' . $expediente . ' </span></p>
    </div>
    <div class="col-auto">
        <p class="datos_docente">Clave: <span id="clave_doc"> ' . $clave . ' </span></p>
    </div>
';
/**--------------------------------------------------------------------------------------------------------- */
/**Consultamos la base de datos para obtener id de carga de docente----------------------------------------- */
$consulta_c = "SELECT idcarga FROM carga WHERE docente_iddocente = ? AND estatus = '1' LIMIT 1";
$stmt_c = mysqli_prepare($conexion_database, $consulta_c);
mysqli_stmt_bind_param($stmt_c, "i", $docente_iddocente);
mysqli_stmt_execute($stmt_c);
mysqli_stmt_bind_result($stmt_c, $idcarga);
mysqli_stmt_fetch($stmt_c);
mysqli_stmt_close($stmt_c);

// Inicializar un array para almacenar las consultas y resultados
$consultas = array();
$resultados = array();
$horas = array(
    '07:00', '08:00', '09:00', '10:00', '11:00',
    '12:00', '13:00', '14:00', '15:00', '16:00',
    '17:00', '18:00', '19:00', '20:00'
);

// Convierte el array de horas en una cadena SQL para usar en la consulta
$horas_sql = "'" . implode("', '", $horas) . "'";

$consulta_1 = "
    SELECT 
        'Diferencias_new',
        t1.idaux,
        t1.dia_aux,
        t1.punto_aux, 
        t1.etiqueta_aux,
        t1.columna_aux,
        t1.estatus_aux
    FROM aux t1
    WHERE 
        t1.hora_entrada_aux IN ($horas_sql) AND
        t1.punto_aux NOT IN (SELECT t2.punto FROM detalle_carga t2 WHERE t1.punto_aux=t2.punto AND t2.carga_idcarga='$idcarga')
    UNION ALL
    SELECT 'Coincidencias', t1.iddetalle_carga, t1.dia, t1.punto, t1.etiqueta as x, t1.columna, t1.estatus
    FROM detalle_carga t1
    WHERE t1.hora_entrada IN ($horas_sql) AND t1.carga_idcarga='$idcarga' AND t1.punto NOT IN (SELECT t2.punto_aux FROM aux t2 WHERE t1.punto<>t2.punto_aux AND t1.carga_idcarga = '$idcarga')
    ORDER BY columna_aux ASC;
";


// Ahora $resultados contiene los resultados agrupados por hora de entrada
// Ahora $matriz contiene la información que necesitas

// Para generar la tabla HTML a partir de la matriz, puedes recorrerla y construir la tabla
$tabla = '<div class="table-responsive">';
$tabla .= '<table id="mi-tabla" class="table table-bordered table-list table-hover table_modulos">';
$tabla .= '<thead><th></th><th>LUNES</th><th>MARTES</th><th>MIÉRCOLES</th><th>JUEVES</th><th>VIERNES</th><th>SÁBADO</th></thead>';
$tabla .= '<tbody>';

foreach ($matriz as $hora => $tipos) {
    $tabla .= '<tr id="' . $hora . '">';
    $tabla .= '<th>' . $hora . '</th>';

    foreach ($tipos as $tipo => $elementos) {
        foreach ($elementos as $elemento) {
            $id = $elemento['id'];
            $punto = $elemento['punto'];
            $etiqueta = $elemento['etiqueta'];
            $estatus = $elemento['estatus'];

            $procesoHTML = '';

            if ($estatus == "0") {
                $procesoHTML = '<td align="center" id="' . $punto . '" onclick="Modal_carga_materia(this);">';
                $procesoHTML .= '<i class="fa-regular fa-file-lines ic_materia"></i>';
                $procesoHTML .= '<div class="l_materia_vacio">' . $etiqueta . '</div>';
                $procesoHTML .= '</td>';
            } else {
                $procesoHTML = '<td align="center" id="' . $punto . '" onclick="Modificar_carga_materia(' . $id . ');">';
                $procesoHTML .= '<i class="fa-regular fa-file-lines ic_materia"></i>';
                $procesoHTML .= '<div class="l_materia">' . $etiqueta . '</div>';
                $procesoHTML .= '</td>';
            }

            $tabla .= $procesoHTML;
        }
    }

    $tabla .= '</tr>';
}

$tabla .= '</tbody></table></div>';

// Otros procesos aquí...
// Enviar la tabla HTML generada y otros datos en formato JSON
$array = array(
    0 => $detalle_docente,
    1 => $tabla,
    2 => $clave,
    3 => $idcarga
);

echo json_encode($array);
// Cerrar la conexión y liberar los resultados
mysqli_free_result($resultado);
mysqli_close($conexion_database);
?>
