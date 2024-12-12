<?php

require("../conexion/conexion_bd.php");
/*$sql = "
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
        da.expediente_empleado
    FROM
        detalle_asistencia da
    JOIN
        empleados e ON da.expediente_empleado = e.expediente
    WHERE
        DAYOFWEEK(da.fecha_asistencia) != 1 AND DAYOFWEEK(da.fecha_asistencia) != 7 AND e.nivel_idNivelUsuario != 7
";


$result = mysqli_query($conexion_database, $sql);

// Estructura de datos para almacenar la información organizada
$asistencias = array();

// Procesar los resultados y organizar la información
while ($row = $result->fetch_assoc()) {
    $expediente = $row['expediente_empleado'];
    $nom = $row['nombres'];
    $apepat = $row["primerApellido"];
    $apemat = $row["segundoApellido"];
    $fecha = date("d-m-Y", strtotime($row['fecha_asistencia']));
    $detalle_hora_entrada = $row["detalle_hora_entrada"];
    $detalle_hora_salida = $row["detalle_hora_salida"];
    $admon_hora_entrada = $row["hora_entrada"];
    $admon_hora_salida = $row["hora_salida"];
    $id_asistencia = $row['id_asistencia'];
    $nombre = $nom.' '.$apepat.' '.$apemat;

    // Organizar la información en la estructura de datos
    $asistencias[$expediente][$nombre][$fecha]['id_asistencia'] = $id_asistencia;
    $asistencias[$expediente][$nombre][$fecha]['detalle_hora_entrada'] = $detalle_hora_entrada;
    $asistencias[$expediente][$nombre][$fecha]['detalle_hora_salida'] = $detalle_hora_salida;
}


// Imprimir la tabla
echo '<table border="1">';
echo '<tr><th>Empleado</th>';

// Obtener todas las fechas únicas
$fechasUnicas = array();
foreach ($asistencias as $expedienteData) {
    foreach ($expedienteData as $nombreData) {
        $fechasUnicas = array_merge($fechasUnicas, array_keys($nombreData));
    }
}
$fechasUnicas = array_unique($fechasUnicas);

// Imprimir encabezados de fechas
foreach ($fechasUnicas as $fechaUnica) {
    echo '<th>' . $fechaUnica . '</th>';
}
echo '</tr>';
// Imprimir filas con datos
foreach ($asistencias as $expediente => $expedienteData) {
    foreach ($expedienteData as $nombre => $fechasData) {
        echo '<tr><td>' . $expediente . ' ' . $nombre . '</td>';

        // Imprimir datos de asistencia para cada fecha
        foreach ($fechasUnicas as $fechaUnica) {
            $id_asistencia = isset($fechasData[$fechaUnica]['id_asistencia']) ? $fechasData[$fechaUnica]['id_asistencia'] : '';
            $detalle_hora_entrada = isset($fechasData[$fechaUnica]['detalle_hora_entrada']) ? $fechasData[$fechaUnica]['detalle_hora_entrada'] : '';
            $detalle_hora_salida = isset($fechasData[$fechaUnica]['detalle_hora_salida']) ? $fechasData[$fechaUnica]['detalle_hora_salida'] : '';

            // Verificar si la cadena es válida antes de crear objetos DateTime
            $dateTimeEntrada = DateTime::createFromFormat('H:i:s', $detalle_hora_entrada);
            $dateTimeEntradaMaximoAsistencia = DateTime::createFromFormat('H:i:s', $detalle_hora_entrada);
            $dateTimeEntradaRetardo = DateTime::createFromFormat('H:i:s', $detalle_hora_entrada);

            if ($dateTimeEntrada === false || $dateTimeEntradaRetardo === false || $dateTimeEntradaMaximoAsistencia === false) {
                echo '<td>Error en formato de hora: ' . $detalle_hora_entrada . '</td>';
            } else {
                $dateTimeEntradaMaximoAsistencia->add(new DateInterval('PT14M59S'));
                $dateTimeEntradaRetardo->add(new DateInterval('PT29M59S'));

                // Lógica para determinar asistencia, retardo o falta
                if ($detalle_hora_entrada <= $dateTimeEntradaMaximoAsistencia->format('H:i:s') && $detalle_hora_salida >= $admon_hora_salida) {
                    echo '<td> Asistencia </td>';
                } elseif ($detalle_hora_entrada > $dateTimeEntradaMaximoAsistencia->format('H:i:s') && $detalle_hora_entrada <= $dateTimeEntradaRetardo->format('H:i:s') && $detalle_hora_salida >= $admon_hora_salida) {
                    echo '<td> Retardo </td>';
                } elseif ($detalle_hora_entrada > $dateTimeEntradaRetardo->format('H:i:s') || $detalle_hora_salida < $admon_hora_salida) {
                    echo '<td> Falta </td>';
                } else {
                    echo '<td></td>'; // No hay registro de asistencia para esta fecha
                }
            }
        }

        echo '</tr>';
    }
}*/

// Supongamos que ya tienes las variables $conexion_database, $fecha_inicio_quincena y $fecha_fin_quincena definidas

// Crear un array con todas las fechas en el rango
$fechas_rango = [];
$fecha_inicio_quincena = '2023-10-16';
$fecha_fin_quincena = '2023-10-31';
$proceso = 'Registro';
$fecha_movimiento = '2023-12-06';
$usuario = '200071';
$estatus = '1';

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
        $idasistencia = $fila["id_asistencia"];
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
            echo "Registros insertados correctamente<br>";
        } else {
            echo "Error al insertar los registros: " . mysqli_error($conexion_database) . "<br>";
        }
    } else {
        echo "No hay fechas sin registros para insertar<br>";
    }

    // Liberar el resultado
    mysqli_free_result($resultado);
} else {
    // Manejar el error si la consulta no fue exitosa
    echo "Error en la consulta: " . mysqli_error($conexion_database);
}

// Cerrar la conexión
mysqli_close($conexion_database);

?>