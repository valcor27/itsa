<?php
require("../conexion/conexion_bd.php");
require("../sesion/logueo.php");
require("../clases/limpiar.php");

$paginaActual = $_POST["partida"];
$dato = $_POST["dato"];
$ideliminar = $_POST["ideliminar"];
date_default_timezone_set('America/Mexico_City');
$fecha = date('Y-m-d');
$usuario = $id_software_sesion;
$proceso = "Eliminar";

$dato = sanear_normal($dato);
/*-----Verificación de eliminar---------------------------------------------------------------------------------*/
if($ideliminar > 0){
    $eliminar="UPDATE historial_parque_comision SET estatus='0', fecha_movimiento = '$fecha', ultimo_movimiento = '$proceso', 
    usuario_movimiento = '$usuario' WHERE id_historial_parque_comision='$ideliminar' LIMIT 1";
    $resultado_elimina=mysqli_query($conexion_database, $eliminar);
}
/*--------------------------------------------------------------------------------------------------------------*/
/*-----Consulta numero de datos en BD---------------------------------------------------------------------------*/
$consulta_1 ="SELECT hp.id_historial_parque_comision 
FROM historial_parque_comision hp
INNER JOIN comision c ON FIND_IN_SET(c.id_comision, hp.comisiones_id_comisiones)
INNER JOIN estructuraorganica eo ON FIND_IN_SET(eo.claveUnidad, hp.departamento_id_departamento)
INNER JOIN vehiculo v ON hp.vehiculo_id_vehiculo = v.idvehiculo
WHERE (c.folio_comision LIKE '%$dato%' OR eo.nombreUnidad LIKE '%$dato%' OR v.submarca LIKE '%$dato%' OR v.placas LIKE '%$dato%') AND hp.estatus = '1'
";
$resultado_1=mysqli_query($conexion_database, $consulta_1);
$nroProductos = mysqli_num_rows($resultado_1);

mysqli_free_result($resultado_1);

$nroLotes = 10;
$nroPaginas = ceil($nroProductos/$nroLotes);
$tabla = '';
$lista_info = '';
$lista = '';

$min = $paginaActual - ($paginaActual % 5) + 1;  
if($min > $paginaActual){$min=$min-5;}

$max = $min + 4 > $nroPaginas ? $nroPaginas : $min + 4;
/*--------------------------------------------------------------------------------------------------------------*/

/*-----Lista de información de paginas--------------------------------------------------------------------------*/
$lista_info = $lista_info.' Pag. '.$paginaActual.' / '.$nroPaginas.' ';
/*--------------------------------------------------------------------------------------------------------------*/

/*-----Paginación para tabletas y pc---------------------------------------------------------------------------*/
$lista = $lista.'<ul class="pagination">';

if($paginaActual > 1){
$lista = $lista.'
<li class="page-item">
    <a class="page-link" href="#Anterior" aria-label="Previous" onclick="Pagination_compacto_comision('.($paginaActual-1).');">
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

for($i=$min; $i<=$max; $i++){
if($i == $paginaActual){
    $lista = $lista.'
    <li class="page-item active">
    <a class="page-link" href="#Paginar" onclick="Pagination_compacto_comision('.$i.');">'.$i.'</a>
    </li>';
}else{     
    $lista = $lista.'
    <li class="page-item">
    <a class="page-link" href="#Paginar" onclick="Pagination_compacto_comision('.$i.');">'.$i.'</a>
    </li>';
}   
}    

if($paginaActual < $nroPaginas){
$lista = $lista.'
<li class="page-item">
    <a class="page-link" href="#Siguiente" aria-label="Next" onclick="Pagination_compacto_comision('.($paginaActual+1).');">
    <i class="fas fa-arrow-alt-circle-right"></i>
    </a>
</li>';
}else{
$lista = $lista.'
<li class="page-item disabled">
    <a class="page-link" href="#Siguiente">
    <i class="fas fa-arrow-alt-circle-right"></i>
    </a>
</li>';
}

$lista = $lista.'</ul>';
/*--------------------------------------------------------------------------------------------------------------*/  


/*-----Obtencción limite de datos BD----------------------------------------------------------------------------*/  
if($paginaActual <= 1){
$limit = 0;
}else{
$limit = $nroLotes*($paginaActual-1);
}
/*--------------------------------------------------------------------------------------------------------------*/
$consulta_2 ="SELECT 
        hp.id_historial_parque_comision, 
        REPLACE(GROUP_CONCAT(DISTINCT c.folio_comision), ',', ', ') AS folios_comision, 
        REPLACE(GROUP_CONCAT(DISTINCT eo.nombreUnidad), ',', ', ') AS departamentos,
        v.submarca, 
        v.placas
    FROM historial_parque_comision hp
    INNER JOIN comision c ON FIND_IN_SET(c.id_comision, hp.comisiones_id_comisiones)
    INNER JOIN estructuraorganica eo ON FIND_IN_SET(eo.claveUnidad, hp.departamento_id_departamento)
    INNER JOIN vehiculo v ON hp.vehiculo_id_vehiculo = v.idvehiculo
    WHERE (c.folio_comision LIKE '%$dato%' OR eo.nombreUnidad LIKE '%$dato%' OR v.submarca LIKE '%$dato%' OR v.placas LIKE '%$dato%') AND hp.estatus = '1'
    GROUP BY hp.id_historial_parque_comision
    ORDER BY hp.id_historial_parque_comision DESC LIMIT $limit, $nroLotes    
";
$registro_2 = mysqli_query($conexion_database, $consulta_2);
$no_filas = mysqli_num_rows($registro_2);

$tabla = '
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
';
if($no_filas > 0){
    $tabla .= '
            <thead>
                <tr>
                    <th><i class="fa-solid fa-gear"></i></th>
                    <th>Folios Comisión</th>
                    <th>Vehiculo</th>
                    <th>Departamentos</th>
                </tr>
            </thead>
            <tbody>
                
    ';
    while($row = mysqli_fetch_array($registro_2)){
        $id = $row["id_historial_parque_comision"];
        $folios_comision = $row["folios_comision"];
        $departamento = $row["departamentos"];
        $submarca = $row["submarca"];
        $placas = $row["placas"];
        $vehiculo = $submarca.', '.$placas;

        $tabla.='
                <tr>
                    <td align="center">
                        <button type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Actualizar Compacto" onclick="Actualizar_compacto_comision('.$id.');">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Eliminar Compacto" onclick="Eliminar_compacto_comision('.$id.');">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </td>
                    <td>' . $folios_comision . '</td>
                    <td>' . $vehiculo . '</td>
                    <td>' . $departamento . '</td>
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
