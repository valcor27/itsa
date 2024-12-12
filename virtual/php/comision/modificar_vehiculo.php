<?php 
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    $id = $_POST["id"];
    /***Consultamos la base de datos para obtener los valores del vehiculo a comision */
    $consulta = "SELECT id_parque_comision, comision_id_comision, tipo_vehiculo, especificar, vehiculo_id_vehiculo, km_inicial FROM parque_comision WHERE id_parque_comision = '$id' LIMIT 1";
    $resultado = mysqli_query($conexion_database, $consulta);
    $datos = array();
    while($row = mysqli_fetch_array($resultado)){
        $id = $row["id_parque_comision"];
        $id_comision = $row["comision_id_comision"];
        $tipo_vehiculo = $row["tipo_vehiculo"];
        $especificar = $row["especificar"];
        $id_vehiculo = $row["vehiculo_id_vehiculo"];
        $km = $row["km_inicial"];
    }
    /*if($id_vehiculo > 0){
        $consulta_2 = "SELECT placas FROM vehiculo WHERE idvehiculo = '$id_vehiculo' LIMIT 1";
        $resultado_2 = mysqli_query($conexion_database, $consulta_2);
        while($row_2 = mysqli_fetch_array($resultado_2)){
            $placas = $row_2["placas"];
        }
        mysqli_free_result($resultado_2);
    }else{
        $placas = '';
    }*/
    $datos = array(
        0 => $id,
        1 => $id_comision,
        2 => $tipo_vehiculo,
        3 => $especificar,
        4 => $id_vehiculo,
        //5 => $placas,
        5 => $km        
    );
    /**------------------------------------------------------------------------------ */
    echo json_encode($datos);
    
    mysqli_free_result($resultado);
    mysqli_close($conexion_database);
?>