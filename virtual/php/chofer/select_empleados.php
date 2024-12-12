<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    //$tabla ='';
    /**Consultamos la BD para mostrar los registros encontrados---- */
    $consulta = "SELECT expediente, primerApellido, segundoApellido, nombres FROM empleados WHERE estatus = '1' ORDER BY expediente";
    $registro = mysqli_query($conexion_database, $consulta);
    /**------------------------------------------------------------ */
    $tabla ='
        <span class="input-group-text"><i class="fa-regular fa-id-badge"></i></span>
        <select class="selectpicker form-control" data-live-search="true" name="exp_emp_chofer" id="exp_emp_chofer" required="">
            <option value="" selected disabled>Selecciona</option>
    ';
    //$tabla = array();
    while($row = mysqli_fetch_array($registro)){
        $apepat = $row["primerApellido"];
        $apemat = $row["segundoApellido"];
        $nombre = $row["nombres"];
        $id = $row["expediente"];
        $nombre_completo = $id.' '.$nombre.' '.$apepat.' '.$apemat;
        $tabla = $tabla.'
            <option value="'.$row["expediente"].'">'.$nombre_completo.'</option>
        ';
    }
    $tabla = $tabla.'
        </select>
    ';
    $array = array(0 => $tabla);
    //$array = array( 0 => $id, 1 => $nombre_completo);
    echo json_encode($array);
    mysqli_free_result($registro);
    mysqli_close($conexion_database);
?>