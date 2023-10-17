<?php 
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");
    $proceso = $_POST["proceso_documento_envio"];
    $id_documento = $_POST["id_documento_envio"];
    $fecha_envio = date("Y-m-d", strtotime($_POST["fecha_envio_documento"]));
    $departamento_envio = $_POST["departamento_envio"];
    $comprobacion = "0";  
    $proceso_envio = "Envio";
    date_default_timezone_set('America/Mexico_City');
    $fecha = date('Y-m-d');
    $usuario = $id_software_sesion;
    if($id_documento >= 1){
        /**------------Buscamos el departamento en el que esta----- */
        $consulta_buscar = "SELECT departamento_actual FROM historial_movimientos WHERE documento_id_documento = '$id_documento' ORDER BY id_historial DESC LIMIT 1"; 
        $resultado_buscar = mysqli_query($conexion_database, $consulta_buscar);
        while($row = mysqli_fetch_array($resultado_buscar)){
            $departamento_anterior = $row["departamento_actual"];
        }
        mysqli_free_result($resultado_buscar);
        /**-------------------------------------------------------- */
        /***----------Buscamos el estatus en el que se encuentra el documento---- */
        $buscar_estatus = "SELECT estatus FROM documentos WHERE id_documento = '$id_documento' LIMIT 1";
        $resultado_estatus = mysqli_query($conexion_database, $buscar_estatus);
        while($rowe = mysqli_fetch_array($resultado_estatus)){
            $estatus_documento = $rowe["estatus"];
        }
        /**---------------------------------------------------------------------- */
    }
    switch($proceso){
        case 'Registro':
            /**-------------Que no se envie el documento si se quiere enviar al departamento en el que esta------------------------------------------------------------- */
            if($departamento_anterior !== $departamento_envio){
            /**---------------------------------------------------------------------------------------------------------------------------------------------------------- */
                /**Insertamos si no se duplica el departamento actual con el departamento destino--- */
                $inserta = "INSERT INTO historial_movimientos(documento_id_documento, 
                departamento_anterior, departamento_actual, fecha, estatus_documento, 
                fecha_movimiento, ultimo_movimiento, usuario_movimiento)VALUES('$id_documento',
                '$departamento_anterior', '$departamento_envio', '$fecha_envio', '$estatus_documento', '$fecha',
                '$proceso_envio', '$usuario')";
                $proceso = mysqli_query($conexion_database, $inserta);
                /**--------------------------------------------------------------------------------- */
                if($proceso){
                    $comprobacion = "0";
                }else{
                    $comprobacion = "1";
                }
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