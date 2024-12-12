<?php
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");

    //Obtener los valores desde el post
    $inicial = $_POST["inicio"];
    $fin = $_POST["fin"];

    //Validar si los valores son numericos
    $inicial = is_numeric($inicial) ? $inicial : 0;
    $inf = is_numeric($fin) ? $fin : 0;
    
    //Calcular los kilometros recorridos
    $total = $fin - $inicial;

    $totalFormateado = number_format($total, 2, '.', '');

    $array = array(
        0 => $totalFormateado
    );

    echo json_encode($array);
?>