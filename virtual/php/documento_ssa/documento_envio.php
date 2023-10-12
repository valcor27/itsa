<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    $id = $_POST["id"];
    /**--------------consultamos la base de datos---------------- */
    $consulta = "SELECT id_documento, folio, asunto FROM documentos
    WHERE id_documento = '$id' LIMIT 1";
    $resultado = mysqli_query($conexion_database, $consulta);
    $datos = array();
    while($row = mysqli_fetch_array($resultado)){
        $id_doc = $row["id_documento"];
        $folio = $row["folio"];
        $asunto = $row["asunto"];
    }
    /**---------------------------------------------------------- */
    date_default_timezone_set('America/Mexico_City');
    $fecha_envio = date('d-m-Y');
    $datos = array(
        0 => $id_doc,
        1 => $folio,
        2 => $asunto, 
        3 => $fecha_envio
    );
    echo json_encode($datos);
    mysqli_free_result($resultado);
    mysqli_close($conexion_database);
?>