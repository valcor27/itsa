<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");
    $proceso = $_POST["proceso_docente"];
    $id = $_POST["id_docente"];
    $clave = $_POST["clave_docente"];
    $expediente = $_POST["exp_doc"];
    $estatus = 1;
    $comprobacion = "0";
    date_default_timezone_set('America/Mexico_City');
    $fecha = date('Y-m-d');
    $usuario = $id_software_sesion;
    /**---------------buscamos el nombre del docente---------------- */
    if($expediente >= 1){
        $consulta_docente = "SELECT primerApellido, segundoApellido, nombres FROM empleados WHERE expediente = '$expediente' LIMIT 1";
        $resultado_docente = mysqli_query($conexion_database, $consulta_docente);
        while($reg_docente = mysqli_fetch_array($resultado_docente)){
            $apepat = $reg_docente["primerApellido"];
            $apemat = $reg_docente["segundoApellido"];
            $nombre = $reg_docente["nombres"];
            $nombre_completo = $nombre.' '.$apepat.' '.$apemat;
            $nombre_completo = sanear_string($nombre_completo);
        }
        mysqli_free_result($resultado_docente);
    }
    /**------------------------------------------------------------- */
    switch ($proceso) {
        case 'Registro':
            /**Corroboramos que no se duplique el expediente del docente */
            $consulta_comparar = "SELECT id_docentes FROM docentes WHERE empleados_expediente = '$expediente' AND estatus = '1' LIMIT 1";
            $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
            $filas_comparar = mysqli_num_rows($resultado_comparar);
            mysqli_free_result($resultado_comparar);
            /**--------------------------------------------------------- */
            if($filas_comparar == 0){
                /**----Insertamos si no se duplican---------------- */
                $inserta = "INSERT INTO docentes(empleados_expediente, clave,
                nombre_docente, estatus, fecha_movimiento, ultimo_movimiento,
                usuario_movimiento)VALUES('$expediente','$clave','$nombre_completo',
                '$estatus','$fecha','$proceso','$usuario')";
                $respuesta = mysqli_query($conexion_database, $inserta);
                /**------------------------------------------------ */
            }else{
                $comprobacion = "1";
            }    
        break;
        case 'Edicion':
        /**----------------Corroboramos que no se duplique el expediente del docente---- */
        $consulta_comparar = "SELECT id_docentes FROM docentes WHERE id_docentes <> '$id' AND empleados_expediente = '$expediente' AND estatus = '1' LIMIT 1";
        $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
        $filas_comparar = mysqli_num_rows($resultado_comparar);

        mysqli_free_result($resultado_comparar);
        /**----------------------------------------------------------------------------- */
        if($filas_comparar == 0){
            $actualiza = "UPDATE docentes SET empleados_expediente = '$expediente', 
            clave = '$clave', nombre_docente = '$nombre_completo', 
            fecha_movimiento = '$fecha', ultimo_movimiento = '$proceso',
            usuario_movimiento = '$usuario' WHERE id_docentes = '$id' LIMIT 1";
            $respuesta = mysqli_query($conexion_database, $actualiza);
        }else{
            $comprobacion = "1";
        }
        break;
    }
    $lista_info = '';
    $lista = '';
    $tabla = '';
    /**---Lista de informacion de paginas------- */
    $lista_info = $lista_info.'Pag. 1/1';
    /**----------------------------------------- */
    /**Realizamos la paginacion para tabletas y pc----------- */
    $lista = $lista.'
        <ul class="pagination linea_derecha">
            <li class="page-item disabled">
                <a class="page-link" href="#Anterior">
                    <i class="fas fa-arrow-alt-circle-left"></i>
                </a>
            </li>

            <li class="page-item active">
                <a class="page-link" href="#Paginar">1</a>
            </li>

            <li class="page-item disabled">
                <a class="page-link" href="#Siguiente">
                   <i class="fas fa-arrow-alt-circle-right"></i>
                </a>
            </li>
        </ul>
    ';
/**------------------------------------------------------ */
/**Consultamos la base de datos completa para mostrar el registro------ */
    $consulta = "SELECT id_docentes AS id, empleados_expediente, nombre_docente, clave FROM docentes WHERE empleados_expediente = '$expediente' AND estatus = '1' LIMIT 1";
    $registro = mysqli_query($conexion_database, $consulta);
    $filas_venta = mysqli_num_rows($registro);
/**-------------------------------------------------------------------- */
$tabla = $tabla.'
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-list table-hover">
        <thead>
            <tr>
                <th><i class="fa-solid fa-gear"></i></th>
                <th>No. Expediente</th>
                <th>Clave Docente</th>
                <th>Nombre</th>
                <th>Carga Académica</th>
            </tr>
        </thead>
        <tbody>
';
while($row = mysqli_fetch_array($registro)){
    $id = $row["id"];
    $expediente = $row["empleados_expediente"];
    $nombre = $row["nombre_docente"];
    $clave = $row["clave"];
    $tabla = $tabla.'
        <tr>
            <td align="center">
                <button type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Actualizar Docente" onclick="Actualizar_docente('.$id.');">
                    <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Eliminar Docente" onclick="Eliminar_docente('.$id.');">
                    <i class="far fa-trash-alt"></i>
                </button>
                <button type="button" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Educación del Docente" onclick="Modal_educacion_docente('.$id.');">
                    <i class="fa-solid fa-user-graduate"></i>
                </button>
            </td>
            <td>'.$expediente.'</td>
            <td>'.$clave.'</td>
            <td>'.$nombre.'</td>
            <td align="center">
                <button type="button" class="btn btn-primary" onclick="Carga_docente('.$id.');">
                    <i class="fa-solid fa-person-chalkboard"></i>
                </button>
            </td>
        </tr>
    '; 
}
$tabla = $tabla.'
    </tbody>
    </table>
    </div>
';
$array = array(
    0 => $tabla,
    1 => $lista_info,
    2 => $lista,
    3 => $comprobacion
);
echo json_encode($array);

mysqli_free_result($registro);
mysqli_close($conexion_database);
?>