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

    /**Verificamos despues si se necesita el eliminar */
    /**---------------------------------------------- */
    /**-Consultamos el numero de datos en la BD------ */
    $consulta_1 = "SELECT id_pago FROM pagos WHERE (poliza LIKE '%$dato%' OR folio_fiscal LIKE '%$dato%' OR concepto LIKE '%$dato%') AND estatus = '1'";
    $resultado_1 = mysqli_query($conexion_database, $consulta_1);
    $nroProductos = mysqli_num_rows($resultado_1);

    mysqli_free_result($resultado_1);

    $nroLotes = 10;
    $nroPaginas = ceil($nroProductos/$nroLotes);
    $tabla = '';
    $lista_info = '';
    $lista = '';

    $min = $paginaActual - ($paginaActual % 5) + 1;
    if($min > $paginaActual){
        $min = $min - 5;
    }
    $max = $min + 4 > $nroPaginas ? $nroPaginas : $min + 4;
    /**---------------------------------------------- */
    /**----------------Lista de informacion de paginas----------- */
    $lista_info = $lista_info.' Pag. '.$paginaActual.' / '.$nroPaginas.' ';
    /**---------------------------------------------------------- */
    /**-------Paginacion para tabletas y PC---------------------- */
    $lista = $lista.'<ul class="pagination">';
    if($paginaActual > 1){
        $lista = $lista.'
        <li class="page-item">
            <a class="page-link" href="#Anterior" aria-label="Previous" onclick="Pagination_pagos('.($paginaActual-1).');">
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
                    <a class="page-link" href="#Paginar" onclick="Pagination_pagos('.$i.');">'.$i.'</a>
                </li>
            ';
        }else{
            $lista = $lista.'
                <li class="page-item">
                    <a class="page-link" href="#Paginar" onclick="Pagination_pagos('.$i.');">'.$i.'</a>
                </li>
            ';
        }
    }
    if($paginaActual < $nroPaginas){
        $lista = $lista.'
            <li class="page-item">
                <a class="page-link" href="#Siguiente" aria-label="Next" onclick="Pagination_pagos('.($paginaActual+1).');">
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
    //Boton para ir a la última página
    $lista .= '
        <li class="page-item">
            <a class="page-link" href="#Ultima" aria-label"Last" onclick="Pagination_pagos('.$nroPaginas.');">
                <i class="fas fa-fast-forward"></i>
            </a>
        </li>
    ';
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
    /*$consulta_2 = "SELECT id_pago AS id, poliza, partida, fecha_pago, folio_fiscal, concepto, monto_total, IFNULL(SUM(monto_detalle_pago), 0) AS total_detalle_pago FROM pagos INNER JOIN detalle_pagos ON pagos.id_pago = detalle_pagos.pagos_id_pago WHERE (poliza LIKE '%$dato%' OR folio_fiscal LIKE '%$dato%') AND estatus = '1' ORDER BY fecha_pago DESC LIMIT $limit, $nroLotes";*/
    $consulta_2 = "SELECT 
        id_pago AS id, 
        poliza, 
        partida, 
        fecha_pago, 
        concepto, 
        monto_total, 
        estado_checkbox,
        IFNULL(SUM(monto_detalle_pago), 0) AS total_detalle_pago 
    FROM pagos 
    LEFT JOIN detalle_pagos 
        ON pagos.id_pago = detalle_pagos.pagos_id_pago 
    WHERE 
        (poliza LIKE '%$dato%' OR folio_fiscal LIKE '%$dato%' OR concepto LIKE '%$dato%') 
        AND pagos.estatus = '1' 
    GROUP BY 
        pagos.id_pago, 
        poliza, 
        partida, 
        fecha_pago, 
        folio_fiscal, 
        concepto, 
        monto_total,
        estado_checkbox
    ORDER BY 
        fecha_pago DESC 
    LIMIT $limit, $nroLotes";

    $registro_2 = mysqli_query($conexion_database, $consulta_2);
    /*if (!$registro_2) {
        die("Error en la consulta: " . mysqli_error($conexion_database));
    }*/

    $no_filas = mysqli_num_rows($registro_2);
    /**---------------------------------------------------------- */
    $tabla = $tabla.'<div class="table-responsive">
                        <table class="table table-hover table-bordered table-sm">';
    if($no_filas > 0){
        $tabla = $tabla.'
                            <thead class="text-center">
                                <tr>
                                    <th><i class="fa-solid fa-gear"></i></th>
                                    <th>Poliza</th>
                                    <th>Partida</th>
                                    <th>Fecha de Pago</th>
                                    <th>Concepto</th>
                                    <th>Monto Total</th>
                                    <th>Notificación</th>
                                    <th>Asignar P.E.</th>
                                </tr>
                            </thead>
                            <tbody>
        ';
        while($row = mysqli_fetch_array($registro_2)){
            $id = $row["id"];
            $poliza = $row["poliza"];
            $partida = $row["partida"];
            $fecha_pago = date("d-m-Y", strtotime($row["fecha_pago"]));
            $concepto = $row["concepto"];
            $monto_total = number_format($row["monto_total"], 2, '.', ',');
            $total_detalle_pago = number_format($row["total_detalle_pago"], 2, '.', ',');
            $estado_checkbox = $row["estado_checkbox"];
            $notificacion = '';
            if($total_detalle_pago ==$monto_total){
                $notificacion = '<span class="badge text-bg-success">Se completo el pago</span>';
            }else if($total_detalle_pago < $monto_total && $total_detalle_pago > 0.00){
                $notificacion = '<span class="badge text-bg-warning">Falta por completar el pago</span>';
            }else if($total_detalle_pago == 0.00 && $monto_total > 0.00){
                $notificacion = '<span class="badge text-bg-danger">Aun no se han realizado movimientos</span>';
            }else if($monto_total < 0){
                $notificacion = '<span class="badge text-bg-danger">Pago Cancelado</span>';
            }else{
                $notificacion = '<span class="badge text-bg-info">Desconocido</span>';
            }
            if($monto_total > 0){
                $valor_button = '<button type="button" class="btn btn-sm btn-primary" onclick="Examina_detalle_pago('.$id.');">
                                    <i class="fa-solid fa-circle-info"></i>
                                </button>';
            }else{
                $valor_button = '<button type="button" class="btn btn-sm btn-primary" disabled>
                                    <i class="fa-solid fa-circle-info"></i>
                                </button>';
            }
            if($monto_total > 0){
                $form_check = '
                    <form action="php/detalle_pagos/manejar_pe_detalle_pagos.php" method="POST" id="form_pe_pagos" name="form_pe_pagos">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="pe_input" value="'.$estado_checkbox.'" onchange="return Manejar_pe_detalle_pago('.$id.',this.checked);" '.($estado_checkbox == 0 ? '' : 'checked').'>
                            <label class="form-check-label" for="pe">
                                '.($estado_checkbox == 0 ?  'Agregar P.E.' : 'Eliminar P.E.').'
                            </label>
                        </div>
                    </form>
                ';
            }else{
                $form_check = '
                    <form>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="pe_input" disabled>
                            <label class="form-check-label" for="pe_input">
                                Agregar P.E.
                            </label>
                        </div>
                    </form>
                ';
            }
            $tabla = $tabla.'
                                <tr>
                                    <td align="center">'.$valor_button.'</td>
                                    <td>'.$poliza.'</td>
                                    <td>'.$partida.'</td>
                                    <td>'.$fecha_pago.'</td>
                                    <td>'.$concepto.'</td>
                                    <td> $'.$monto_total.'</td>
                                    <td>'.$notificacion.'</td>
                                    <td>'.$form_check.'</td>
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