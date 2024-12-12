<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    $id = $_POST["id"];
    /**Consultamos la base de datos---------------------- */
    $consulta = "SELECT id_asistencia, fecha_inicio, fecha_fin FROM asistencia WHERE id_asistencia = '$id' LIMIT 1";
    $resultado = mysqli_query($conexion_database, $consulta);
    $datos = array();
    while($row = mysqli_fetch_array($resultado)){
        $id = $row["id_asistencia"];
        $fecha_inicio = date("d-m-Y", strtotime($row["fecha_inicio"]));
        $fecha_fin = date("d-m-Y", strtotime($row["fecha_fin"]));
    }
    $datos = array(
        0 => $id,
        1 => $fecha_inicio,
        2 => $fecha_fin
    );
    /**-------------------------------------------------- */
    echo json_encode($datos);
    mysqli_free_result($resultado);
    mysqli_close($conexion_database);
?>