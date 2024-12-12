<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");
    date_default_timezone_set('America/Mexico_City');
    $fecha_movimiento = date('Y-m-d');
    $usuario = $id_software_sesion;
    $id_pago = $_POST["idpago"];
    $estatus = 1;
    $proceso = "Registro";
    /**Consultamos la BD del pago para mostrar la info----------- */
    $consulta_d = "SELECT id_pago, poliza, fecha_pago, monto_total, concepto, folio_fiscal FROM pagos WHERE id_pago = '$id_pago' LIMIT 1";
    $resultado_d = mysqli_query($conexion_database, $consulta_d);

    while($row = mysqli_fetch_array($resultado_d)){
        $id_pago_d = $row["id_pago"];
        $poliza = $row["poliza"];
        $fecha_pago = date("d-m-Y", strtotime($row["fecha_pago"]));
        $monto_total = number_format($row["monto_total"], 2, '.', ',');
        $concepto = $row["concepto"];
        $folio_fiscal = $row["folio_fiscal"];
    }
    //echo $id_pago_d.' '.$poliza.' '.$fecha_pago.' '.$monto_total.' '.$concepto.' '.$folio;
    mysqli_free_result($resultado_d);
    /**---------------------------------------------------------- */
    /**Agregamos una funcion para limitar el numero de caracteres el maximo es de 150 */
    /*function limitar_cadena($concepto, $limite = 60, $sufijo = '...'){
        //verifica si la longitud de la cadena es mayor que el límite
        if(strlen($concepto) > $limite){
            //si es mayor, recorta la cadena y añade el sufijo
            return substr($concepto, 0, $limite) . $sufijo;
        }
        //si a cadena es mejor que el límite, se devuelve tal cual
        return $concepto;
    }
    $concepto = limitar_cadena($concepto);
    /**------------------------------------------------------------------------------ */
    $datos_pago='';
    if($folio_fiscal == ''){
        $folio = 'No tiene Datos';
    }else{
        $folio = $folio_fiscal;
    }
    /**Mostrar datos del pago en pantalla------------------------ */
    $datos_pago = $datos_pago.'
        <div class="col d-flex align-items-center">
            <p class="datos_detalle_pago">Poliza: <span id="poliza_pago"> '.$poliza.' </span></p>
        </div>
        <div class="col d-flex align-items-center">
            <p class="datos_detalle_pago">Fecha de Pago: <span id="fecha_pago"> '.$fecha_pago.' </span></p>
        </div>
        <div class="col d-flex align-items-center">
            <p class="datos_detalle_pago">Folio Fiscal: <span id="folio_fiscal_pago">'.$folio.' </span></p>
        </div>
        <div class="col d-flex align-items-center">
            <p class="datos_detalle_pago">Concepto: <span id="concepto_pago">'.$concepto.' </span></p>
        </div>
    ';
    /**---------------------------------------------------------- */
    $array = array(
        0 => $datos_pago,
        2 => $id_pago_d
    );
    echo json_encode($array);
    mysqli_close($conexion_database);
?>