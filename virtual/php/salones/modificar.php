<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    $id = $_POST["id"];
    /**-----Consultamos la base de datos--------------- */
    $consulta = "SELECT id_salon, nombre_salon, edificio_id_edificio FROM salon WHERE id_salon = '$id' LIMIT 1";
    $resultado = mysqli_query($conexion_database, $consulta);
    $datos = array();
    while($row = mysqli_fetch_array($resultado)){
        $id = $row['id_salon'];
        $nombre = $row['nombre_salon'];
        $edificio = $row['edificio_id_edificio'];
    }
    $datos = array(
        0 => $id,
        1 => $nombre,
        2 => $edificio
    );
    /**------------------------------------------------ */
    echo json_encode($datos);
    mysqli_free_result($resultado);
    mysqli_close($conexion_database);
?>