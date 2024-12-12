<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    $id = $_POST["id"];
    /**-----Consultamos la base de datos--------------- */
    $consulta = "SELECT id_combustible, nombre, precio FROM combustible WHERE id_combustible = '$id' LIMIT 1";
    $resultado = mysqli_query($conexion_database, $consulta);
    $datos = array();
    while($row = mysqli_fetch_array($resultado)){
        $id = $row['id_combustible'];
        $nombre = $row['nombre'];
        $precio = $row['precio'];
    }
    $datos = array(
        0 => $id,
        1 => $nombre,
        2 => $precio

    );
    /**------------------------------------------------ */
    echo json_encode($datos);
    mysqli_free_result($resultado);
    mysqli_close($conexion_database);
?>