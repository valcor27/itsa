<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");
    $proceso = $_POST["proceso_detalle_pago"];
    $id = $_POST["id_detalle_pago"];
    $monto_detalle = $_POST["monto_detalle_pago"];
    $id_pago_padre = $_POST["id_pago_padre"];
    $departamento = $_POST["id_departamentos"];
    $estatus = 1;
    $comprobacion = "0";
    $usuario = $id_software_sesion;
    date_default_timezone_set('America/Mexico_City');
    $fecha = date('Y-m-d');
    //Realizamos una consulta para obtener el monto total del pago y que en los detalles no se pase si no genera incongruencia
    $consulta_monto = "SELECT monto_total FROM pagos WHERE id_pago = '$id_pago_padre' AND estatus = '1' LIMIT 1";
    $resultado_monto = mysqli_query($conexion_database, $consulta_monto);
    while($row_monto = mysqli_fetch_array($resultado_monto)){
        $monto_total_pago = $row_monto["monto_total"];
    }
    mysqli_free_result($resultado_monto);
    switch($proceso){
        case 'Registro':
            /**Corroboramos que no sea mas grande la suma de los montos de los detalles a la del monto total del pago */
            $consulta_comprobacion = "SELECT IFNULL(SUM(monto_detalle_pago), 0) AS total_detalle_monto FROM detalle_pagos WHERE pagos_id_pago = '$id_pago_padre' AND estatus = '1'";
            $resultado_comprobacion = mysqli_query($conexion_database, $consulta_comprobacion);
            // Validamos si se obtuvo un resultado
            if($row_comprobacion = mysqli_fetch_array($resultado_comprobacion)){
                $total_monto_detalle_base = $row_comprobacion["total_detalle_monto"];
            } else {
                $total_monto_detalle_base = 0; // Por si acaso no hay resultados
            }
            mysqli_free_result($resultado_comprobacion);
            $monto_comprobacion = $total_monto_detalle_base + $monto_detalle;             
            /**--------------------------------------------------------------------------------------- */
            if($monto_comprobacion <= $monto_total_pago){
                //Si el monto almacenado en los detalles es mas chico o igual que el monto total del pago lo almacenara
                $inserta = "INSERT INTO detalle_pagos(pagos_id_pago, unidad_clave_unidad, monto_detalle_pago, estatus, fecha_movimiento, ultimo_movimiento, usuario_movimiento)VALUES('$id_pago_padre', '$departamento', '$monto_detalle', '$estatus', '$fecha', '$proceso', '$usuario')";
                $respuesta = mysqli_query($conexion_database, $inserta);
                /*------------------------------------------------------------------------------------------------------*/
            }else{
                //si es mayor el monto de detalle y el que se quiere almacenar marcara error porque eso no puede ser es incongruente
                $comprobacion = "1";
            }
        break;
        case 'Edicion':
            /**Corroboramos que no sea mas grande la suma de los montos de los detalles a la del monto total del pago */
            $consulta_comprobacion = "SELECT IFNULL(SUM(monto_detalle_pago), 0) AS total_detalle_monto FROM detalle_pagos WHERE pagos_id_pago = '$id_pago_padre' AND estatus = '1'";
            $resultado_comprobacion = mysqli_query($conexion_database, $consulta_comprobacion);
            // Validamos si se obtuvo un resultado
            if($row_comprobacion = mysqli_fetch_array($resultado_comprobacion)){
                $total_monto_detalle_base = $row_comprobacion["total_detalle_monto"];
            } else {
                $total_monto_detalle_base = 0; // Por si acaso no hay resultados
            }
            mysqli_free_result($resultado_comprobacion);
            $monto_comprobacion = $total_monto_detalle_base + $monto_detalle;
            if($monto_comprobacion <= $monto_total_pago){
                $actualiza = "UPDATE detalle_pagos SET unidad_clave_unidad = '$departamento', monto_detalle_pago = '$monto_detalle', fecha_movimiento = '$fecha', ultimo_movimiento = '$proceso', usuario_movimiento = '$usuario' WHERE id_detalle_pago = '$id' AND estatus = '1' LIMIT 1";
                $respuesta = mysqli_query($conexion_database, $actualiza);
            }else{
                $comprobacion = "1";
            }
        break;
    }
    $array = array(
        0 => $comprobacion
    );
    echo json_encode($array);
    mysqli_close($conexion_database);
?>