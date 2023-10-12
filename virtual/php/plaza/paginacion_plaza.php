<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    /**Consultamos la BD para mostrar los registros encontrados---- */
    $consulta = "SELECT codigoPlaza, nombrePlaza FROM plaza WHERE estatus = '1' ORDER BY nombrePlaza";
    $registro = mysqli_query($conexion_database, $consulta);
    /**------------------------------------------------------------ */
    $tabla ='
        <option value="" selected disabled>Selecciona</option>
    ';
    //$tabla = array();
    while($row = mysqli_fetch_array($registro)){
        $id_plaza = $row["codigoPlaza"];
        $nombre_plaza = $row["nombrePlaza"];
        $tabla .='
            <option value="'.$id_plaza.'">'.$nombre_plaza.'</option>
        ';
    }
    $array = array(0 => $tabla);
    //$array = array( 0 => $id, 1 => $nombre_completo);
    echo json_encode($array);
    mysqli_free_result($registro);
    mysqli_close($conexion_database);
?>