<?php
require("../conexion/conexion_bd.php");
require("../sesion/logueo.php");
require("../clases/limpiar.php");

$paginaActual = $_POST['partida'];
$dato = sanear_normal($_POST['dato']);
$ideliminar = $_POST['ideliminar'];
date_default_timezone_set('America/Mexico_City');
$fecha = date('Y-m-d');
$proceso = "Eliminar";
$usuario = $id_software_sesion;

// Verificación de eliminar
if($ideliminar > 0) {
    $eliminar = "UPDATE comision c
    LEFT JOIN parque_comision pc ON c.id_comision = pc.comision_id_comision
    LEFT JOIN viaticos_comision vc ON c.id_comision = vc.comision_id_comision
    SET 
        c.estatus = '0', c.fecha_movimiento = '$fecha', c.ultimo_movimiento = '$proceso', c.usuario_movimiento = '$usuario',
        pc.estatus = '0', pc.fecha_movimiento = '$fecha', pc.ultimo_movimiento = '$proceso', pc.usuario_movimiento = '$usuario',
        vc.estatus = '0', vc.fecha_movimiento = '$fecha', vc.ultimo_movimiento = '$proceso', vc.usuario_movimiento = '$usuario'
    WHERE c.id_comision = '$ideliminar'";

    mysqli_query($conexion_database, $eliminar);
}

// Consulta del número de datos en BD
$consulta_1 = "SELECT c.id_comision
FROM comision c
INNER JOIN empleados e ON FIND_IN_SET(e.expediente, c.id_empleado) 
WHERE (c.folio_comision LIKE '%$dato%' OR c.id_empleado LIKE '%$dato%' OR e.nombres LIKE '%$dato%' OR e.primerApellido LIKE '%$dato%' OR e.segundoApellido LIKE '%$dato%') AND c.estatus = '1'";
$resultado_1 = mysqli_query($conexion_database, $consulta_1);
$nroProductos = mysqli_num_rows($resultado_1);
mysqli_free_result($resultado_1);

$nroLotes = 5;
$nroPaginas = ceil($nroProductos / $nroLotes);

$min = $paginaActual - ($paginaActual % 5) + 1;
if ($min > $paginaActual) $min = $min - 5;
$max = $min + 4 > $nroPaginas ? $nroPaginas : $min + 4;

$lista_info = ' Pag. ' . $paginaActual . ' / ' . $nroPaginas . ' ';
$lista = '<ul class="pagination">';
if ($paginaActual > 1) {
    $lista .= '<li class="page-item">
        <a class="page-link" href="#Anterior" aria-label="Previous" onclick="Pagination_comision(' . ($paginaActual - 1) . ');">
            <i class="fas fa-arrow-alt-circle-left"></i>
        </a>
    </li>';
} else {
    $lista .= '<li class="page-item disabled">
        <a class="page-link" href="#Anterior">
            <i class="fas fa-arrow-alt-circle-left"></i>
        </a>
    </li>';
}

for ($i = $min; $i <= $max; $i++) {
    if ($i == $paginaActual) {
        $lista .= '<li class="page-item active">
            <a class="page-link" href="#Paginar" onclick="Pagination_comision(' . $i . ');">' . $i . '</a>
        </li>';
    } else {
        $lista .= '<li class="page-item">
            <a class="page-link" href="#Paginar" onclick="Pagination_comision(' . $i . ');">' . $i . '</a>
        </li>';
    }
}

if ($paginaActual < $nroPaginas) {
    $lista .= '<li class="page-item">
        <a class="page-link" href="#Siguiente" aria-label="Next" onclick="Pagination_comision(' . ($paginaActual + 1) . ');">
            <i class="fas fa-arrow-alt-circle-right"></i>
        </a>
    </li>';
} else {
    $lista .= '<li class="page-item disabled">
        <a class="page-link" href="#Siguiente">
            <i class="fas fa-arrow-alt-circle-right"></i>
        </a>
    </li>';
}
$lista .= '</ul>';

$limit = $paginaActual <= 1 ? 0 : $nroLotes * ($paginaActual - 1);

$consulta_2 = "SELECT 
    c.id_comision AS id, 
    c.id_empleado, 
    c.folio_comision, 
    c.f_ini, c.f_fin, c.h_ini, c.h_fin, 
    GROUP_CONCAT(DISTINCT CONCAT(e.nombres, ' ', e.primerApellido, ' ', e.segundoApellido) SEPARATOR ', ') AS nombre_completo
FROM comision c 
INNER JOIN empleados e ON FIND_IN_SET(e.expediente, c.id_empleado) 
WHERE (c.folio_comision LIKE '%$dato%' OR c.id_empleado LIKE '%$dato%' OR e.nombres LIKE '%$dato%' OR e.primerApellido LIKE '%$dato%' OR e.segundoApellido LIKE '%$dato%') AND c.estatus = '1' 
GROUP BY c.id_comision
ORDER BY c.id_comision DESC LIMIT $limit, $nroLotes";

$registro_2 = mysqli_query($conexion_database, $consulta_2);
$no_filas = mysqli_num_rows($registro_2);

$tabla = '<div class="table-responsive">
            <table class="table table-hover table-bordered">';

if ($no_filas > 0) {
    $tabla .= '<thead>
                <tr>
                    <th><i class="fa-solid fa-gear"></i></th>
                    <th>Folio</th>
                    <th>Fecha De - Hasta</th>
                    <th>Empleado</th>
                </tr>
            </thead>
            <tbody>';
    while ($row = mysqli_fetch_array($registro_2)) {
        $id = $row["id"];
        $expediente = $row["id_empleado"];
        $folio = $row["folio_comision"];
        $fecha_inicio = date("d-m-Y", strtotime($row["f_ini"]));
        $fecha_fin = date("d-m-Y", strtotime($row["f_fin"]));
        $hora_inicio = date("H:i", strtotime($row["h_ini"]));
        $hora_fin = date("H:i", strtotime($row["h_fin"]));
        $empleado = $row["nombre_completo"];
        $duracion = 'Del ' . $fecha_inicio . ' a las ' . $hora_inicio . ' Hasta el ' . $fecha_fin . ' a las ' . $hora_fin;

        $consulta_3 = "SELECT id_viaticos_comision, comision_id_comision FROM viaticos_comision WHERE comision_id_comision = '$id' LIMIT 1";
        $registro_3 = mysqli_query($conexion_database, $consulta_3);
        $viaticos = mysqli_fetch_assoc($registro_3);
        $valor_boton_viaticos = isset($viaticos['id_viaticos_comision']) ? '
            <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Viaticos Comisión" onclick="Viaticos_comision(' . $viaticos['id_viaticos_comision'] . ',' . $id . ');">
                <i class="fa-solid fa-sack-dollar"></i>
            </button>
        ' : '
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Viaticos Comisión" onclick="Viaticos_comision(0,' . $id . ');">
                <i class="fa-solid fa-sack-dollar"></i>
            </button>
        ';
        mysqli_free_result($registro_3);

        $consulta_4 = "SELECT id_parque_comision, comision_id_comision FROM parque_comision WHERE comision_id_comision = '$id' LIMIT 1";
        $registro_4 = mysqli_query($conexion_database, $consulta_4);
        $parque = mysqli_fetch_assoc($registro_4);
        $valor_boton_parque = isset($parque['id_parque_comision']) ? '
            <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Parque Vehicular Comisión" onclick="Parque_comision(' . $parque['id_parque_comision'] . ',' . $id . ');">
                <i class="fa-solid fa-car"></i>
            </button>
        ' : '
            <button type="button" class="btn btn-outline-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Parque Vehicular Comisión" onclick="Parque_comision(0,' . $id . ');">
                <i class="fa-solid fa-car"></i>
            </button>
        ';
        mysqli_free_result($registro_4);

        $tabla .= '<tr>
            <td align="center">
                <button type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Actualizar Comisión" onclick="Actualizar_comision_dp(' . $id . ');">
                    <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Eliminar Comisión" onclick="Eliminar_comision_dp(' . $id . ');">
                    <i class="far fa-trash-alt"></i>
                </button>
                ' . $valor_boton_parque . ' ' . $valor_boton_viaticos . '
            </td>
            <td>' . $folio . '</td>
            <td>' . $duracion . '</td>
            <td>' . $empleado . '</td>
        </tr>';
    }
    $tabla .= '</tbody>';
} else {
    $tabla .= '<div class="alert alert-info">
        <strong>Mensaje!</strong> No se encontro ningún registro.
    </div>';
}

$tabla .= '</table></div>';

$array = array(
    0 => $tabla,
    1 => $lista_info,
    2 => $lista
);

echo json_encode($array);
mysqli_free_result($registro_2);
mysqli_close($conexion_database);
?>
