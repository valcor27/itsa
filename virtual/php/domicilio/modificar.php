<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    $expediente = $_POST["id"];
    $id_domicilio = $_POST["domicilio"];
    /**-----------------Consultamos la BD----------------- */
    $consulta = "SELECT idDomicilio, calle, n_Ext, nInt,
    colonia, cp, localidad, municipio_idMunicipio, estado_idEstado,
    empleado_expediente FROM domicilio WHERE idDomicilio = '$id_domicilio'
    AND empleado_expediente = '$expediente' LIMIT 1";
    $resultado = mysqli_query($conexion_database, $consulta);
    $datos = array();
    while($row = mysqli_fetch_array($resultado)){
        $id = $row["idDomicilio"];
        $calle = $row["calle"];
        $n_ext = $row["n_Ext"];
        $n_int = $row["nInt"];
        $col = $row["colonia"];
        $cp = $row["cp"];
        $local = $row["localidad"];
        $muni = $row["municipio_idMunicipio"];
        $estado = $row["estado_idEstado"];
        $exp = $row["empleado_expediente"];
    }
    $datos = array(
        0 => $id,
        1 => $exp,
        2 => $calle,
        3 => $n_ext,
        4 => $n_int,
        5 => $col,
        6 => $cp,
        7 => $local,
        8 => $estado,
        9 => $muni 
    );
    /**---------------------------------------------------- */
    echo json_encode($datos);
    mysqli_free_result($resultado);
    mysqli_close($conexion_database);    
?>