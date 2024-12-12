<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    $id = $_POST["id"];
    /**Consultamos la base de datos para obtener los valores de la incidencia */
        $consulta = "SELECT id_licencia, hora_l, folio_l, expediente_l, fecha_inicio_l, 
        fecha_fin_l, fecha_elaboracion_l, concepto FROM licencia WHERE id_licencia = '$id' LIMIT 1";
        $resultado = mysqli_query($conexion_database, $consulta);
        $datos = array();
        while($row = mysqli_fetch_array($resultado)){
            $id = $row["id_licencia"];
            $hora = $row["hora_l"];
            $folio = $row["folio_l"];
            $exp = $row["expediente_l"];
            $f_ini = date("d-m-Y", strtotime($row["fecha_inicio_l"]));
            $f_fin = date("d-m-Y", strtotime($row["fecha_fin_l"]));
            $f_elab = date("d-m-Y", strtotime($row["fecha_elaboracion_l"]));
            $concepto = $row["concepto"];
        }
        $datos = array(
            0 => $id,
            1 => $folio,
            2 => $exp,
            3 => $concepto,
            4 => $f_elab,
            5 => $hora,
            6 => $f_ini,
            7 => $f_fin
        );
    /**---------------------------------------------------------------------- */
    echo json_encode($datos);

    mysqli_free_result($resultado);
    mysqli_close($conexion_database);
?>