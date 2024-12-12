<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");
    $paginaActual = $_POST['partida'];
    $dato = $_POST['dato'];
    $ideliminar = $_POST['ideliminar'];
    date_default_timezone_set('America/Mexico_City');
    $fecha = date('Y-m-d');
    $dato = sanear_normal($dato);
    $proceso = "Eliminar";
    $usuario = $id_software_sesion;

    /**Verificacion de eliminar---------------------------------- */
    if($ideliminar > 0){
        $eliminar = "UPDATE dia_inhabil
        SET estatus = '0', fecha_movimiento = '$fecha',
            ultimo_movimiento = '$proceso', usuario_movimiento = '$usuario'  
            WHERE id_dia_inhabil = '$ideliminar' LIMIT 1
        ";
        $resultado_eliminar = mysqli_query($conexion_database, $eliminar);
    }
    /**---------------------------------------------------------- */
    /**--------Consultamos el numero de datos en BD-------------- */
    $consulta_1 = "SELECT id_dia_inhabil FROM dia_inhabil WHERE (concepto LIKE '%$dato%') AND estatus = '1'";
    $resultado_1 = mysqli_query($conexion_database, $consulta_1);
    $nroProductos = mysqli_num_rows($resultado_1);

    mysqli_free_result($resultado_1);

    $nroLotes = 5;
    $nroPaginas = ceil($nroProductos/$nroLotes);
    $tabla = '';
    $lista_info = '';
    $lista = '';

    $min = $paginaActual - ($paginaActual % 5) + 1;
    if($min > $paginaActual){$min = $min - 5;}

    $max = $min + 4 > $nroPaginas ? $nroPaginas : $min + 4;
    /**---------------------------------------------------------- */
    /**----------------Lista de informacion de paginas----------- */
    $lista_info = $lista_info.' Pag. '.$paginaActual.' / '.$nroPaginas.' ';
    /**---------------------------------------------------------- */
    /**-------Paginacion para tabletas y PC---------------------- */
    $lista = $lista.'<ul class="pagination">';
    if($paginaActual > 1){
        $lista = $lista.'
        <li class="page-item">
            <a class="page-link" href="#Anterior" aria-label="Previous" onclick="Pagination_dia_inhabil('.($paginaActual-1).');">
                <i class="fas fa-arrow-alt-circle-left"></i>
            </a>
        </li>';
    }else{
        $lista = $lista.'
        <li class="page-item disabled">
            <a class="page-link" href="#Anterior">
                <i class="fas fa-arrow-alt-circle-left"></i>
            </a>
        </li>';
    }
    for($i = $min; $i <= $max; $i++){
        if($i == $paginaActual){
            $lista = $lista.'
                <li class="page-item active">
                    <a class="page-link" href="#Paginar" onclick="Pagination_dia_inhabil('.$i.');">'.$i.'</a>
                </li>
            ';
        }else{
            $lista = $lista.'
                <li class="page-item">
                    <a class="page-link" href="#Paginar" onclick="Pagination_dia_inhabil('.$i.');">'.$i.'</a>
                </li>
            ';
        }
    }
    if($paginaActual < $nroPaginas){
        $lista = $lista.'
            <li class="page-item">
                <a class="page-link" href="#Siguiente" aria-label="Next" onclick="Pagination_dia_inhabil('.($paginaActual+1).');">
                    <i class="fas fa-arrow-alt-circle-right"></i>
                </a>
            </li>
        ';
    }else{
        $lista = $lista.'
            <li class="page-item disabled">
                <a class="page-link" href="#Siguiente">
                    <i class="fas fa-arrow-alt-circle-right"></i>
                </a>
            </li>
        ';
    }
    $lista = $lista.'</ul>';
    /**---------------------------------------------------------- */
    /**-------Obtencion de Datos BD------------------------------ */
    if($paginaActual <= 1){
        $limit = 0;
    }else{
        $limit = $nroLotes*($paginaActual-1);
    }
    /**---------------------------------------------------------- */
    /**Consulta Bd para mostrar registros encontrados------------ */
    $consulta_2 = "SELECT id_dia_inhabil AS id, fecha_dia_inhabil, concepto FROM dia_inhabil WHERE (concepto  LIKE '%$dato%') AND estatus = '1' ORDER BY fecha_dia_inhabil DESC LIMIT $limit, $nroLotes";
    $registro_2 = mysqli_query($conexion_database, $consulta_2);
    /*if (!$registro_2) {
        die("Error en la consulta: " . mysqli_error($conexion_database));
    }*/
    $no_filas = mysqli_num_rows($registro_2);
    /**---------------------------------------------------------- */
    $tabla = $tabla.'<div class="table-responsive">
                        <table class="table table-hover table-bordered">';
    if($no_filas > 0){
        $tabla = $tabla.'
                            <thead>
                                <tr>
                                    <th><i class="fa-solid fa-gear"></i></th>
                                    <th>Fecha</th>
                                    <th>Concepto</th>
                                </tr>
                            </thead>
                            <tbody>
        ';
        while($row = mysqli_fetch_array($registro_2)){
            $id = $row["id"];
            $fecha = date("d-m-Y", strtotime($row["fecha_dia_inhabil"]));
            $concepto = $row["concepto"];
            $tabla = $tabla.'
                                <tr>
                                    <td align="center">
                                        <button type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Actualizar Día Inhabil" onclick="Actualizar_dia_inhabil('.$id.');">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Eliminar Día Inhábil" onclick="Eliminar_dia_inhabil('.$id.');">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </td>
                                    <td>'.$fecha.'</td>
                                    <td>'.$concepto.'</td>
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
    ';
    $array = array(
        0 => $tabla,
        1 => $lista_info,
        2 => $lista
    );
    echo json_encode($array);
    mysqli_free_result($registro_2);
    mysqli_close($conexion_database);
?>