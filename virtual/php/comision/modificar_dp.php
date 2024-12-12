<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    $id = $_POST["id"];
    /**Consultamos la base de datos para obtener los valores de la incidencia */
        $consulta = "SELECT id_comision, fecha_comision, folio_comision, id_empleado, id_plaza, n_comi, lugar, finalidad, f_ini, f_fin, h_ini, h_fin, 
        duracion, pais, nombre_estado, nombre_municipio, lugar_comision FROM comision WHERE id_comision = '$id' LIMIT 1";
        $resultado = mysqli_query($conexion_database, $consulta);
        $datos = array();
        while($row = mysqli_fetch_array($resultado)){
            $id = $row["id_comision"];
            $fecha_comision = date("d-m-Y", strtotime($row["fecha_comision"]));
            $folio = $row["folio_comision"];
            $expediente = explode(',', $row["id_empleado"]);
            $id_plaza = $row["id_plaza"];
            $n_comi = $row["n_comi"];
            $lugar = $row["lugar"];
            $finalidad = $row["finalidad"];
            $f_ini = date("d-m-Y", strtotime($row["f_ini"]));
            $f_fin = date("d-m-Y", strtotime($row["f_fin"]));
            $h_ini = date("H:i", strtotime($row["h_ini"]));
            $h_fin = date("H:i", strtotime($row["h_fin"]));
            $duracion = $row["duracion"];
            $pais = $row["pais"];
            $estado = $row["nombre_estado"];
            $municipio = $row["nombre_municipio"];
            $lugar_comision = $row["lugar_comision"];
        }
        /**Verificamos si $id_plaza es un array */
        if(is_array($id_plaza)){
            $id_plaza_list = implode("','", $id_plaza);
            $consulta_2 = "SELECT nombrePlaza FROM plaza WHERE codigoPlaza IN ('$id_plaza_list')";
        }else{
            $consulta_2 ="SELECT nombrePlaza FROM plaza WHERE codigoPlaza = '$id_plaza' LIMIT 1";
        }
        $resultado_2 = mysqli_query($conexion_database, $consulta_2);
        $cargo = array();
        while($row_2 = mysqli_fetch_array($resultado_2)){
            $cargo[] = $row_2["nombrePlaza"];
        }
        $datos = array(
            0 => $id,
            1 => $id_plaza,
            2 => $expediente,
            3 => $lugar,
            4 => $fecha_comision,
            5 => $n_comi,
            6 => $folio,
            7 => $cargo,
            8 => $f_ini,
            9 => $f_fin,
            10 => $h_ini,
            11 => $h_fin,
            12 => $finalidad,
            13 => $duracion,
            14 => $pais,
            15 => $estado,
            16 => $municipio,
            17 => $lugar_comision
        );
    /**---------------------------------------------------------------------- */
    echo json_encode($datos);

    mysqli_free_result($resultado);
    mysqli_free_result($resultado_2);
    mysqli_close($conexion_database);
?>