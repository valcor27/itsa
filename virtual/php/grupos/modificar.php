<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    $id = $_POST["id"];
    /**-----Consultamos la base de datos--------------- */
    $consulta = "SELECT id_grupo, nombre_grupo, division_id_division FROM grupo WHERE id_grupo = '$id' LIMIT 1";
    $resultado = mysqli_query($conexion_database, $consulta);
    $datos = array();
    while($row = mysqli_fetch_array($resultado)){
        $id = $row['id_grupo'];
        $nombre = $row['nombre_grupo'];
        $division = $row['division_id_division'];
    }
    $datos = array(
        0 => $id,
        1 => $nombre,
        2 => $division
    );
    /**------------------------------------------------ */
    echo json_encode($datos);
    mysqli_free_result($resultado);
    mysqli_close($conexion_database);
?>