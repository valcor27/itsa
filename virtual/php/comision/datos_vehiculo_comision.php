<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    $carro = $_POST["carro"];
    $placas='';
    $km_final='';
    /**Consultamos la bd para mostrar los valores encontrados */
    $consulta = "SELECT placas FROM vehiculo WHERE idvehiculo = '$carro' LIMIT 1";
    $resultado = mysqli_query($conexion_database, $consulta);
    while($row = mysqli_fetch_array($resultado)){
        $placas = $row["placas"];
    }
    /**------------------------------------------------------ */
    /***Verificamos para obtener el ultimo kilometraje del vehiculo */
    $consulta_buscar = "SELECT km_final FROM historial_parque_comision WHERE vehiculo_id_vehiculo = '$carro'  ORDER BY id_historial_parque_comision DESC LIMIT 1";
    $resultado_buscar = mysqli_query($conexion_database, $consulta_buscar);
    $filas_comparar = mysqli_num_rows($resultado_buscar);
    if($filas_comparar == 0){
        $consulta_real = "SELECT kminicial FROM vehiculo WHERE idvehiculo = '$carro' LIMIT 1";
        $resultado_real = mysqli_query($conexion_database, $consulta_real);
        while($row_2 = mysqli_fetch_array($resultado_real)){
            $km_final = $row_2["kminicial"];
        }
        mysqli_free_result($resultado_real);
    }else{
        while($row_1 = mysqli_fetch_array($resultado_buscar)){
            $km_final = $row_1["km_final"];
        }
        mysqli_free_result($resultado_buscar);
    }
    /**------------------------------------------------------------ */
    $array = array(
        0 => $placas,
        1 => $km_final
    );
    echo json_encode($array);
    mysqli_free_result($resultado);    
    mysqli_close($conexion_database);
?>