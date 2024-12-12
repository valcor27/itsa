<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    $id = $_POST["id"];
    /**Consultamos la base de datos para obtener los valores de la incidencia */
        $consulta = "SELECT id_chofer, expediente_chofer FROM chofer WHERE id_chofer = '$id' LIMIT 1";
        $resultado = mysqli_query($conexion_database, $consulta);
        $datos = array();
        while($row = mysqli_fetch_array($resultado)){
            $id = $row["id_chofer"];
            $expediente = $row["expediente_chofer"];
        }
        $datos = array(
            0 => $id,
            1 => $expediente
        );
    /**---------------------------------------------------------------------- */
    echo json_encode($datos);

    mysqli_free_result($resultado);
    mysqli_close($conexion_database);
?>