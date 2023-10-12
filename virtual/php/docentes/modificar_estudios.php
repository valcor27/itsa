<?php 
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    $id = $_POST["id"];
    /**Consultamos la base de datos----------- */
    $consulta = "SELECT id_docente_nivel_estudio, 
    docentes_id_docentes, nivel_estudio_id_nivel_estudio, titulo, 
    cedula, escuela FROM docente_nivel_estudio WHERE id_docente_nivel_estudio = '$id' LIMIT 1";
    $resultado = mysqli_query($conexion_database, $consulta);
    $datos = array();
    while($row = mysqli_fetch_array($resultado)){
        $id = $row['id_docente_nivel_estudio'];
        $id_docente = $row['docentes_id_docentes'];
        $nivel = $row['nivel_estudio_id_nivel_estudio'];
        $titulo = $row['titulo'];
        $cedula = $row['cedula'];
        $escuela = $row['escuela'];
    }
    $datos = array(
        0 => $id,
        1 => $id_docente,
        2 => $nivel,
        3 => $titulo,
        4 => $cedula,
        5 => $escuela 
    );
    /**--------------------------------------- */
    echo json_encode($datos);
    mysqli_free_result($resultado);
    mysqli_close($conexion_database);
?>