<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    //$tabla ='';
    /**Consultamos la BD para mostrar los registros encontrados---- */
    $consulta = "SELECT id_clave_movimiento, nombre_clave FROM clave_movimiento WHERE estatus = '1' ORDER BY id_clave_movimiento";
    $registro = mysqli_query($conexion_database, $consulta);
    /**------------------------------------------------------------ */
    $tabla ='
        
        <option value="" selected disabled>Selecciona</option>
    ';
    //$tabla = array();
    while($row = mysqli_fetch_array($registro)){
        $nombre = $row["id_clave_movimiento"].' '.$row["nombre_clave"];
        $id = $row["id_clave_movimiento"];
        $tabla .='
            <option value="'.$id.'">'.$nombre.'</option>
        ';
    }
    $array = array(0 => $tabla);
    //$array = array( 0 => $id, 1 => $nombre_completo);
    echo json_encode($array);
    mysqli_free_result($registro);
    mysqli_close($conexion_database);
?>