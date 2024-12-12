<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    $tabla = '';
    /**Consultamos la base de datos para obtener registros -----------*/
        $consulta = "SELECT id_combustible, nombre FROM combustible WHERE estatus = '1' ORDER BY id_combustible ASC";
        $resultado = mysqli_query($conexion_database, $consulta);
        $tabla = $tabla.'
            <option selected disabled value="">Selecciona</option>
        ';
        while($row = mysqli_fetch_array($resultado)){
            $tabla = $tabla.'
                <option value="'.$row["id_combustible"].'">'.$row["nombre"].'</option>
            ';
        }
    /**-------------------------------------------------------------- */
    $array = array(0 => $tabla);

    echo json_encode($array);

    mysqli_free_result($resultado);

    mysqli_close($conexion_database);
?>