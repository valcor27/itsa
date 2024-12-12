<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    $id = $_POST["id"];
    /**Consultamos la BD para obtener registros */
    $consulta = "SELECT f_ini, f_fin, h_ini, h_fin FROM comision WHERE id_comision = '$id' LIMIT 1";
    $resultado = mysqli_query($conexion_database, $consulta);
    while($row = mysqli_fetch_array($resultado)){
        $fecha_inicio = $row["f_ini"];
        $fecha_fin= $row["f_fin"];
        $hora_inicio = $row["h_ini"];
        $hora_fin = $row["h_fin"];
    }
    /**---------------------------------------- */
    $array = array(
        0 => $fecha_inicio,
        1 => $fecha_fin,
        2 => $hora_inicio,
        3 => $hora_fin
    );
    echo json_encode($array);
    mysqli_free_result($resultado);
    mysqli_close($conexion_database);
?>