<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    $id = $_POST["id"];
    /**-----Consultamos la base de datos--------------- */
    $consulta = "SELECT id_dia_inhabil, concepto, fecha_dia_inhabil FROM dia_inhabil WHERE id_dia_inhabil = '$id' LIMIT 1";
    $resultado = mysqli_query($conexion_database, $consulta);
    $datos = array();
    while($row = mysqli_fetch_array($resultado)){
        $id = $row['id_dia_inhabil'];
        $fecha = date("d-m-Y", strtotime($row['fecha_dia_inhabil']));
        $concepto = $row['concepto'];
    }
    $datos = array(
        0 => $id,
        1 => $fecha,
        2 => $concepto
    );
    /**------------------------------------------------ */
    echo json_encode($datos);
    mysqli_free_result($resultado);
    mysqli_close($conexion_database);
?>