<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");
    $id_pago_padre = $_POST["id_pago"];
    $nuevo_estado = $_POST["nuevoEstado"];
    date_default_timezone_set('America/Mexico_City');
    $fecha = date('Y-m-d');
    $usuario = $id_software_sesion;
    $proceso = "Registro";
    $estatus = 1;
    $comprobacion = "0";
    //Realizamos una consulta para obtener el monto total del pago y que en los detalles no se pase si no genera incongruencia
    $consulta_monto = "SELECT monto_total FROM pagos WHERE id_pago = '$id_pago_padre' AND estatus = '1' LIMIT 1";
    $resultado_monto = mysqli_query($conexion_database, $consulta_monto);
    while($row_monto = mysqli_fetch_array($resultado_monto)){
        $monto_total_pago = $row_monto["monto_total"];
    }
    mysqli_free_result($resultado_monto);
    /**---------------------------------------------------------------------------------------------------------------------- */
    /**-----Verificamos si existen los detalle_pagos de P.E. y en caso de que si los eliminamos------------------- */
    if($nuevo_estado == 1){
        $elimina_pe = "DELETE FROM detalle_pagos WHERE pagos_id_pago = '$id_pago_padre'";
        $resultado_elimina_pre=mysqli_query($conexion_database, $elimina_pe);

        $actualiza_check = "UPDATE pagos SET estado_checkbox = 0, fecha_movimiento = '$fecha', usuario_movimiento = '$usuario', ultimo_movimiento = '$proceso' WHERE id_pago = '$id_pago_padre' AND estatus = '1' LIMIT 1";
        $realiza = mysqli_query($conexion_database, $actualiza_check);
        if(!$resultado_elimina_pre && !$realiza){
            echo "Error ". mysqli_error($conexion_database);
            $comprobacion = "1";
        }
    }else{
        $consulta_detalle = "SELECT id_detalle_pago FROM detalle_pagos WHERE pagos_id_pago = '$id_pago_padre'";
        $resultado = mysqli_query($conexion_database, $consulta_detalle);
        $row_verifica = mysqli_fetch_row($resultado);
        if(!$row_verifica){
            //echo "Se activo el check";
            //**Sacamos los valores de la estructura organica para todos los PE */
            $estructuras = [
                'eo_bio' => 11201,
                'eo_electro' => 11202,
                'eo_gastro' => 11203,
                'eo_sis' => 11204,
                'eo_ind' => 11205,
                'eo_meca' => 11206
            ];
            
            $porcentajes = [
                11, //bio
                11, //Electro
                23, //gastro
                14, //sistemas
                23, //industrial
                18 //mecatronica
            ]; // uno por cada estructura
            //Array para almacenar la consulta
            $values = [];

            //nos aseguramos de que la cuenta de $estructuras y $porcentajes sea la misma
            if(count($estructuras) === count($porcentajes)){
                //usamos el indice de cada elemento para emparejar estrucutra y porcentaje
                foreach(array_keys($estructuras) as $index => $key){
                    $estructura_organica = $estructuras[$key];
                    $porcentaje = $porcentajes[$index];
                    $monto_detalle_pago = $monto_total_pago * ($porcentaje / 100);

                    //Añadimos cada registro con los valores necesarios al array $values[]
                    $values[] = "('$id_pago_padre', '$estructura_organica', '$monto_detalle_pago', '$estatus', '$fecha', '$proceso', '$usuario')";
                }
                //unimos todos los valores en una sola cadena para la consulta
                $values_string =implode(",", $values);
                //$construimos la consulta de insercion multiple
                $registra_pe = "INSERT INTO detalle_pagos(pagos_id_pago, unidad_clave_unidad, monto_detalle_pago, estatus, fecha_movimiento, ultimo_movimiento, usuario_movimiento)VALUES $values_string";
                //echo $registra_pe;
                $inserta = mysqli_query($conexion_database, $registra_pe);
                if(!$inserta){
                    mysqli_error($conexion_database);
                }
                $actualiza_check = "UPDATE pagos SET estado_checkbox = 1, fecha_movimiento = '$fecha', usuario_movimiento = '$usuario', ultimo_movimiento = '$proceso' WHERE id_pago = '$id_pago_padre' AND estatus = '1' LIMIT 1";
                $realiza = mysqli_query($conexion_database, $actualiza_check);
            }else{
                echo "Error: los arreglos de estructuras y porcentajes no tienen la misma longitud";
            }
        }else{
            $comprobacion ="1";
        }
    }
    /**----------------------------------------------------------------------------------------------------------- */
    $array = array(
        0 => $comprobacion
    );
    echo json_encode($array);
    mysqli_close($conexion_database);
?>