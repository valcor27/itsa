<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");

    //Inicialización de variables y obtención de parámetros POST
    $paginaActual = $_POST["partida"];
    $dato = $_POST["dato"] ?? null; //Si no tiene valor, lo pasamos a nulo
    $ideliminar = $_POST["ideliminar"];
    $id_pago_padre = $_POST["id_pago"];
    date_default_timezone_set('America/Mexico_City');
    $fecha = date('Y-m-d');
    $usuario = $id_software_sesion;
    $proceso = "Eliminar";

    //Verificamos si se va a eliminar un dato
    if($ideliminar > 0){
        $eliminar = "UPDATE detalle_pagos SET estatus='0', fecha_movimiento = '$fecha', ultimo_movimiento = '$proceso', usuario_movimiento = '$usuario' WHERE id_detalle_pago = '$ideliminar' LIMIT 1";
        $resultado_elimina = mysqli_query($conexion_database, $eliminar);
    }

    //Consulta total de registros según filtro
    if(empty($dato)){
        $consulta_1 = "SELECT id_detalle_pago FROM detalle_pagos WHERE pagos_id_pago = '$id_pago_padre' AND estatus = '1'";
    }else{
        $consulta_1 = "SELECT id_detalle_pago FROM detalle_pagos WHERE unidad_clave_unidad = '$dato' pagos_id_pago = '$id_pago_padre' AND estatus = '1'";
    }
    $resultado_1 = mysqli_query($conexion_database, $consulta_1);
    $nroProductos = mysqli_num_rows($resultado_1);
    mysqli_free_result($resultado_1);

    //variables de paginación
    $nroLotes = 5;
    $nroPaginas = ceil($nroProductos / $nroLotes);

    //calculo de límites para la paginación
    $limit = ($paginaActual - 1) * $nroLotes;

    //Consulta para el monto total del pago
    $consulta_3 = "SELECT monto_total FROM pagos WHERE id_pago = '$id_pago_padre' AND estatus = '1'";
    $resultado_3 = mysqli_query($conexion_database, $consulta_3);
    $monto_pago = 0;
    if($row_pago = mysqli_fetch_array($resultado_3)){
        $monto_pago = $row_pago["monto_total"];
    }
    mysqli_free_result($resultado_3);

    //consulta de detalles según paginación
    if(empty($dato)){
        $consulta_2 = "SELECT id_detalle_pago AS id, monto_detalle_pago, nombreUnidad 
                        FROM detalle_pagos 
                        INNER JOIN estructuraorganica 
                        ON detalle_pagos.unidad_clave_unidad = estructuraorganica.claveUnidad 
                        WHERE pagos_id_pago = '$id_pago_padre' AND detalle_pagos.estatus = '1' 
                        ORDER BY id_detalle_pago DESC LIMIT $limit, $nroLotes";
    }else{
        $consulta_2 = "SELECT id_detalle_pago AS id, monto_detalle_pago, nombreUnidad 
                        FROM detalle_pagos 
                        INNER JOIN estructuraorganica 
                        ON detalle_pagos.unidad_clave_unidad = estructuraorganica.claveUnidad 
                        WHERE unidad_clave_unidad = '$dato' AND pagos_id_pago = '$id_pago_padre' 
                        AND detalle_pagos.estatus = '1' 
                        ORDER BY id_detalle_pago DESC LIMIT $limit, $nroLotes";
    }
    $registro_2 = mysqli_query($conexion_database, $consulta_2);
    if(!$registro_2){
        die("Error en la consulta: " . mysqli_error($conexion_database));
    }
    //variables para acumular totales
    $monto_total_detalle = 0;
    $porcentaje_total_detalle = 0;

    //Generamos la tabla
    $tabla = '<div class="table-responsive"><table class="table table-hover table-bordered">';
    if(mysqli_num_rows($registro_2) > 0){
        $tabla .= '
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
        while($row = mysqli_fetch_array($registro_2)){
            $id = $row["id"];
            $monto_detalle = $row["monto_detalle_pago"];
            $departamento = $row["nombreUnidad"];

            $porcentaje_detalle = $monto_pago > 0 ? ($monto_detalle * 100) / $monto_pago : 0;
            $monto_total_detalle += $monto_detalle;
            $porcentaje_total_detalle += $porcentaje_detalle;
            $tabla .= '
                        <tr>
                            <td align="center">
                                <button type="button" class="btn btn-warning" onclick="Actualizar_detalle_pago(' . $id . ');"><i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-danger" onclick="Eliminar_detalle_pago(' . $id . ');"><i class="far fa-trash-alt"></i></button>
                            </td>
                            <td>' . $departamento . '</td>
                            <td>$' . number_format($monto_detalle, 2, '.', ',') . '</td>
                            <td>' . number_format($porcentaje_detalle, 2) . '%</td>
                       </tr>
            ';
        }

        $porcentaje_diferencia = number_format((100.00 - $porcentaje_total_detalle), 2);
        $monto_diferencia = number_format(($monto_pago - $monto_total_detalle), 2);

        //Notificación según los totales
        if($monto_diferencia == 0 && $porcentaje_diferencia == 0){
            $notificacion = '<span class="badge text-bg-success">Ya se cumplió con el total del Pago</span>';
        } else if ($monto_diferencia == $monto_pago && $porcentaje_diferencia == 100.00){
            $notificacion = '<span class="badge text-bg-danger">No se han registrado pagos</span>';
        } else {
            $notificacion = '<span class="badge text-bg-warning">Aun faltan Pagos por registrar</span>';
        }

        //Mostramos el resumen de totales
        $tabla = '
                        <tr class="table-active">
                            <th colspan="2">Avance del Detalle Pago</th>
                            <td>$'.number_format($monto_total_detalle, 2).'</td>
                            <td>'.number_format($porcentaje_total_detalle, 2).'%</td>
                        </tr>
                        <tr class="table-active">
                            <th colspan="2">Total del Pago</th>
                            <td>$'.number_format($monto_pago, 2).'</td>
                            <td>100.00%</td>
                        </tr>
                        <tr class="table-active">
                            <th>Diferencia</th>
                            <th class="text-center">'.$notificacion.'</th>
                            <td>$'.$monto_diferencia.'</td>
                            <td>'.$porcentaje_diferencia.'%</td>
                        </tr>
        ';
    }else{
        $tabla .= '<div class="alert alert-info"><strong>Mensaje!</strong> No se encontró ningún registro.</div>';
    }
    $tabla .= '</tbody></table></div>';

    //Generación de paginación
    $lista = '<ul class="pagination">';
    $min = $paginaActual - ($paginaActual % 5) + 1;
    $max = min($nroPaginas, $min + 4);

    if ($paginaActual > 1) {
        $lista .= '<li class="page-item"><a class="page-link" href="#Anterior" onclick="Pagination_detalles_pago(' . ($paginaActual - 1) . ');"><i class="fas fa-arrow-alt-circle-left"></i></a></li>';
    } else {
        $lista .= '<li class="page-item disabled"><a class="page-link" href="#Anterior"><i class="fas fa-arrow-alt-circle-left"></i></a></li>';
    }

    for ($i = $min; $i <= $max; $i++) {
        $activeClass = ($i == $paginaActual) ? 'active' : '';
        $lista .= '<li class="page-item ' . $activeClass . '"><a class="page-link" href="#' . $i . '" onclick="Pagination_detalles_pago(' . $i . ');">' . $i . '</a></li>';
    }

    if ($paginaActual < $nroPaginas) {
        $lista .= '<li class="page-item"><a class="page-link" href="#Siguiente" onclick="Pagination_detalles_pago(' . ($paginaActual + 1) . ');"><i class="fas fa-arrow-alt-circle-right"></i></a></li>';
    } else {
        $lista .= '<li class="page-item disabled"><a class="page-link" href="#Siguiente"><i class="fas fa-arrow-alt-circle-right"></i></a></li>';
    }
    $lista .= '</ul>';
    /**----------------Lista de informacion de paginas----------- */
    $inicio = $limit + 1;
    $fin = min($limit + $nroLotes, $nroProductos);
    $lista_info = '<p>Mostrando ' . $inicio . ' a ' . $fin . ' de ' . $nroProductos . ' registros</p>';
    /**---------------------------------------------------------- */
    //Envio de respuesta JSON con tabla, paginación y lista_info
    $array = array(
        0 => $tabla,
        1 => $lista_info,
        2 => $lista
    );
    echo json_encode($array);
    mysqli_free_result($registro_2);
    mysqli_close($conexion_database);
?>