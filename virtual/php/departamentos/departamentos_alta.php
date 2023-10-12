<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    $tabla = '';
    $tipo = $_POST["tipo_doc"];
    $departamento = $_POST["valor_departamento"];
    if($departamento == 0){
        /**--------------Consultamos la base de datos-------------- */
        $consulta = "SELECT id_departamento_doc_alta, nombre_departamento_doc_alta 
        FROM departamentos_externos WHERE tipo_doc = '$tipo' ORDER BY id_departamento_doc_alta";
        $registro = mysqli_query($conexion_database, $consulta);
        /**-------------------------------------------------------- */
        $tabla = $tabla.'
            <option value="" selected disabled>Selecciona</option>
        ';
        while($row = mysqli_fetch_array($registro)){
            $tabla = $tabla.'
                <option value="'.$row["id_departamento_doc_alta"].'">'.$row["nombre_departamento_doc_alta"].'</option>
            ';
        }
    }else{
        $consulta = "SELECT id_departamento_doc_alta, nombre_departamento_doc_alta 
        FROM departamentos_externos WHERE tipo_doc = '$tipo' AND id_departamento_doc_alta = '$departamento' ORDER BY id_departamento_doc_alta";
        $registro = mysqli_query($conexion_database, $consulta);
        while($row = mysqli_fetch_array($registro)){
            $tabla = $tabla.'
                <option value="'.$row["id_departamento_doc_alta"].'">'.$row["nombre_departamento_doc_alta"].'
                </option>
            ';
        }
    }
    $array = array(0 => $tabla);
    echo json_encode($array);
    mysqli_free_result($registro);
    mysqli_close($conexion_database);
?>