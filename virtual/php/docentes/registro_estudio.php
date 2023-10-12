<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");
    $proceso = $_POST["proceso_estudio_docente"];
    $id = $_POST["id_docente_nivel_estudio"];
    $id_docente = $_POST["docentes_id_docentes"];
    $nivel = $_POST["select_nivel_estudio"];
    $titulo = $_POST["titulo"];
    $cedula = $_POST["cedula"];
    $escuela = $_POST["escuela"];
    $estatus = 1;
    $comprobacion = "0";
    date_default_timezone_set('America/Mexico_City');
    $fecha = date('Y-m-d');
    $usuario = $id_software_sesion;
    switch ($proceso){
        case 'Registro':
            /**Corroboramos que no se duplique ni el titulo ni la cedula */
            $consulta_comparar = "SELECT id_docente_nivel_estudio FROM docente_nivel_estudio 
            WHERE (titulo = '$titulo' OR cedula = '$cedula') AND estatus = '1' LIMIT 1";
            $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
            $filas_comparar = mysqli_num_rows($resultado_comparar);
            mysqli_free_result($resultado_comparar);
            /**--------------------------------------------------------- */
            if($filas_comparar == 0){
                $inserta = "INSERT INTO docente_nivel_estudio(docentes_id_docentes,
                nivel_estudio_id_nivel_estudio, titulo, cedula, escuela,
                estatus, fecha_movimiento, ultimo_movimiento, usuario_movimiento)
                VALUES('$id_docente', '$nivel', '$titulo', '$cedula', 
                '$escuela', '$estatus', '$fecha', '$proceso', '$usuario')";
                $respuesta = mysqli_query($conexion_database, $inserta);
            }else{
                $comprobacion = "1";
            }
        break;
        case 'Edicion':
            /**Corroboramos que no se duplique ni el titulo ni la cedula */
            $consulta_comparar = "SELECT id_docente_nivel_estudio FROM docente_nivel_estudio
            WHERE id_docente_nivel_estudio <> '$id' AND (titulo = '$titulo' OR cedula = '$cedula') AND estatus = '1' LIMIT 1";
            $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
            $filas_comparar = mysqli_num_rows($resultado_comparar);
            mysqli_free_result($resultado_comparar);
            /**--------------------------------------------------------- */
            if($filas_comparar == 0){
                $actualiza = "UPDATE docente_nivel_estudio SET docentes_id_docentes = '$id_docente',
                nivel_estudio_id_nivel_estudio = '$nivel', titulo = '$titulo', 
                cedula = '$cedula', escuela = '$escuela', fecha_movimiento = '$fecha', 
                ultimo_movimiento = '$proceso', usuario_movimiento = '$usuario'
                WHERE id_docente_nivel_estudio = '$id' LIMIT 1";
                $respuesta = mysqli_query($conexion_database, $actualiza);
            }else{
                $comprobacion = "1";
            }
        break;
    }
    $array = array(
        0 => $comprobacion,
        1 => $id_docente
    );
    echo json_encode($array);
    mysqli_close($conexion_database);
?>