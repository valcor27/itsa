<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    $id = $_POST["id"];
    /**Consultamos la base de datos--------- */
    $consulta = "SELECT id_docentes, empleados_expediente, clave, nombre_docente FROM docentes WHERE id_docentes = '$id' LIMIT 1";
    $resultado = mysqli_query($conexion_database, $consulta);
    $datos = array();
    while($row = mysqli_fetch_array($resultado)){
        $id = $row['id_docentes'];
        $expediente = $row['empleados_expediente'];
        $clave = $row['clave'];
        $nombre = $row['nombre_docente'];
    }
    $datos = array(
        0 => $id,
        1 => $expediente,
        2 => $clave,
        3 => $nombre
    );
    /**------------------------------------- */
    echo json_encode($datos);
    mysqli_free_result($resultado);
    mysqli_close($conexion_database);
?>