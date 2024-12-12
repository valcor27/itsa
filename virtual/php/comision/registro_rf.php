<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");
    $proceso = $_POST["proceso_comision_rf"];
    $id = $_POST["id_comision_rf"];
    $id_comision = $_POST["comision_id_comision"];
    $viatico = $_POST["viatico"];
    $combustible = $_POST["combustible"];
    $caseta = $_POST["casetas"];
    $otros = $_POST["otros"];
    $especificar = isset($_POST["especificar"]) ? $_POST["especificar"] : null;
    $total = $_POST["total"];
    $estatus = 1;
    $comprobacion = "0";
    date_default_timezone_set('America/Mexico_City');
    $fecha = date('Y-m-d');
    $usuario = $id_software_sesion;
    switch ($proceso){
        case 'Registro':
            /**Corroboramos que no se duplique ni el titulo ni la cedula */
            $consulta_comparar = "SELECT id_viaticos_comision FROM viaticos_comision 
            WHERE comision_id_comision = '$id_comision' AND estatus = '1' LIMIT 1";
            $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
            $filas_comparar = mysqli_num_rows($resultado_comparar);
            mysqli_free_result($resultado_comparar);
            /**--------------------------------------------------------- */
            if($filas_comparar == 0){
                $inserta = "INSERT INTO viaticos_comision(comision_id_comision, viatico, combustible, casetas, otros, especificar, total,
                estatus, fecha_movimiento, ultimo_movimiento, usuario_movimiento)
                VALUES('$id_comision', '$viatico', '$combustible', '$caseta', 
                '$otros', '$especificar', '$total', '$estatus', '$fecha', '$proceso', '$usuario')";
                $respuesta = mysqli_query($conexion_database, $inserta);
            }else{
                $comprobacion = "1";
            }
        break;
        case 'Edicion':
            /**Corroboramos que no se duplique ni el titulo ni la cedula */
            $consulta_comparar = "SELECT id_viaticos_comision FROM viaticos_comision
            WHERE id_viaticos_comision <> '$id' AND comision_id_comision = '$id_comision' AND estatus = '1' LIMIT 1";
            $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
            $filas_comparar = mysqli_num_rows($resultado_comparar);
            mysqli_free_result($resultado_comparar);
            /**--------------------------------------------------------- */
            if($filas_comparar == 0){
                $actualiza = "UPDATE viaticos_comision SET viatico = '$viatico', combustible = '$combustible', casetas = '$caseta', 
                otros = '$otros', especificar = '$especificar', total = '$total', fecha_movimiento = '$fecha', 
                ultimo_movimiento = '$proceso', usuario_movimiento = '$usuario'
                WHERE id_viaticos_comision = '$id' LIMIT 1";
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