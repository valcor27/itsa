<?php
require("../conexion/conexion_bd.php");
require("../sesion/logueo.php");
require("../clases/limpiar.php");

$paginaActual = $_POST['partida'];
$dato = $_POST['dato'];
$ideliminar = $_POST['ideliminar'];
$idaceptar = $_POST['idaceptar'];
date_default_timezone_set('America/Mexico_City');
$fecha = date('Y-m-d');
$usuario = $id_software_sesion;
$departamento_usuario = $estructura_real;
$movimiento_cancelar = "Cancelado";
$movimiento_aceptar = "Aceptado";

$dato=sanear_normal($dato);

/*-----Verificación de eliminar---------------------------------------------------------------------------------*/
if($ideliminar > 0){
  $eliminar="UPDATE documentos SET estatus='0', fecha_movimiento = '$fecha', ultimo_movimiento = '$movimiento_cancelar', 
  usuario_movimiento = '$usuario' WHERE id_documento='$ideliminar' LIMIT 1";
  $resultado_elimina=mysqli_query($conexion_database, $eliminar);
}
/*--------------------------------------------------------------------------------------------------------------*/

/**---------------------------Verificacion de aceptar documento------------- */
if($idaceptar > 0){
    $aceptar = "UPDATE documentos SET estatus = '2', fecha_movimiento = '$fecha', ultimo_movimiento = '$movimiento_aceptar', 
    usuario_movimiento = '$usuario' WHERE id_documento = '$idaceptar' LIMIT 1";
    $resultado_acepta = mysqli_query($conexion_database, $aceptar);
}
/**------------------------------------------------------------------------- */

/*-----Consulta numero de datos en BD---------------------------------------------------------------------------*/
$consulta_1="SELECT id_documento FROM documentos WHERE folio LIKE '%$dato%' OR asunto LIKE '%$dato%' OR  partida_cd LIKE '%$dato%' OR partida_fed LIKE '%$dato%' OR partida_est LIKE '%$dato%' OR partida_ip LIKE '%$dato%' OR partida_pa LIKE '%$dato%'";
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
    <a class="page-link" href="#Anterior" aria-label="Previous" onclick="Pagination_documentos('.($paginaActual-1).');">
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
      <a class="page-link" href="#Paginar" onclick="Pagination_documentos('.$i.');">'.$i.'</a>
    </li>';
  }else{     
    $lista = $lista.'
    <li class="page-item">
      <a class="page-link" href="#Paginar" onclick="Pagination_documentos('.$i.');">'.$i.'</a>
    </li>';
  }   
}    

if($paginaActual < $nroPaginas){
  $lista = $lista.'
  <li class="page-item">
    <a class="page-link" href="#Siguiente" aria-label="Next" onclick="Pagination_documentos('.($paginaActual+1).');">
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

$consulta_2 = "SELECT DISTINCT documentos.id_documento as id, folio, asunto, fecha_creacion, estatus, nombre_documento 
FROM documentos 
LEFT JOIN historial_movimientos ON documentos.id_documento = historial_movimientos.documento_id_documento
WHERE (folio LIKE '%$dato%' OR asunto LIKE '%$dato%' OR  partida_cd LIKE '%$dato%' OR partida_fed LIKE '%$dato%' OR partida_est LIKE '%$dato%' OR partida_ip LIKE '%$dato%' OR partida_pa LIKE '%$dato%') 
AND (
    historial_movimientos.departamento_actual = '$departamento_usuario' OR 
    historial_movimientos.departamento_actual IS NULL OR
    historial_movimientos.departamento_anterior IS NULL
)
ORDER BY documentos.id_documento DESC LIMIT $limit, $nroLotes";

$registro_2 = mysqli_query($conexion_database, $consulta_2);
$no_filas = mysqli_num_rows($registro_2);

$tabla = '<div class="table-responsive">
            <table class="table table-hover table-bordered">';
if ($no_filas > 0) {
    if($departamento_usuario == 10100){
        $button_ssa_ex= '
            <a href="php/documento_ssa/descargar_reporte_ex.php" class="btn btn-success">
                <i class="fa-regular fa-file-excel"></i> Generar Reporte
            </a>
        ';
        $button_ssa = '
            <a href="php/documento_ssa/descargar_reporte.php" class="btn btn-primary" target="_blank">
                <i class="fa-regular fa-file-pdf"></i> Generar Reporte
            </a>
        ';
    }else{
        $button_ssa_ex='';
        $button_ssa = '';
    }
    $tabla .= '<thead>
                    <tr> 
                        <th><i class="fa-solid fa-gear"></i></th>
                        <th>Folio</th>
                        <th>Asunto</th>
                        <th>Fecha Envio</th>
                        <th>Dep. Actual</th>
                        <th>Fecha Alta</th>
                        <th>Estatus</th>
                        <th>Descargar</th>
                    </tr>
                </thead>
                <tbody>';

    while ($row = mysqli_fetch_array($registro_2)) {
        $id = $row["id"];
        $folio = $row["folio"];
        $asunto = $row["asunto"];
        $fecha = date("d-m-Y", strtotime($row["fecha_creacion"]));
        $estatus = $row["estatus"];
        $archivo = $row["nombre_documento"];

        // Obtener información del historial_movimientos
        $consulta_3 = "SELECT fecha, departamento_actual, id_historial, nombreUnidad
        FROM historial_movimientos 
        JOIN estructuraorganica ON departamento_actual = claveUnidad
        WHERE documento_id_documento = '$id' 
        ORDER BY fecha DESC, id_historial DESC LIMIT 1";

        //$consulta_3 = "SELECT MAX(fecha) AS ultima_fecha, departamento_actual FROM historial_movimientos WHERE documento_id_documento = '$id'";
        $registro_3 = mysqli_query($conexion_database, $consulta_3);
        while($row_3 = mysqli_fetch_array($registro_3)){
            $departamento_actual_documento = $row_3["departamento_actual"];
            $ultima_fecha = date("d-m-Y", strtotime($row_3["fecha"]));
            //$ultima_fecha = $row_3["fecha"];
            $id_historial_movimiento = $row_3["id_historial"];
            $dep_actual_documento = $row_3["nombreUnidad"];
        }
    
        //echo "Departamento actual del documento: " . $departamento_actual_documento . "<br>";
        //echo "Departamento cambiado el: " . $ultima_fecha . "<br>";
        //echo "ID de movimiento: " . $id_historial_movimiento . "<br>";

        // Definir variable de estatus
        if ($estatus == 0) {
            $valor_estatus = '<span class="badge text-bg-danger">Cancelado</span>';
        } elseif ($estatus == 1) {
            $valor_estatus = '<span class="badge text-bg-warning">En proceso</span>';
        } elseif ($estatus == 2) {
            $valor_estatus = '<span class="badge text-bg-success">Aceptado</span>';
        } 

        //Boton de download document
        if($archivo != null){
            $valor_archivo = '
                <button type="button" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Descargar Documento" onclick="Descargar_documento('.$id.');">
                    <i class="fa-solid fa-file-arrow-down"></i>
                </button>
            ';
        }else{
            $valor_archivo = '
                <button type="button" class="btn btn-outline-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Descargar Documento" disabled>
                    <i class="fa-solid fa-file-arrow-down"></i>
                </button>
            ';
        }

        // Lógica de habilitación de botones
        $editar = 'disabled';
        $cancelar = 'disabled';
        $aceptar = 'disabled';
        $enviar = 'disabled';

        if ($estatus == 0) {
            // Documento Cancelado
            if ($departamento_actual_documento == $departamento_usuario) {
                $valor_botones = '
                    <button type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Editar Documento" disabled>
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Cancelar Documento" disabled>
                        <i class="fa-solid fa-file-circle-xmark"></i>
                    </button>
                    <button type="button" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Aceptar Documento" disabled>
                        <i class="fa-solid fa-file-circle-check"></i>
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Enviar Documento a otro Departamento" disabled>
                        <i class="fa-solid fa-file-arrow-up"></i>
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Ver Historial del Documento" onclick="Historial_documento('.$id.');">
                        <i class="fa-solid fa-box-archive"></i>
                    </button>
                ';
            } else {
                $valor_botones = '
                    <button type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Editar Documento" disabled>
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Cancelar Documento" disabled>
                        <i class="fa-solid fa-file-circle-xmark"></i>
                    </button>
                    <button type="button" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Aceptar Documento" disabled>
                        <i class="fa-solid fa-file-circle-check"></i>
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Enviar Documento a otro Departamento" disabled>
                        <i class="fa-solid fa-file-arrow-up"></i>
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Ver Historial del Documento" onclick="Historial_documento('.$id.');">
                        <i class="fa-solid fa-box-archive"></i>
                    </button>
                ';
            }
        } elseif ($estatus == 1) {
            // Documento en Proceso
            if ($departamento_actual_documento == $departamento_usuario) {
            /* $editar = '';
                $cancelar = '';
                $aceptar = '';
                $enviar = '';*/
                //echo "Lógica de habilitación de botones: Editar=$editar, Cancelar=$cancelar, Aceptar=$aceptar, Enviar=$enviar <br>";
            

                $valor_botones = '
                    <button type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Editar Documento" onclick="Actualizar_documento(' . $id . ');">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Cancelar Documento" onclick="Eliminar_documento(' . $id . ');">
                        <i class="fa-solid fa-file-circle-xmark"></i>
                    </button>
                    <button type="button" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Aceptar Documento" onclick="Aceptar_documento(' . $id . ');">
                        <i class="fa-solid fa-file-circle-check"></i>
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Enviar Documento a otro Departamento" onclick="Enviar_documento(' . $id . ');">
                        <i class="fa-solid fa-file-arrow-up"></i>
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Ver Historial del Documento" onclick="Historial_documento(' . $id . ');">
                        <i class="fa-solid fa-box-archive"></i>
                    </button>
                ';
            }else{
                $valor_botones = '
                    <button type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Editar Documento" disabled>
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Cancelar Documento" disabled>
                        <i class="fa-solid fa-file-circle-xmark"></i>
                    </button>
                    <button type="button" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Aceptar Documento" disabled>
                        <i class="fa-solid fa-file-circle-check"></i>
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Enviar Documento a otro Departamento" disabled>
                        <i class="fa-solid fa-file-arrow-up"></i>
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Ver Historial del Documento" onclick="Historial_documento(' . $id . ');">
                        <i class="fa-solid fa-box-archive"></i>
                    </button>
                ';
            }
        } elseif ($estatus == 2) {
            // Documento Aceptado
            if ($departamento_actual_documento == $departamento_usuario) {
                $valor_botones = '
                    <button type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Editar Documento" disabled>
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Cancelar Documento" disabled>
                        <i class="fa-solid fa-file-circle-xmark"></i>
                    </button>
                    <button type="button" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Aceptar Documento" disabled>
                        <i class="fa-solid fa-file-circle-check"></i>
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Enviar Documento a otro Departamento" onclick="Enviar_documento(' . $id . ');">
                        <i class="fa-solid fa-file-arrow-up"></i>
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Ver Historial del Documento" onclick="Historial_documento(' . $id . ');">
                        <i class="fa-solid fa-box-archive"></i>
                    </button>
                ';
            } else {
                $valor_botones = '
                    <button type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Editar Documento" disabled>
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Cancelar Documento" disabled>
                        <i class="fa-solid fa-file-circle-xmark"></i>
                    </button>
                    <button type="button" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Aceptar Documento" disabled>
                        <i class="fa-solid fa-file-circle-check"></i>
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Enviar Documento a otro Departamento" disabled>
                        <i class="fa-solid fa-file-arrow-up"></i>
                    </button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Ver Historial del Documento" onclick="Historial_documento(' . $id . ');">
                        <i class="fa-solid fa-box-archive"></i>
                    </button>
                ';
            }
        } else {
            $valor_botones = '';
        }
        // Generar fila de la tabla
        $tabla .= '<tr>
                        <td align="center">' . $valor_botones . '</td>
                        <td>' . $folio . '</td>
                        <td>' . $asunto . '</td>
                        <td>' . $ultima_fecha . '</td>
                        <td>' . $dep_actual_documento . '</td>
                        <td>' . $fecha . '</td>
                        <td>' . $valor_estatus . '</td>
                        <td align="center">' . $valor_archivo . '</td>
                    </tr>';
    }

    $tabla .= '</tbody>';
} else {
    if($departamento_usuario == 10100){
        $button_ssa_ex= '
            <a href="#" class="btn btn-outline-success" disabled onclick="return false;">
                <i class="fa-regular fa-file-excel"></i> Generar Reporte
            </a>
        ';
        $button_ssa = '
            <a href="#" class="btn btn-outline-primary" disabled onclick="return false;">
                <i class="fa-regular fa-file-pdf"></i> Generar Reporte
            </a>
        ';
    }else{
        $button_ssa_ex='';
        $button_ssa = '';
    }
    $tabla .= '<div class="alert alert-info">
                    <strong>Mensaje!</strong> No se encontró ningún registro.
                </div>';
}

$tabla .= '</table>
        </div>';

$array = array(
0 => $tabla,
1 => $lista_info, 
2 => $lista,
3 => $button_ssa,
4 => $button_ssa_ex
);

echo json_encode($array);

mysqli_free_result($registro_2);
mysqli_close($conexion_database);  
?>