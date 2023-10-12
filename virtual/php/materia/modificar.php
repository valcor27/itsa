<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    $id = $_POST["id"];
    /**-----Consultamos la base de datos--------------- */
    $consulta = "SELECT id_materia, nombre_materia, division_id_division FROM materia WHERE id_materia = '$id' LIMIT 1";
    $resultado = mysqli_query($conexion_database, $consulta);
    $datos = array();
    while($row = mysqli_fetch_array($resultado)){
        $id = $row['id_materia'];
        $nombre = $row['nombre_materia'];
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