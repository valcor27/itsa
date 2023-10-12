<?php
require("../conexion/conexion_bd.php");
require("../sesion/logueo.php");
require("../clases/limpiar.php");

$paginaActual = $_POST['partida'];
$dato = $_POST['dato'];
$ideliminar = $_POST['ideliminar'];
$idaceptar = $_POST['idaceptar'];

$dato=sanear_normal($dato);

/*-----Verificación de eliminar---------------------------------------------------------------------------------*/
if($ideliminar > 0){
  $eliminar="UPDATE documentos SET estatus='0' WHERE id_documento='$ideliminar' LIMIT 1";
  $resultado_elimina=mysqli_query($conexion_database, $eliminar);
}
/*--------------------------------------------------------------------------------------------------------------*/

/**---------------------------Verificacion de aceptar documento------------- */
if($idaceptar > 0){
    $aceptar = "UPDATE documentos SET estatus = '2' WHERE id_documento = '$idaceptar' LIMIT 1";
    $resultado_acepta = mysqli_query($conexion_database, $aceptar);
}
/**------------------------------------------------------------------------- */

/*-----Consulta numero de datos en BD---------------------------------------------------------------------------*/
$consulta_1="SELECT id_documento FROM documentos WHERE folio LIKE '%$dato%' OR asunto LIKE '%$dato%'";
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

/*Consulta BD para mostrar registros encontrados----------------------------------------------------------------*/
$consulta_2="SELECT id_documento as id, folio, asunto, fecha_creacion, estatus FROM documentos WHERE folio LIKE '%$dato%' OR asunto LIKE '%$dato%' ORDER BY id_documento ASC LIMIT $limit, $nroLotes";
$registro_2=mysqli_query($conexion_database, $consulta_2);
$no_filas = mysqli_num_rows($registro_2);
/*--------------------------------------------------------------------------------------------------------------*/

$tabla = $tabla.'<div class="table-responsive">
                        <table class="table table-hover table-bordered">';
    if($no_filas > 0){
        $tabla = $tabla.'
                            <thead>
                                <tr> 
                                    <th><i class="fa-solid fa-gear"></i></th>
                                    <th>Folio</th>
                                    <th>Asunto</th>
                                    <th>Fecha</th>
                                    <th>Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
        ';
        while($row = mysqli_fetch_array($registro_2)){
                $id = $row["id"];
                $folio = $row["folio"];
                $asunto = $row["asunto"];
                $fecha = date("d-m-Y", strtotime($row["fecha_creacion"]));
                $estatus = $row["estatus"];
                if($estatus == 0){
                    $valor_estatus = '<span class="badge text-bg-danger">Cancelado</span>';
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
                }else if($estatus == 1){
                    $valor_estatus = '<span class="badge text-bg-warning">En proceso</span>';
                    $valor_botones = '
                        <button type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Editar Documento" onclick="Actualizar_documento('.$id.');">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Cancelar Documento" onclick="Eliminar_documento('.$id.');">
                            <i class="fa-solid fa-file-circle-xmark"></i>
                        </button>
                        <button type="button" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Aceptar Documento" onclick="Aceptar_documento('.$id.');">
                            <i class="fa-solid fa-file-circle-check"></i>
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Enviar Documento a otro Departamento" onclick="Enviar_documento('.$id.');">
                            <i class="fa-solid fa-file-arrow-up"></i>
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Ver Historial del Documento" onclick="Historial_documento('.$id.');">
                            <i class="fa-solid fa-box-archive"></i>
                        </button>
                    ';
                }else if($estatus == 2){
                    $valor_estatus = '<span class="badge text-bg-success">Aceptado</span>';
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
                        <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Enviar Documento a otro Departamento" onclick="Enviar_documento('.$id.');">
                            <i class="fa-solid fa-file-arrow-up"></i>
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Ver Historial del Documento" onclick="Historial_documento('.$id.');">
                            <i class="fa-solid fa-box-archive"></i>
                        </button>
                    ';
                }

                $tabla = $tabla.'
                                <tr>
                                    <td align="center">'.$valor_botones.'</td>
                                    <td>'.$folio.'</td>
                                    <td>'.$asunto.'</td>
                                    <td>'.$fecha.'</td>
                                    <td>'.$valor_estatus.'</td>
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
