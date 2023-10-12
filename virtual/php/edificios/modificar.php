<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    $id = $_POST["id"];

    /**Consultamos la base de datos */
    $consulta = "SELECT id_edificio, nombre_edificio FROM edificio
    WHERE id_edificio = '$id' LIMIT 1";
    $resultado = mysqli_query($conexion_database, $consulta);
    $datos = array();
    while($row = mysqli_fetch_array($resultado)){
        $id = $row['id_edificio'];
        $nombre = $row['nombre_edificio'];
    }
    $datos = array(
        0 => $id,
        1 => $nombre
    );
    /**---------------------------- */
    echo json_encode($datos);

    mysqli_free_result($resultado);
    mysqli_close($conexion_database);
?>