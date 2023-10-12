<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    //$tabla ='';
    $edificio_actual = null;
    /**Consultamos la BD para mostrar los registros encontrados---- */
    $consulta = "SELECT id_salon, nombre_salon, nombre_edificio FROM salon WHERE estatus = '1' ORDER BY nombre_edificio, nombre_salon";
    $registro = mysqli_query($conexion_database, $consulta);
    /**------------------------------------------------------------ */
    $tabla ='
        <span class="input-group-text"><i class="fa-solid fa-building-columns"></i></span>
        <select class="selectpicker form-control" data-live-search="true" name="salon_idsalon" id="salon_idsalon" required="">
        <option value="" selected disabled>Selecciona</option>
    ';
    //$tabla = array();
    while($row = mysqli_fetch_array($registro)){
        $id_salon = $row["id_salon"];
        $nombre_salon = $row["nombre_salon"];
        $nombre_edificio = $row["nombre_edificio"];
        if($nombre_edificio !== $edificio_actual){
            if($edificio_actual !== null){
                $tabla .= '</optgroup>';
            }
            $tabla .= '<optgroup label="Edificio '.$nombre_edificio.'">';
            $edificio_actual = $nombre_edificio;
        }
        $tabla .='
            <option value="'.$id_salon.'">'.$nombre_salon.'</option>
        ';
    }
    //Cerrar el ultimo grupo
    if($edificio_actual !== null){
        $tabla .= '</optgroup>';
    }
    $tabla .='
        </select>
    ';
    $array = array(0 => $tabla);
    //$array = array( 0 => $id, 1 => $nombre_completo);
    echo json_encode($array);
    mysqli_free_result($registro);
    mysqli_close($conexion_database);
?>