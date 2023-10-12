<?php 
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    $tabla = '';
    $estado = $_POST["estado"];
    $valor_municipio = $_POST["idmuni"];
    if($valor_municipio == 0){
        /*-------------------------Consultamos la Base de Datos----------------------*/
        $consulta = "SELECT  idMunicipio, nombreMunicipio FROM municipio WHERE estado_idEstado = '$estado' ORDER BY  idMunicipio";
        $registro = mysqli_query($conexion_database, $consulta);
        /**-------------------------------------------------------------------------- */
        $tabla = $tabla.'
            <option value="" selected disabled>Selecciona</option>
        ';
        while($row = mysqli_fetch_array($registro)){
            $tabla = $tabla.'
                <option value="'.$row["idMunicipio"].'">'.$row["nombreMunicipio"].'
                </option>
            ';
        }
    }else{
        $consulta = "SELECT idMunicipio, nombreMunicipio FROM municipio WHERE estado_idEstado = '$estado' AND idMunicipio = '$valor_municipio' ORDER BY  idMunicipio";
        $registro = mysqli_query($conexion_database, $consulta);
        while($row = mysqli_fetch_array($registro)){
            $tabla = $tabla.'
                <option value="'.$row["idMunicipio"].'">'.$row["nombreMunicipio"].'
                </option>
            ';
        }
    }
    $array = array(0 => $tabla);
    echo json_encode($array);
    mysqli_free_result($registro);
    mysqli_close($conexion_database);
?>