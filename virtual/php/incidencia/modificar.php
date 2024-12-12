<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    $id = $_POST["id"];
    /**Consultamos la base de datos para obtener los valores de la incidencia */
        $consulta = "SELECT id_incidencia,
        folio_incidencia, expediente, fecha_inicio, fecha_fin, 
        fecha_elaboracion, id_clave_mov, observacion,hora_incidencia FROM incidencia WHERE id_incidencia = '$id' LIMIT 1";
        $resultado = mysqli_query($conexion_database, $consulta);
        $datos = array();
        while($row = mysqli_fetch_array($resultado)){
            $id = $row["id_incidencia"];
            //$hora = $row["hora_incidencia"];
            $folio = $row["folio_incidencia"];
            $exp = $row["expediente"];
            $f_ini = date("d-m-Y", strtotime($row["fecha_inicio"]));
            $f_fin = date("d-m-Y", strtotime($row["fecha_fin"]));
            $f_elab = date("d-m-Y", strtotime($row["fecha_elaboracion"]));
            $id_mov = $row["id_clave_mov"];
            $obs = $row["observacion"];
            $hora = $row["hora_incidencia"];
        }
        $datos = array(
            0 => $id,
            1 => $folio,
            2 => $exp,
            3 => $f_ini,
            4 => $f_fin,
            5 => $f_elab,
            6 => $id_mov,
            7 => $obs,
            8 => $hora

        );
    /**---------------------------------------------------------------------- */
    echo json_encode($datos);

    mysqli_free_result($resultado);
    mysqli_close($conexion_database);
?>