<?php
require("../conexion/conexion_bd.php");
require("../sesion/logueo.php");
require("../clases/limpiar.php");
$proceso = $_POST["proceso_comision_pv"];
$id = $_POST["id_comision_pv"];
$id_comision = $_POST["comision_id_comision_pv"];
$fecha_inicio = $_POST["f_ini_pv"];
$fecha_fin = $_POST["f_fin_pv"];
$hora_inicio = $_POST["h_ini_pv"];
$hora_fin = $_POST["h_fin_pv"];
$tipo_vehiculo = $_POST["tipo_vehiculo"];
$especificar = isset($_POST["especificar_vehiculo"]) ? $_POST["especificar_vehiculo"] : null;
$id_vehiculo = isset($_POST["vehiculo_comision"]) ? $_POST["vehiculo_comision"] : null;
$km_inicial = isset($_POST["km_inicial"]) ? $_POST["km_inicial"] : null;
$placas = isset($_POST["placas"]) ? $_POST["placas"] : null;
$estatus = 1;
$comprobacion = "0";
date_default_timezone_set('America/Mexico_City');
$fecha = date("Y-m-d");
$usuario = $id_software_sesion;

switch ($proceso) {
    case 'Registro':
        if ($tipo_vehiculo == 1) {
            $especificar = null;
            $id_vehiculo = null;
            $km_inicial = null;
            $inserta = "INSERT INTO parque_comision(comision_id_comision, tipo_vehiculo, especificar, vehiculo_id_vehiculo, 
                km_inicial, estatus, fecha_movimiento, ultimo_movimiento, usuario_movimiento) VALUES('$id_comision', '$tipo_vehiculo', 
                '$especificar', '$id_vehiculo', '$km_inicial', '$estatus', '$fecha', '$proceso', '$usuario')";
            $respuesta = mysqli_query($conexion_database, $inserta);
        } else if ($tipo_vehiculo == 2) {
            $especificar = null;
            /**Corroboramos que no se duplique el auto para otra comision en la misma hora y fecha */
            $consulta_comparar = "SELECT vehiculo_id_vehiculo FROM parque_comision pc
                INNER JOIN comision c ON pc.comision_id_comision = c.id_comision
                WHERE pc.vehiculo_id_vehiculo = '$id_vehiculo'
                AND (
                    ('$fecha_inicio $hora_inicio' BETWEEN CONCAT(c.f_ini, ' ', c.h_ini) AND CONCAT(c.f_fin, ' ', c.h_fin))
                    OR ('$fecha_fin $hora_fin' BETWEEN CONCAT(c.f_ini, ' ', c.h_ini) AND CONCAT(c.f_fin, ' ', c.h_fin))
                    OR (CONCAT(c.f_ini, ' ', c.h_ini) BETWEEN '$fecha_inicio $hora_inicio' AND '$fecha_fin $hora_fin')
                    OR (CONCAT(c.f_fin, ' ', c.h_fin) BETWEEN '$fecha_inicio $hora_inicio' AND '$fecha_fin $hora_fin')
                )
                AND c.estatus = '1' AND pc.estatus = '1'";
            //echo $consulta_comparar;
            $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
            $filas_comparar = mysqli_num_rows($resultado_comparar);
            mysqli_free_result($resultado_comparar);
            /**---------------------------------------------------------------------------------- */
            if ($filas_comparar == 0) {
                $inserta = "INSERT INTO parque_comision(comision_id_comision, tipo_vehiculo, especificar, vehiculo_id_vehiculo, 
                km_inicial, estatus, fecha_movimiento, ultimo_movimiento, usuario_movimiento) VALUES('$id_comision', '$tipo_vehiculo', 
                '$especificar', '$id_vehiculo', '$km_inicial', '$estatus', '$fecha', '$proceso', '$usuario')";
                $respuesta = mysqli_query($conexion_database, $inserta);
            } else {
                $comprobacion = "1";
            }
        } else if ($tipo_vehiculo == 3) {
            $id_vehiculo = null;
            $km_inicial = null;
            $inserta = "INSERT INTO parque_comision(comision_id_comision, tipo_vehiculo, especificar, vehiculo_id_vehiculo, 
                km_inicial, estatus, fecha_movimiento, ultimo_movimiento, usuario_movimiento) VALUES('$id_comision', '$tipo_vehiculo', 
                '$especificar', '$id_vehiculo', '$km_inicial', '$estatus', '$fecha', '$proceso', '$usuario')";
            $respuesta = mysqli_query($conexion_database, $inserta);
        }
    break;
    case 'Edicion':
        if ($tipo_vehiculo == 1) {
            $especificar = null;
            $id_vehiculo = null;
            $km_inicial = null;
            $actualiza = "UPDATE parque_comision SET tipo_vehiculo = $tipo_vehiculo, especificar = '$especificar', vehiculo_id_vehiculo = '$id_vehiculo',
                km_inicial = '$km_inicial', estatus = '$estatus', fecha_movimiento = '$fecha', ultimo_movimiento = '$proceso', usuario_movimiento = '$usuario' 
                WHERE id_parque_comision = '$id' AND comision_id_comision = '$id_comision' LIMIT 1";
            $respuesta = mysqli_query($conexion_database, $actualiza);
        } else if ($tipo_vehiculo == 2) {
            $especificar = null;
            /**Corroboramos que no se duplique el auto para otra comision en la misma hora y fecha */
            $consulta_comparar = "SELECT vehiculo_id_vehiculo FROM parque_comision pc
                INNER JOIN comision c ON pc.comision_id_comision = c.id_comision
                WHERE pc.vehiculo_id_vehiculo = '$id_vehiculo' AND id_parque_comision <> '$id'
                AND (
                    ('$fecha_inicio $hora_inicio' BETWEEN CONCAT(c.f_ini, ' ', c.h_ini) AND CONCAT(c.f_fin, ' ', c.h_fin))
                    OR ('$fecha_fin $hora_fin' BETWEEN CONCAT(c.f_ini, ' ', c.h_ini) AND CONCAT(c.f_fin, ' ', c.h_fin))
                    OR (CONCAT(c.f_ini, ' ', c.h_ini) BETWEEN '$fecha_inicio $hora_inicio' AND '$fecha_fin $hora_fin')
                    OR (CONCAT(c.f_fin, ' ', c.h_fin) BETWEEN '$fecha_inicio $hora_inicio' AND '$fecha_fin $hora_fin')
                )
                AND c.estatus = '1' AND pc.estatus = '1'";
            //echo $consulta_comparar;
            $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
            $filas_comparar = mysqli_num_rows($resultado_comparar);
            mysqli_free_result($resultado_comparar);
            /**---------------------------------------------------------------------------------- */
            if ($filas_comparar == 0) {
                $actualiza = "UPDATE parque_comision SET tipo_vehiculo = $tipo_vehiculo, especificar = '$especificar', vehiculo_id_vehiculo = '$id_vehiculo',
                km_inicial = '$km_inicial', estatus = '$estatus', fecha_movimiento = '$fecha', ultimo_movimiento = '$proceso', usuario_movimiento = '$usuario' 
                WHERE id_parque_comision = '$id' AND comision_id_comision = '$id_comision' LIMIT 1";
                $respuesta = mysqli_query($conexion_database, $actualiza);
            } else {
                $comprobacion = "1";
            }
        } else if ($tipo_vehiculo == 3) {
            $id_vehiculo = null;
            $km_inicial = null;
            $actualiza = "UPDATE parque_comision SET tipo_vehiculo = $tipo_vehiculo, especificar = '$especificar', vehiculo_id_vehiculo = '$id_vehiculo',
                km_inicial = '$km_inicial', estatus = '$estatus', fecha_movimiento = '$fecha', ultimo_movimiento = '$proceso', usuario_movimiento = '$usuario' 
                WHERE id_parque_comision = '$id' AND comision_id_comision = '$id_comision' LIMIT 1";
            $respuesta = mysqli_query($conexion_database, $actualiza);
        }
    break;
}

$array = array(
    0 => $comprobacion
);
echo json_encode($array);
mysqli_close($conexion_database);
?>
