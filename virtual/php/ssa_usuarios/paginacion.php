<?php
	require("../conexion/conexion_bd.php");
  require("../sesion/logueo.php");
  require("../clases/limpiar.php");

	$paginaActual = $_POST['partida'];
  $dato = $_POST['dato'];
  $ideliminar = $_POST['ideliminar'];
  date_default_timezone_set('America/Mexico_City');
  $fecha = date('Y-m-d');
  $usuario = $id_software_sesion;
  $dato=sanear_normal($dato);
  $proceso = "Eliminacion";

  /*-----Verificación de eliminar---------------------------------------------------------------------------------*/
    if($ideliminar > 0){
      //$eliminar="UPDATE empleados SET estatus='0' WHERE expediente='$ideliminar', fecha_movimiento='$fecha', ultimo_movimiento='$proceso', usuario_movimiento='$usuario' LIMIT 1";
      $eliminar="UPDATE empleados SET estatus='0', fecha_movimiento='$fecha', ultimo_movimiento='$proceso', usuario_movimiento='$usuario' WHERE expediente='$ideliminar' LIMIT 1";
      $resultado_elimina=mysqli_query($conexion_database, $eliminar);
    }
  /*--------------------------------------------------------------------------------------------------------------*/
  
  /*-----Consulta numero de datos en BD---------------------------------------------------------------------------*/
    $consulta_1="SELECT expediente FROM empleados WHERE (primerApellido LIKE '%$dato%' OR segundoApellido LIKE '%$dato%' OR nombres LIKE '%$dato%' OR expediente LIKE '%$dato%') AND estatus='1'";
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

  /*-----Paginación para tablestas y pc---------------------------------------------------------------------------*/
    $lista = $lista.'<ul class="pagination">';

    if($paginaActual > 1){
      $lista = $lista.'
      <li class="page-item">
        <a class="page-link" href="#Anterior" aria-label="Previous" onclick="Pagination_usuarios('.($paginaActual-1).');">
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
          <a class="page-link" href="#Paginar" onclick="Pagination_usuarios('.$i.');">'.$i.'</a>
        </li>';
      }else{     
        $lista = $lista.'
        <li class="page-item">
          <a class="page-link" href="#Paginar" onclick="Pagination_usuarios('.$i.');">'.$i.'</a>
        </li>';
      }   
    }    

    if($paginaActual < $nroPaginas){
      $lista = $lista.'
      <li class="page-item">
        <a class="page-link" href="#Siguiente" aria-label="Next" onclick="Pagination_usuarios('.($paginaActual+1).');">
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
    $consulta_2="SELECT expediente as id, nombres, primerApellido, segundoApellido, domicilio_idDomicilio FROM empleados WHERE (primerApellido LIKE '%$dato%' OR segundoApellido LIKE '%$dato%' OR nombres LIKE '%$dato%' OR expediente LIKE '%$dato%') AND estatus='1' ORDER BY expediente ASC LIMIT $limit, $nroLotes";
    $registro_2=mysqli_query($conexion_database, $consulta_2);
    $no_filas = mysqli_num_rows($registro_2);
  /*--------------------------------------------------------------------------------------------------------------*/
    
 $tabla = $tabla.'<div class="table-responsive">
                    <table class="table table-hover table-bordered">';
  
if ($no_filas > 0){  
 
 $tabla = $tabla.' 
                      <thead>
                        <tr>
                          <th><i class="fa-solid fa-gear"></i></th>
                          <th>Expediente</th>
                          <th>Nombre</th>
                          <th>Domicilio</th>  
                        </tr>  
                      </thead>
                      <tbody>';

  while($row = mysqli_fetch_array($registro_2)) { 
    $id=$row["id"];
    $nombre = $row["nombres"];
    $apepat = $row["primerApellido"];
    $apemat = $row["segundoApellido"];
    $nombre_completo = $nombre.' '.$apepat.' '.$apemat;
    $domicilio = $row["domicilio_idDomicilio"];
    if($domicilio > 0){
      $button_domicilio = '<button type="button" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Actualizar Domicilio" onclick="Actualizar_domicilio_usuario('.$id.','.$domicilio.');">
                            <i class="fa-solid fa-house-chimney"></i>  
                          </button>';
    }else{
      $button_domicilio = '<button type="button" class="btn btn-outline-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Agregar Domicilio" onclick="Modal_configuracion_domicilio_usuarios('.$id.');">
                            <i class="fa-solid fa-house-chimney"></i>  
                          </button>';
    }
    $tabla = $tabla.'                   
                            <tr>
                                <td align="center">
                                  <button type="button" class="btn btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Ver Detalles Usuario" onclick="Informacion_usuarios('.$id.')">
                                      <i class="fa-solid fa-person-circle-question"></i>
                                  </button>
                                  <button type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Actualizar Usuario" onclick="Actualizar_usuarios('.$id.');">
                                      <i class="fas fa-edit"></i>
                                  </button>
                                  <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Eliminar Usuario" onclick="Eliminar_usuarios('.$id.');">
                                      <i class="far fa-trash-alt"></i>
                                  </button>
                                </td>      
                                <td>'.$id.'</td>                    
                                <td>'.$nombre_completo.'</td>    
                                <td align="center">
                                  '.$button_domicilio.'
                                </td> 
                            </tr>';
  }

    $tabla = $tabla.' 
                      </tbody>';
  
}else{

  $tabla = $tabla.'<div class="alert alert-info">
                    <strong>Mensaje!</strong> No se encontro ningún registro.
                  </div> ';  
} 

 $tabla = $tabla.'             
                    </table>
                  </div>';

  $array = array(
    0 => $tabla,
    1 => $lista_info, 
    2 => $lista
  );

  echo json_encode($array);

  mysqli_free_result($registro_2);
  mysqli_close($conexion_database);  
?>