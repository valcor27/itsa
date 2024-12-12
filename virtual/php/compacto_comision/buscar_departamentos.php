<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php"); 
    /**Consultamos la base de datos para mostrar los valores de los departamentos */
        $consulta = "SELECT claveUnidad, nombreUnidad FROM estructuraorganica WHERE estatus = '1' ORDER BY claveUnidad ASC";
        $resultado = mysqli_query($conexion_database, $consulta);
    /**-------------------------------------------------------------------------- */
    $tabla = '
        <span class="input-group-text"><i class="fa-solid fa-building-user"></i></span>
        <select class="selectpicker form-control" data-live-search="true" multiple name="id_departamentos[]" id="id_departamentos" required="">
    ';
    while($row = mysqli_fetch_array($resultado)){
        $id = $row["claveUnidad"];
        $nombre = $row["nombreUnidad"];
        $tabla = $tabla.'
            <option value="'.$id.'">'.$nombre.'</option>
        ';
    }
    $tabla = $tabla.'
        </select>
    ';
    //$array = array(0 => $tabla);
    echo $tabla;
    //echo json_encode($tabla);
    mysqli_free_result($resultado);
    mysqli_close($conexion_database);
?>