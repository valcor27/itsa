<?php
    error_reporting(E_ALL); 
    ini_set('display_errors', 1);
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php"); 
    /**Consultamos la base de datos para mostrar los valores de los departamentos */
        $consulta = "SELECT claveUnidad, nombreUnidad FROM estructuraorganica WHERE estatus = '1' ORDER BY claveUnidad ASC";
        $resultado = mysqli_query($conexion_database, $consulta);
    /**-------------------------------------------------------------------------- */
    //$tabla = '<option value="0" selected>Selecciona Departamento</option>';
    $tabla='
        <form id="buscar_detalle_pago" name="buscar_detalle_pago" onsubmit="return Pagination_detalles_pago(1);">
            <div class="input-group mb-3 ps-3">
                <select class="form-select" name="select_busqueda_detalle_pago" id="select_busqueda_detalle_pago" required="">
                    <option selected disabled>Selecciona Buscar por Departamento</option>
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
                <button class="btn btn-outline-light" type="submit" id="button-addon2">Buscar</button>
            </div>  
        </form>
    ';
    //$array = array(0 => $tabla);
    echo $tabla;
    //echo json_encode($tabla);
    mysqli_free_result($resultado);
    mysqli_close($conexion_database);
?>