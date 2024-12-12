<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");
    $paginaActual = $_POST["partida"];
    $dato = $_POST["dato"] ?? null;//si no tiene ningun valor lo pasamos a nulo
    $ideliminar = $_POST["ideliminar"];
    $id_pago_padre = $_POST["id_pago"];
    date_default_timezone_set('America/Mexico_City');
    $fecha = date('Y-m-d');
    $usuario = $id_software_sesion;
    $proceso = "Eliminar";

    //$dato = sanear_normal($dato);

    /*-----Verificación de eliminar---------------------------------------------------------------------------------*/
    if($ideliminar > 0){
        $eliminar="UPDATE detalle_pagos SET estatus='0', fecha_movimiento = '$fecha', ultimo_movimiento = '$proceso', 
        usuario_movimiento = '$usuario' WHERE id_detalle_pago='$ideliminar' LIMIT 1";
        $resultado_elimina=mysqli_query($conexion_database, $eliminar);
    }
    /*--------------------------------------------------------------------------------------------------------------*/
    /**----------------Consultamos en número en la BD-------------------------------------------------------------- */
    /**Verificamos si $dato viene con algun valor */
    if(empty($dato)){
        /**Si viene vacio nos mostrara todos los registros que correspondan al pago que seleccionamos y tengan estatus de 1 */
        $consulta_1 = "SELECT id_detalle_pago FROM detalle_pagos WHERE pagos_id_pago = '$id_pago_padre' AND estatus = '1'";

    }else{
        //si no viene vacio, es decir se selecciono un departamento filtramos por el departamento el pago padre y con estatus sea 1
        $consulta_1 = "SELECT id_detalle_pago FROM detalle_pagos WHERE unidad_clave_unidad = '$dato' AND pagos_id_pago = '$id_pago_padre' AND estatus = '1'";
    }
    $resultado_1 = mysqli_query($conexion_database, $consulta_1);
    $nroProductos = mysqli_num_rows($resultado_1);
    /**------------------------------------------------------------------------------------------------------------ */
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
            <a class="page-link" href="#Anterior" aria-label="Previous" onclick="Pagination_detalles_pago('.($paginaActual-1).');">
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
                    <a class="page-link" href="#Paginar" onclick="Pagination_detalles_pago('.$i.');">'.$i.'</a>
                </li>
            ';
        }else{
            $lista = $lista.'
                <li class="page-item">
                    <a class="page-link" href="#Paginar" onclick="Pagination_detalles_pago('.$i.');">'.$i.'</a>
                </li>
            ';
        }
    }
    if($paginaActual < $nroPaginas){
        $lista = $lista.'
            <li class="page-item">
                <a class="page-link" href="#Siguiente" aria-label="Next" onclick="Pagination_detalles_pago('.($paginaActual+1).');">
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
    /**Verificamos si $dato viene con algun valor */
    if(empty($dato)){
        /**Si viene vacio nos mostrara todos los registros que correspondan al pago que seleccionamos y tengan estatus de 1 */
        $consulta_2 = "SELECT id_detalle_pago AS id, monto_detalle_pago, nombreUnidad FROM detalle_pagos INNER JOIN estructuraorganica ON detalle_pagos.unidad_clave_unidad = estructuraorganica.claveUnidad WHERE pagos_id_pago = '$id_pago_padre' AND detalle_pagos.estatus = '1' ORDER BY id_detalle_pago DESC LIMIT $limit, $nroLotes";

    }else{
        //si no viene vacio, es decir se selecciono un departamento filtramos por el departamento el pago padre y con estatus sea 1
        $consulta_2 = "SELECT id_detalle_pago AS id, monto_detalle_pago, nombreUnidad FROM detalle_pagos INNER JOIN estructuraorganica ON detalle_pagos.unidad_clave_unidad = estructuraorganica.claveUnidad WHERE unidad_clave_unidad = '$dato' AND pagos_id_pago = '$id_pago_padre' AND detalle_pagos.estatus = '1' ORDER BY id_detalle_pago DESC LIMIT $limit, $nroLotes";
    }
    $registro_2 = mysqli_query($conexion_database, $consulta_2);
    if (!$registro_2) {
        die("Error en la consulta: " . mysqli_error($conexion_database));
    }
    $no_filas = mysqli_num_rows($registro_2);
    /**---------------------------------------------------------- */
    $tabla = $tabla.'<div class="table-responsive">
                        <table class="table table-hover table-bordered">';
    if($no_filas > 0){
        $tabla = $tabla.'
                            <thead>
                                <tr>
                                    <th><i class="fa-solid fa-gear"></i></th>
                                    <th>Departamento</th>
                                    <th>Monto Detalle Pago</th>
                                    <th>Porcentaje del Detalle de Pago</th>
                                </tr>
                            </thead>
                            <tbody>
        ';
        $monto_total_detalle = 0;
        $porcentaje_total_detalle = 0;
        $porcentaje_pago_real = 100.00;
        $porcentaje_pago_real = number_format($porcentaje_pago_real, 2);
        $consulta_3 = "SELECT monto_total FROM pagos WHERE id_pago = '$id_pago_padre'";
        $resultado_3 = mysqli_query($conexion_database, $consulta_3);
        while($row_pago = mysqli_fetch_array($resultado_3)){
            $monto_pago = $row_pago['monto_total'];
        }
        mysqli_free_result($resultado_3);
        while($row = mysqli_fetch_array($registro_2)){
            $id = $row["id"];
            $monto_detalle = $row["monto_detalle_pago"];
            $departamento = $row["nombreUnidad"];
            if ($monto_pago > 0) {
                $porcentaje_detalle = ($monto_detalle * 100) / $monto_pago; // Cálculo del porcentaje
            } else {
                $porcentaje_detalle = 0; // O manejar el caso de error según lo necesites
            }      
            $monto_total_detalle = $monto_total_detalle + $monto_detalle;
            $porcentaje_total_detalle = $porcentaje_total_detalle + $porcentaje_detalle;
            $porcentaje_detalle = number_format($porcentaje_detalle, 2);   
            $porcentaje_total_detalle = number_format($porcentaje_total_detalle,2);
            
            $tabla = $tabla.'
                                <tr>
                                    <td align="center">
                                        <button type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Actualizar Chofer" onclick="Actualizar_detalle_pago('.$id.');">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Eliminar Chofer" onclick="Eliminar_detalle_pago('.$id.');">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </td>
                                    <td>'.$departamento.'</td>
                                    <td>$'.number_format($monto_detalle, 2, '.', ',').'</td>
                                    <td>'.$porcentaje_detalle.'%</td>
                                </tr>
            ';
        }
        $porcentaje_diferencia = number_format(($porcentaje_pago_real - $porcentaje_total_detalle), 2);
        $monto_diferencia = number_format(($monto_pago - $monto_total_detalle), 2);
        if($monto_diferencia == 0 && $porcentaje_diferencia == 0){
            $notificacion = '<span class="badge text-bg-success">Ya se cumplio con el total del Pago</span>';
        }else if($monto_diferencia == $monto_pago && $porcentaje_diferencia == $porcentaje_pago_real){
            $notificacion = '<span class="badge text-bg-danger">No se han registrado pagos</span>';
        }else{
            $notificacion = '<span class="badge text-bg-warning">Aun faltan Pagos por registrar</span>';
        }
        $porcentaje_diferencia = number_format((float)$porcentaje_diferencia, 2, '.', ',');
        $tabla = $tabla.'
                                <tr class="table-active">
                                    <th colspan="2">Avance del Detalle Pago</th>
                                    <td>$'.number_format($monto_total_detalle,2, '.', ',').'</td>
                                    <td>'.$porcentaje_total_detalle.'%</td>
                                </tr>
                                <tr class="table-active">
                                    <th colspan="2">Total del Pago</th>
                                    <td>$'.number_format($monto_pago, 2).'</td>
                                    <td>'.$porcentaje_pago_real.'%</td>
                                </tr>
                                <tr class="table-active">
                                    <th>Diferencia</th>
                                    <th class="text-center">'.$notificacion.'</th>
                                    <td>$'.$monto_diferencia.'</td>
                                    <td>'.$porcentaje_diferencia.'%</td>
                                </tr>
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

