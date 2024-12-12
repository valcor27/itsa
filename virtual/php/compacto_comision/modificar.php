<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    $id = $_POST["id"];
    /**Consultamos la base de datos------------- */
    $consulta = "SELECT id_historial_parque_comision, vehiculo_id_vehiculo, comisiones_id_comisiones, km_inicial, km_final, km_recorridos, 
    viatico_casetas, viatico_combustible, id_combustible, departamento_id_departamento FROM historial_parque_comision 
    WHERE id_historial_parque_comision = '$id' LIMIT 1";
    $resultado = mysqli_query($conexion_database, $consulta);
    $datos = array();
    while($row = mysqli_fetch_array($resultado)){
        $id =  $row["id_historial_parque_comision"];
        $id_vehiculo = $row["vehiculo_id_vehiculo"];
        $id_comisiones = explode(',', $row["comisiones_id_comisiones"]);
        $km_i = $row["km_inicial"];
        $km_f = $row["km_final"];
        $km_r = $row["km_recorridos"];
        $v_caseta = $row["viatico_casetas"];
        $v_combustible = $row["viatico_combustible"];
        $id_combustible = $row["id_combustible"];
        $id_departamentos = explode(',', $row["departamento_id_departamento"]);
    }
    /**----------------------------------------- */
    if($id_vehiculo > 0){
        $consulta_2 = "SELECT marca, submarca FROM vehiculo WHERE idvehiculo = '$id_vehiculo' LIMIT 1";
        $resultado_2 = mysqli_query($conexion_database, $consulta_2);
        while($row_2 = mysqli_fetch_array($resultado_2)){
            $marca = $row_2["marca"];
            $submarca = $row_2["submarca"];
            $vehiculo = $marca.', '.$submarca;
        }
    }
    $datos = array(
        0 => $id,
        1 => $id_vehiculo,
        2 => $id_comisiones,
        3 => $km_i,
        4 => $km_f,
        5 => $km_r,
        6 => $v_caseta,
        7 => $v_combustible,
        8 => $id_combustible,
        9 => $id_departamentos,
        10 => $vehiculo
    );
    echo json_encode($datos);

    mysqli_free_result($resultado);
    mysqli_close($conexion_database);
?>