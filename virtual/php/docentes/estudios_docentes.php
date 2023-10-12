<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");
    $id = $_POST["id"];
    $tabla='';
    $nombre='';
    $clave='';
    $expediente='';
    //$docente='';
    /**-----Consultamos la BD para mostrar los registros------ */
    $consulta = "SELECT 
	    docente_nivel_estudio.id_docente_nivel_estudio AS id,
        /*docente_nivel_estudio.docentes_id_docentes AS id_docente,*/
        docentes.nombre_docente AS nombre,
        docentes.clave AS clave,
        docentes.empleados_expediente AS expediente,
        nivel_estudio.nombre_nivel_estudio AS nivel,
        docente_nivel_estudio.titulo AS titulo,
        docente_nivel_estudio.cedula AS cedula,
        docente_nivel_estudio.escuela AS escuela
    FROM 
        docente_nivel_estudio
    JOIN
        docentes ON docente_nivel_estudio.docentes_id_docentes = docentes.id_docentes
    JOIN 
        nivel_estudio ON docente_nivel_estudio.nivel_estudio_id_nivel_estudio = nivel_estudio.id_nivel_estudio
    WHERE docente_nivel_estudio.docentes_id_docentes = '$id' AND docente_nivel_estudio.estatus = '1'";
    $registro = mysqli_query($conexion_database, $consulta);
    $no_filas = mysqli_num_rows($registro);
    /**------------------------------------------------------- */
    $tabla = $tabla.'
        <div class="row justify-content-center">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
    ';
    if($no_filas > 0){
        $tabla = $tabla.'
                    <thead>
                        <tr>
                            <th><i class="fa-solid fa-gear"></i></th>
                            <th>Nivel</th>
                            <th>Titulo</th>
                            <th>Cedula</th>
                            <th>Escuela de Egreso</th>
                        </tr>
                    </thead>
                    <tbody>
        ';
        while($row = mysqli_fetch_array($registro)){
            $id = $row["id"];
            $nombre = $row["nombre"];
            $clave = $row["clave"];
            $expediente = $row["expediente"];
            $nivel = $row["nivel"];
            $titulo = $row["titulo"];
            $cedula = $row["cedula"];
            $escuela = $row["escuela"];
            //$docente = $row["id_docente"];
            $tabla = $tabla.'
                        <tr>
                            <td>
                                <button type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Actualizar Estudio" onclick="Actualizar_estudio_docente('.$id.');">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Eliminar Estudio" onclick="Eliminar_estudio_docente('.$id.');">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </td>
                            <td>'.$nivel.'</td>
                            <td>'.$titulo.'</td>
                            <td>'.$cedula.'</td>
                            <td>'.$escuela.'</td>
                        </tr>
            ';
        }
        $tabla = $tabla.'
                    </tbody>
        ';
    }else{
        $tabla = $tabla.'
                    <div class="alert alert-info">
                        <strong>Mensaje!</strong> No se encontro ningún registro.
                    </div>
        ';
    }
    $tabla = $tabla.'
                </table>
            </div>
        </div>
    ';
    $array = array(
        0 => $tabla,
        1 => $nombre,
        2 => $clave,
        3 => $expediente
        //4 => $docente 
    );
    echo json_encode($array);
    mysqli_free_result($registro);
    mysqli_close($conexion_database);
?>