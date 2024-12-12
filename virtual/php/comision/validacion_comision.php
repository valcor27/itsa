<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");
    $datos = array();
    $fincio = $_POST["finicio"];
    $ffin = $_POST["ffin"];
    $hini = $_POST["hini"];
    $hfin = $_POST["hfin"];
    $empleado = $_POST["empleado"];
    $duracion = '';

    /** Realizamos las operaciones necesarias para obtener la duracion de la comision */
        // Cambiamos el formato de fecha al formato aceptado por DateTime
        $fincio = DateTime::createFromFormat('d-m-Y H:i', $fincio . ' ' . $hini);
        $ffin = DateTime::createFromFormat('d-m-Y H:i', $ffin . ' ' . $hfin);

        // Se calcula la diferencia en días, horas y minutos
        $diferenciaTotal = $ffin->diff($fincio);

        // Convertimos los días en meses y días
        $diasTotales = $diferenciaTotal->days;
        $meses = floor($diasTotales / 30);
        $diasRestantes = $diasTotales % 30;

        // Formateamos la salida según la diferencia
        if ($meses > 0) {
            $duracion .= $meses . ' Mes(es) ';
        }

        if ($diasRestantes > 0) {
            $duracion .= $diasRestantes . ' Día(s)';
        }

        if ($diferenciaTotal->h > 0) {
            $duracion .= ($duracion !== '' ? ' y ' : '') . $diferenciaTotal->h . ' Hora(s)';
        }

        if ($diferenciaTotal->i > 0) {
            $duracion .= ($duracion !== '' ? ' y ' : '') . $diferenciaTotal->i . ' Minuto(s)';
        }

    /** -------------------------------------------------------------------------- */
    $datos = array(
        0 => $duracion
    );
    echo json_encode($datos);
    mysqli_close($conexion_database);
?>
