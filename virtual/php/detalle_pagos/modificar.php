<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    $id = $_POST["id"];
    /**Consultamos la base de datos para obtener los valores de la incidencia */
    $consulta = "SELECT id_detalle_pago, unidad_clave_unidad, monto_detalle_pago, pagos_id_pago FROM detalle_pagos WHERE id_detalle_pago = '$id' LIMIT 1";
    $resultado = mysqli_query($conexion_database, $consulta);
    $datos = array();
    while($row = mysqli_fetch_array($resultado)){
        $id_detalle = $row["id_detalle_pago"];
        $departamento = $row["unidad_clave_unidad"];
        $monto_pago = $row["monto_detalle_pago"];
        $id_pago_padre = $row["pagos_id_pago"];
    }
    $datos = array(
        0 => $id_detalle,
        1 => $departamento,
        2 => $monto_pago,
        3 => $id_pago_padre
    );
    /**---------------------------------------------------------------------- */
    echo json_encode($datos);

    mysqli_free_result($resultado);
    mysqli_close($conexion_database);
?>