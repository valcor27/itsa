<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    $id = $_POST["id"];
    /**Consultamos la base de datos para obtener los valores de la incidencia */
        $consulta = "SELECT id_viaticos_comision, comision_id_comision, viatico, combustible, casetas, otros, especificar, total FROM viaticos_comision WHERE id_viaticos_comision = '$id' LIMIT 1";
        $resultado = mysqli_query($conexion_database, $consulta);
        $datos = array();
        while($row = mysqli_fetch_array($resultado)){
            $id = $row["id_viaticos_comision"];
            $id_comision = $row["comision_id_comision"];
            $viatico = $row["viatico"];
            $combustible = $row["combustible"];
            $casetas = $row["casetas"];
            $otros = $row["otros"];
            $especificar = $row["especificar"];
            $total = $row["total"];
        }
        $datos = array(
            0 => $id,
            1 => $id_comision,
            2 => $viatico,
            3 => $combustible,
            4 => $casetas,
            5 => $otros,
            6 => $especificar,
            7 => $total
        );
    /**---------------------------------------------------------------------- */
    echo json_encode($datos);

    mysqli_free_result($resultado);
    mysqli_close($conexion_database);
?>