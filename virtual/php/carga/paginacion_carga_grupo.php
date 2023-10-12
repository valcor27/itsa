<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    //$tabla ='';
    $division_actual = null;
    /**Consultamos la BD para mostrar los registros encontrados---- */
    $consulta = "SELECT id_grupo, nombre_grupo, nombre_division FROM grupo WHERE estatus = '1' ORDER BY nombre_division, nombre_grupo";
    $registro = mysqli_query($conexion_database, $consulta);
    /**------------------------------------------------------------ */
    $tabla ='
        <span class="input-group-text"><i class="fa-solid fa-users"></i></span>
        <select class="selectpicker form-control" data-live-search="true" name="grupo_idgrupo" id="grupo_idgrupo" onchange="Pagination_carga_docente_materia();" required="">
        <option value="" selected disabled>Selecciona</option>
    ';
    //$tabla = array();
    while($row = mysqli_fetch_array($registro)){
        $id_grupo = $row["id_grupo"];
        $nombre_grupo = $row["nombre_grupo"];
        $nombre_division = $row["nombre_division"];
        if($nombre_division !== $division_actual){
            if($division_actual !== null){
                $tabla .= '</optgroup>';
            }
            $tabla .= '<optgroup label="'.$nombre_division.'">';
            $division_actual = $nombre_division;
        }
        $tabla .='
            <option value="'.$id_grupo.'">'.$nombre_grupo.'</option>
        ';
    }
    //Cerrar el ultimo grupo
    if($division_actual !== null){
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