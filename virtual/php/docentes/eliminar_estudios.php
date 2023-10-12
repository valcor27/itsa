<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");
    $ideliminar = $_POST["id"];
    date_default_timezone_set('America/Mexico_City');
    $fecha = date('Y-m-d');
    //$dato = sanear_normal($dato);
    $proceso = "Eliminar";
    $usuario = $id_software_sesion;
    //$id_docente = '';
     /**-----Verificacion de eliminar ---------------------------- */
     if($ideliminar > 0){
        $eliminar = "UPDATE docente_nivel_estudio 
            SET estatus = '0', fecha_movimiento = '$fecha',
            ultimo_movimiento = '$proceso', usuario_movimiento = '$usuario'  
            WHERE id_docente_nivel_estudio = '$ideliminar' LIMIT 1
        ";
        $resultado_eliminar = mysqli_query($conexion_database, $eliminar);
    }
    /** ----------------------------------------------------------*/
    $buscar_docente = "SELECT docentes_id_docentes FROM docente_nivel_estudio WHERE id_docente_nivel_estudio = '$ideliminar' LIMIT 1";
    $resultado = mysqli_query($conexion_database, $buscar_docente);
    //$datos = array();
    while($row = mysqli_fetch_array($resultado)){
        $id_docente = $row["docentes_id_docentes"];
    }
    $datos = array(
        0 => $id_docente
    );
    echo json_encode($datos);
    mysqli_free_result($resultado);
    mysqli_close($conexion_database);
?>