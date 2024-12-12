<?php 
    ini_set('upload_max_filesize', '5M');
    ini_set('post_max_size', '8M');
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");
    $maxSize = 5 * 1024 * 1024; //2 MB (en bytes)
    $departamento_usuario = $estructura_real;
    $proceso = $_POST["proceso_documento"];
    $id = $_POST["id_documento"];
    $folio = $_POST["folio"];
    //$folio_nombre_archivo = $_POST["folio"];
    $asunto = $_POST["asunto"];
    $dep = $_POST["departamento"];
    $fecha = date("Y-m-d", strtotime($_POST["fCrea"]));
    $tipo = $_POST["tipo_doc"];
    $ff = isset($_POST["fuente_fin"]) ? implode(',', $_POST["fuente_fin"]) : null;
    $pcd = isset($_POST["pcd"]) ? $_POST["pcd"] : null;
    $pf = isset($_POST["pf"]) ? $_POST["pf"] : null; 
    $pe = isset($_POST["pe"]) ? $_POST["pe"] : null; 
    $pip = isset($_POST["pip"]) ? $_POST["pip"] : null; 
    $ppa = isset($_POST["ppa"]) ? $_POST["ppa"] : null;
    $observacion = isset($_POST["observacion"]) ? $_POST["observacion"] : null; 
    $archivo = isset($_FILES["archivo"]) ? $_FILES["archivo"] : null;
    $estatus = 1;
    $comprobacion = "0";
    $folio = strtoupper($folio);
    $asunto = strtoupper($asunto);
    $observacion = strtoupper($observacion);
    //$folio_nombre_archivo = strtoupper($folio_nombre_archivo);
    $folio_nombre_archivo = str_replace('/', '_', $folio);
    /*$archivo = isset($_FILES["archivo"]) ? $_FILES["archivo"] : null;
    $nombre_archivo = $archivo["name"];
    $nuevo_nombre_documento = "documento_".$folio;
    $archivoTemp = $archivo["tmp_name"];
    $ruta_carpeta = "../../documentos/" . $nuevo_nombre_documento;
    */
    //if(isset($_FILES["archivo"])){
     //   $archivo = $_FILES["archivo"];
    //}
    date_default_timezone_set('America/Mexico_City');
    //$fecha_archivo = date('d-m-Y-H-i-s');
    $fecha_archivo = date('d-m-Y');
    $archivo_nuevo_nombre = "documento_" . $folio_nombre_archivo."_" . $fecha_archivo .".pdf";
    $ruta_carpeta = "../../documentos/";
    $ruta_guardar_archivo = $ruta_carpeta . $archivo_nuevo_nombre;
    $usuario = $id_software_sesion;
    $fecha_movimiento = date('Y-m-d');
    $proceso_registro_h = "Registro";
    if($archivo["size"] > $maxSize){
        $comprobacion = "3";
    }else{
        switch($proceso){
            case 'Registro':
                if(!empty($_FILES["archivo"]["name"])){
                    if ($archivo["type"] == "application/pdf"){
                        /*------Que no se duplique el folio del documento-----*/
                        $consulta_comparar = "SELECT id_documento FROM documentos WHERE folio = '$folio' LIMIT 1";
                        $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
                        $filas_comparar = mysqli_num_rows($resultado_comparar);
                        mysqli_free_result($resultado_comparar);
                        /**-------------------------------------------------- */
                        if($filas_comparar == 0){
                            /**-------Insertamos los datos si no se duplican---- */
                            $inserta = "INSERT INTO documentos(folio, dep_origen,
                            fecha_creacion, tipo_doc, ff, partida_cd, partida_fed,
                            partida_est, partida_ip, partida_pa, asunto, observacion, nombre_documento, estatus, 
                            fecha_movimiento, ultimo_movimiento, usuario_movimiento)VALUES(
                            '$folio', '$dep', '$fecha', '$tipo', '$ff', '$pcd', '$pf',
                            '$pe', '$pip', '$ppa', '$asunto', '$observacion', '$archivo_nuevo_nombre', '$estatus', '$fecha_movimiento', 
                            '$proceso', '$usuario')";
                            $proceso = mysqli_query($conexion_database, $inserta);
                            /**------------------------------------------------- */
                            /**Movemos el archivo a la carpeta de documentos  */
                            move_uploaded_file($archivo["tmp_name"], $ruta_guardar_archivo);
                            /**---------------------------------------------- */
                            if($proceso){
                                /*------insertamos en el historial de movimientos sin departamento anterior--- */
                                $ultimo_id_documento = mysqli_insert_id($conexion_database);
                                $inserta_historial = "INSERT INTO historial_movimientos(documento_id_documento,
                                departamento_actual, fecha, estatus_documento, fecha_movimiento, ultimo_movimiento,
                                usuario_movimiento)VALUES('$ultimo_id_documento', '$departamento_usuario', '$fecha', '$estatus', 
                                '$fecha_movimiento', '$proceso_registro_h', '$usuario')";
                                $proceso_historial = mysqli_query($conexion_database, $inserta_historial);
                                /**--------------------------------------------------------------------------- */
                            }
                        }else{
                            $comprobacion = "1";
                        }
                    }else{
                        $comprobacion = "2";
                    }
                }else{
                    /*------Que no se duplique el folio del documento-----*/
                    $consulta_comparar = "SELECT id_documento FROM documentos WHERE folio = '$folio' LIMIT 1";
                    $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
                    $filas_comparar = mysqli_num_rows($resultado_comparar);
                    mysqli_free_result($resultado_comparar);
                    /**-------------------------------------------------- */
                    if($filas_comparar == 0){
                        /**-------Insertamos los datos si no se duplican---- */
                        $inserta = "INSERT INTO documentos(folio, dep_origen,
                        fecha_creacion, tipo_doc, ff, partida_cd, partida_fed,
                        partida_est, partida_ip, partida_pa, asunto, observacion, estatus, 
                        fecha_movimiento, ultimo_movimiento, usuario_movimiento)VALUES(
                        '$folio', '$dep', '$fecha', '$tipo', '$ff', '$pcd', '$pf',
                        '$pe', '$pip', '$ppa', '$asunto', '$observacion', '$estatus', 
                        '$fecha_movimiento', '$proceso', '$usuario')";
                        $proceso = mysqli_query($conexion_database, $inserta);
                        /**------------------------------------------------- */
                        if($proceso){
                            /*------insertamos en el historial de movimientos sin departamento anterior--- */
                            $ultimo_id_documento = mysqli_insert_id($conexion_database);
                            $inserta_historial = "INSERT INTO historial_movimientos(documento_id_documento,
                                departamento_actual, fecha, estatus_documento, fecha_movimiento, ultimo_movimiento,
                                usuario_movimiento)VALUES('$ultimo_id_documento', '$departamento_usuario', '$fecha', '$estatus', 
                                '$fecha_movimiento', '$proceso_registro_h', '$usuario')";
                            $proceso_historial = mysqli_query($conexion_database, $inserta_historial);
                            /**--------------------------------------------------------------------------- */
                        }
                    }else{
                        $comprobacion = "1";
                    }
                }
            break;
            case 'Edicion':
                if(!empty($_FILES["archivo"]["name"])){
                    if ($archivo["type"] == "application/pdf"){
                        /***Corroboramos que no se duplique el folio para actualizar */
                        $consulta_comparar = "SELECT id_documento FROM documentos WHERE id_documento <> '$id' AND folio = '$folio' LIMIT 1";
                        $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
                        $filas_comparar = mysqli_num_rows($resultado_comparar);

                        mysqli_free_result($resultado_comparar);
                        /**--------------------------------------------------------- */
                        /**Actualizamos el registro si no hay datos duplicados------ */
                        if($filas_comparar == 0){
                            $actualiza = "UPDATE documentos SET folio = '$folio', dep_origen = '$dep',
                            fecha_creacion = '$fecha', tipo_doc = '$tipo', ff = '$ff', 
                            partida_cd = '$pcd', partida_fed = '$pf', partida_est = '$pe', 
                            partida_ip = '$pip', partida_pa = '$ppa', asunto = '$asunto', observacion = '$observacion', 
                            nombre_documento = '$archivo_nuevo_nombre', fecha_movimiento = '$fecha_movimiento', 
                            ultimo_movimiento = '$proceso', usuario_movimiento = '$usuario'
                            WHERE id_documento = '$id' LIMIT 1";
                            $resultado_actualiza = mysqli_query($conexion_database, $actualiza);
                            if(file_exists($ruta_guardar_archivo)){
                                unlink($ruta_guardar_archivo);
                            }
                            move_uploaded_file($archivo["tmp_name"], $ruta_guardar_archivo);
                        }else{
                            $comprobacion = "1";
                        }
                    }else{
                        $comprobacion = "2";
                    }
                    /**--------------------------------------------------------- */
                }else{
                    /***Corroboramos que no se duplique el folio para actualizar */
                    $consulta_comparar = "SELECT id_documento FROM documentos WHERE id_documento <> '$id' AND folio = '$folio' LIMIT 1";
                    $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
                    $filas_comparar = mysqli_num_rows($resultado_comparar);

                    mysqli_free_result($resultado_comparar);
                    /**--------------------------------------------------------- */
                    /**Actualizamos el registro si no hay datos duplicados------ */
                    if($filas_comparar == 0){
                        $actualiza = "UPDATE documentos SET folio = '$folio', dep_origen = '$dep',
                        fecha_creacion = '$fecha', tipo_doc = '$tipo', ff = '$ff', 
                        partida_cd = '$pcd', partida_fed = '$pf', partida_est = '$pe', 
                        partida_ip = '$pip', partida_pa = '$ppa', asunto = '$asunto', observacion = '$observacion',
                        fecha_movimiento = '$fecha_movimiento', ultimo_movimiento = '$proceso', usuario_movimiento = '$usuario'
                        WHERE id_documento = '$id' LIMIT 1";
                        $resultado_actualiza = mysqli_query($conexion_database, $actualiza);
                    }else{
                        $comprobacion = "1";
                    }
                    /**--------------------------------------------------------- */
                }
            break;
        }
    }
    
$array = array(
    0 => $comprobacion
);
echo json_encode($array);

//mysqli_free_result($registro);
mysqli_close($conexion_database);
?>