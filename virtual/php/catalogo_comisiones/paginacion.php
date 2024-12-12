<?php
require("../conexion/conexion_bd.php");
require("../sesion/logueo.php");
require("../clases/limpiar.php");

$paginaActual = $_POST['partida'];
$fecha_inicio = isset($_POST['fecha_inicial']) ? $_POST['fecha_inicial'] : null;
$fecha_fin = isset($_POST['fecha_final']) ? $_POST['fecha_final'] : null;

$where = "hp.estatus = '1'";

if (!empty($fecha_inicio) && !empty($fecha_fin)) {
    $fecha_inicio = date("Y-m-d", strtotime($fecha_inicio));
    $fecha_fin = date("Y-m-d", strtotime($fecha_fin));
    $where .= " AND (c.f_ini >= '$fecha_inicio' AND c.f_fin <= '$fecha_fin')";
}

$consulta_1 = "SELECT hp.id_historial_parque_comision 
    FROM historial_parque_comision hp
    INNER JOIN comision c ON FIND_IN_SET(c.id_comision, hp.comisiones_id_comisiones)
    INNER JOIN estructuraorganica eo ON FIND_IN_SET(eo.claveUnidad, hp.departamento_id_departamento)
    INNER JOIN vehiculo v ON hp.vehiculo_id_vehiculo = v.idvehiculo
    WHERE $where";

$resultado_1 = mysqli_query($conexion_database, $consulta_1);
$nroProductos = mysqli_num_rows($resultado_1);

mysqli_free_result($resultado_1);

$nroLotes = 10;
$nroPaginas = ceil($nroProductos / $nroLotes);
$tabla = '';
$lista_info = '';
$lista = '';

$min = $paginaActual - ($paginaActual % 5) + 1;  
if ($min > $paginaActual) {
    $min = $min - 5;
}

$max = $min + 4 > $nroPaginas ? $nroPaginas : $min + 4;

$lista_info = ' Pag. ' . $paginaActual . ' / ' . $nroPaginas . ' ';

$lista .= '<ul class="pagination">';

if ($paginaActual > 1) {
    $lista .= '
    <li class="page-item">
        <a class="page-link" href="#Anterior" aria-label="Previous" onclick="Pagination_catalogo_comsiones(' . ($paginaActual-1) . ');">
        <i class="fas fa-arrow-alt-circle-left"></i>
        </a>
    </li>'; 
} else {
    $lista .= '
    <li class="page-item disabled">
        <a class="page-link" href="#Anterior">
        <i class="fas fa-arrow-alt-circle-left"></i>
        </a>
    </li>';
}

for ($i = $min; $i <= $max; $i++) {
    if ($i == $paginaActual) {
        $lista .= '
        <li class="page-item active">
        <a class="page-link" href="#Paginar" onclick="Pagination_catalogo_comsiones(' . $i . ');">' . $i . '</a>
        </li>';
    } else {     
        $lista .= '
        <li class="page-item">
        <a class="page-link" href="#Paginar" onclick="Pagination_catalogo_comsiones(' . $i . ');">' . $i . '</a>
        </li>';
    }   
}    

if ($paginaActual < $nroPaginas) {
    $lista .= '
    <li class="page-item">
        <a class="page-link" href="#Siguiente" aria-label="Next" onclick="Pagination_catalogo_comsiones(' . ($paginaActual+1) . ');">
        <i class="fas fa-arrow-alt-circle-right"></i>
        </a>
    </li>';
} else {
    $lista .= '
    <li class="page-item disabled">
        <a class="page-link" href="#Siguiente">
        <i class="fas fa-arrow-alt-circle-right"></i>
        </a>
    </li>';
}

$lista .= '</ul>';

if ($paginaActual <= 1) {
    $limit = 0;
} else {
    $limit = $nroLotes * ($paginaActual - 1);
}

$consulta_2 = "SELECT 
    --hp.id_historial_parque_comision, 
    REPLACE(GROUP_CONCAT(DISTINCT c.folio_comision), ',', ', ') AS folios_comision, 
    REPLACE(GROUP_CONCAT(DISTINCT eo.nombreUnidad), ',', ', ') AS departamentos,
    v.submarca, 
    v.placas,
    hp.km_inicial,
    hp.km_final,
    hp.km_recorridos,
    hp.precio_combustible,
    v.kmporlitro
FROM historial_parque_comision hp
INNER JOIN comision c ON FIND_IN_SET(c.id_comision, hp.comisiones_id_comisiones)
INNER JOIN estructuraorganica eo ON FIND_IN_SET(eo.claveUnidad, hp.departamento_id_departamento)
INNER JOIN vehiculo v ON hp.vehiculo_id_vehiculo = v.idvehiculo
WHERE $where
GROUP BY hp.id_historial_parque_comision
ORDER BY hp.id_historial_parque_comision DESC LIMIT $limit, $nroLotes";

$registro_2 = mysqli_query($conexion_database, $consulta_2);
$no_filas = mysqli_num_rows($registro_2);

$tabla = '
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
';

if ($no_filas > 0) {
    $tabla .= '
            <thead>
                <tr>
                    <th>Vehiculo</th>
                    <th>Folios Comisión</th>
                    <th>Departamentos</th>
                    <th>Km. Inicial</th>
                    <th>Km. Final</th>
                    <th>Km. Recorridos</th>
                    <th>Consumo Aprox. de Gasolina</th>
                </tr>
            </thead>
            <tbody>
    ';
    while ($row = mysqli_fetch_array($registro_2)) {
        $folios_comision = $row["folios_comision"];
        $departamento = $row["departamentos"];
        $submarca = $row["submarca"];
        $placas = $row["placas"];
        $km_inicial = $row["km_inicial"];
        $km_final = $row["km_final"];
        $km_recorrido = $row["km_recorridos"];
        $precio = $row["precio_combustible"];
        $km_por_litro = $row["kmporlitro"];
        $vehiculo = $submarca . ', ' . $placas;
        $litros_consumidos = $km_recorrido / $km_por_litro;
        $costo_en_pesos = $litros_consumidos * $precio; 
        $costo_en_pesos = number_format($costo_en_pesos, 2);

        $tabla .= '
                <tr>
                    <td>' . $vehiculo . '</td>
                    <td>' . $folios_comision . '</td>
                    <td>' . $departamento . '</td>
                    <td>' . $km_inicial . '</td>
                    <td>' . $km_final . '</td>
                    <td>' . $km_recorrido . '</td>
                    <td> $ ' . $costo_en_pesos . '</td>
                </tr>
        ';
    }
    $tabla .= '
            </tbody>
    ';
} else {
    $tabla .= '
            <div class="alert alert-info">
                <strong>Mensaje!</strong> No se encontró ningún registro.
            </div>
    ';
}

$tabla .= '
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
