<?php 
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    $tabla = '';
    /**Consultamos la BD para mostrar los registros encontrados------------ */
    $consulta = "SELECT idEstado, nombreEstado FROM estado WHERE estatus = '1' ORDER BY idEstado";
    $registro = mysqli_query($conexion_database, $consulta);
    /**--------------------------------------------------------------------- */
    $tabla = $tabla.'
        <option value="0" selected disabled>Selecciona</option>
    ';
    while($row = mysqli_fetch_array($registro)){
        $tabla = $tabla.'
            <option value="'.$row["idEstado"].'">'.$row["nombreEstado"].'</option>
        ';
    }
    $array = array(0 => $tabla);
    echo json_encode($array);
    mysqli_free_result($registro);
    mysqli_close($conexion_database);
?>