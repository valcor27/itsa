<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");

    $id = $_POST["id"];
    /*----------------------*Consultamos la base de datos--------------- */
    $consulta = "SELECT id_documento, folio, dep_origen, fecha_creacion, tipo_doc,
    ff, partida_cd, partida_fed, partida_est, partida_ip, partida_pa, asunto,
    observacion FROM documentos WHERE id_documento = '$id' 
    AND estatus = '1' LIMIT 1";
    $resultado = mysqli_query($conexion_database, $consulta);
    $datos = array();
    while($row = mysqli_fetch_array($resultado)){
        $id = $row['id_documento'];
        $folio = $row['folio'];
        $departamento = $row['dep_origen'];
        $fecha = date("d-m-Y", strtotime($row['fecha_creacion']));
        $tipo = $row['tipo_doc'];
        $fuente = explode(',', $row['ff']);
        $pcd = $row['partida_cd'];
        $pf = $row['partida_fed'];
        $pe = $row['partida_est'];
        $pip = $row['partida_ip'];
        $ppa = $row['partida_pa'];
        $asunto = $row['asunto'];
        $observacion = $row['observacion'];
        //$nombre_documento = $row['nombre_documento'];
    }
    $datos = array(
        0 => $id,
        1 => $folio,
        2 => $departamento,
        3 => $fecha,
        4 => $tipo,
        5 => $fuente,
        6 => $pcd,
        7 => $pf,
        8 => $pe,
        9 => $pip,
        10 => $asunto,
        11 => $observacion,
        12 => $ppa
        //12 => $nombre_documento
    );
    /**----------------------------------------------------------------- */
    echo json_encode($datos);

    mysqli_free_result($resultado);
    mysqli_close($conexion_database);
?>