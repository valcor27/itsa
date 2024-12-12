<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    //$tabla ='';
    /**Consultamos la BD para mostrar los registros encontrados---- */
    $consulta = "SELECT idvehiculo, marca, submarca FROM vehiculo WHERE estatus = '1' ORDER BY marca, submarca";
    $registro = mysqli_query($conexion_database, $consulta);
    /**------------------------------------------------------------ */
    $tabla ='
        <span class="input-group-text"><i class="fa-solid fa-car-side"></i></span>
        <select class="selectpicker form-control" data-live-search="true" name="vehiculo_comision" id="vehiculo_comision" onchange="return Datos_vehiculo();" required="">
            
    ';
    //$tabla = array();
    while($row = mysqli_fetch_array($registro)){
        $marca = $row["marca"];
        $submarca = $row["submarca"];
        $id = $row["idvehiculo"];
        $nombre_completo = $marca.' '.$submarca;
        $tabla = $tabla.'
            <option value="'.$id.'">'.$nombre_completo.'</option>
        ';
    }
    $tabla = $tabla.'
        </select>
    ';
    $array = array(
        0 => $tabla
    );
    //$array = array( 0 => $id, 1 => $nombre_completo);
    echo json_encode($array);
    mysqli_free_result($registro);
    mysqli_close($conexion_database);
?>