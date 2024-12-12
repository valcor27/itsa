<?php
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");

    // Obtener los valores desde el POST
    $viatico = $_POST["viatico"];
    $combustible = $_POST["combustible"];
    $casetas = $_POST["casetas"];
    $otros = $_POST["otros"];

    // Validar si los valores son numéricos
    $viatico = is_numeric($viatico) ? $viatico : 0;
    $combustible = is_numeric($combustible) ? $combustible : 0;
    $casetas = is_numeric($casetas) ? $casetas : 0;
    $otros = is_numeric($otros) ? $otros : 0;

    // Calcular el total
    $total = $viatico + $combustible + $casetas + $otros;

    // Formatear el total con dos decimales
    $totalFormateado = number_format($total, 2, '.', '');

    // Crear el array de respuesta
    $array = array(
        0 => $totalFormateado
    );

    // Enviar la respuesta JSON
    echo json_encode($array);
?>
