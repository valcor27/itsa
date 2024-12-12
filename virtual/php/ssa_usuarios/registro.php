<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");
    $proceso = $_POST["proceso"];
    $expediente = $_POST["expediente"];
    $contrasena = $_POST["contrasena_usuario"];
    $nombre = $_POST["nom_usuario"];
    $apepat = $_POST["primer_apellido"];
    $apemat = $_POST["segundo_apellido"];
    $sexo = $_POST["sexo_usuario"];
    $fecha_nacimiento = date("Y-m-d", strtotime($_POST["fNaci"]));
    $rfc = $_POST["rfc_usuario"];
    $curp = $_POST["curp_usuario"];
    $cel = $_POST["cel_usuario"];
    $emailp = $_POST["emaip_usuario"];
    $emaili = $_POST["emaili_usuario"];
    $fecha_alta = date("Y-m-d", strtotime($_POST["fAlta"]));
    $nivel = $_POST["nivel_usuario"];
    $plaza = $_POST["plaza_usuario"];
    $real = $_POST["unidadReal_usuario"];
    $reportada = $_POST["unidadReportada_usuario"];
    $hora_entrada = isset($_POST["hora_entrada_admon"]) ? $_POST["hora_entrada_admon"] : null;
    $hora_entrada = date("H:i:s", strtotime($hora_entrada));
    $hora_salida = isset($_POST["hora_salida_admon"]) ? $_POST["hora_salida_admon"] : null;
    $hora_salida = date("H:i:s", strtotime($hora_salida));
    $estatus = 1;
    $comprobacion = "0";
    date_default_timezone_set('America/Mexico_City');
    $fecha = date('Y-m-d');
    $usuario = $id_software_sesion;
    
    $nombre = sanear_string($nombre);
    $apepat = sanear_string($apepat);
    $apemat = sanear_string($apemat);
    $emailp = sanear_normal($emailp);
    $emaili = sanear_normal($emaili);
    $rfc = strtoupper($rfc);
    $curp = strtoupper($curp);

    /*--------Buscamos el nombre de la plaza--------------*/
    if($plaza != ''){
        $consulta_plaza = "SELECT nombrePlaza FROM plaza WHERE codigoPlaza = '$plaza' LIMIT 1";
        $resultado_plaza = mysqli_query($conexion_database, $consulta_plaza);

        while($reg_plaza = mysqli_fetch_array($resultado_plaza)){
            $nombre_plaza = $reg_plaza["nombrePlaza"];
            $nombre_plaza = sanear_string($nombre_plaza);
        }
        mysqli_free_result($resultado_plaza);
    }
    /*----------------------------------------------------*/
    /*--------Buscamos el nombre de unidad real--------------*/
    if($real >= 1){
        $consulta_real = "SELECT nombreUnidad FROM estructuraorganica WHERE claveUnidad = '$real' LIMIT 1";
        $resultado_real = mysqli_query($conexion_database, $consulta_real);

        while($reg_real = mysqli_fetch_array($resultado_real)){
            $nombre_real = $reg_real["nombreUnidad"];
            $nombre_real = sanear_string($nombre_real);
        }
        mysqli_free_result($resultado_real);
    }
    /*----------------------------------------------------*/
    /*--------Buscamos el nombre de unidad reportada--------------*/
    if($reportada >= 1){
        $consulta_reportada = "SELECT nombreUnidad FROM estructuraorganica WHERE claveUnidad = '$reportada' LIMIT 1";
        $resultado_reportada = mysqli_query($conexion_database, $consulta_reportada);

        while($reg_reportada = mysqli_fetch_array($resultado_reportada)){
            $nombre_reportada = $reg_reportada["nombreUnidad"];
            $nombre_reportada = sanear_string($nombre_reportada);
        }
        mysqli_free_result($resultado_reportada);
    }
    /*----------------------------------------------------*/

    switch($proceso){
        case 'Registro':
            /*------Corroboramos que no se duplique el email del empleado-----*/
            $consulta_comparar = "SELECT expediente FROM empleados WHERE  mailI = '$emaili' AND estatus = '1' LIMIT 1";
            $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
            $filas_comparar = mysqli_num_rows($resultado_comparar);

            mysqli_free_result($resultado_comparar);
            /*---------------------------------------------------------------------*/
            if($filas_comparar == 0){        
                /**-------Insertamos los datos si no se duplican---------------------- */
                $inserta = "INSERT INTO empleados(expediente, primerApellido, segundoApellido, nombres, sexo, 
                fNaci, rfc, curp, contrasena, celular, mailP, mailI, fAlta, nivel_idNivelUsuario, plaza_codigoPlaza, 
                plaza_nombrePlaza, estructuraReportada, reportada_nombreUnidad, estructuraReal, real_nombreUnidad, 
                hora_entrada, hora_salida, estatus, fecha_movimiento, ultimo_movimiento, usuario_movimiento)values('$expediente','$apepat',
                '$apemat','$nombre','$sexo','$fecha_nacimiento','$rfc','$curp','$contrasena',
                '$cel','$emailp','$emaili','$fecha_alta','$nivel','$plaza','$nombre_plaza','$reportada','$nombre_reportada',
                '$real','$nombre_real', '$hora_entrada', '$hora_salida','$estatus','$fecha','$proceso','$usuario')";
                $proceso=mysqli_query($conexion_database, $inserta);
            }else{
                $comprobacion = "1";
            }
            /**------------------------------------------------------------------- */
        break;
        case 'Edicion':
            /*Corroboramos que no se duplique el email institucional, rfc, o curp---------------*/
            $consulta_comparar = "SELECT expediente FROM empleados WHERE expediente <> '$expediente' AND mailI = '$emaili' AND estatus = '1' LIMIT 1";
            $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
            $filas_comparar = mysqli_num_rows($resultado_comparar);

            mysqli_free_result($resultado_comparar);
            /*-----------------------------------------------------------------------------------*/
            /*-----------Actualizamos registro si no hay datos duplicados------------------------------ */
            if($filas_comparar == 0){
                $actualiza = "UPDATE empleados SET primerApellido = '$apepat', segundoApellido = '$apemat', nombres = '$nombre', sexo = '$sexo', 
                fNaci = '$fecha_nacimiento', rfc = '$rfc', curp = '$curp', contrasena = '$contrasena', celular = '$cel', mailP = '$emailp', 
                mailI = '$emaili', fAlta = '$fecha_alta', nivel_idNivelUsuario = '$nivel', plaza_codigoPlaza = '$plaza', 
                plaza_nombrePlaza = '$nombre_plaza', estructuraReportada = '$reportada', reportada_nombreUnidad = '$nombre_reportada',
                estructuraReal = '$real', real_nombreUnidad = '$nombre_real', fecha_movimiento = '$fecha', 
                ultimo_movimiento = '$proceso', usuario_movimiento = '$usuario', hora_entrada = '$hora_entrada', hora_salida = '$hora_salida' WHERE expediente = '$expediente' LIMIT 1";
                $resultado_actualiza = mysqli_query($conexion_database, $actualiza);
            }else{
                $comprobacion = "1";
            }
            /**---------------------------------------------------------------------------------------- */
        break;
    }
    $lista_info = '';
  $lista = '';
  $tabla = '';

  /*-----Lista de información de paginas-----------------------------------------------------------------------------*/
  $lista_info = $lista_info.'Pag. 1 / 1';

  /*Realizamos la paginacion para tablestas y pc*/
    $lista = $lista.'
      <ul class="pagination linea_derecha">
        <li class="page-item disabled">
          <a class="page-link" href="#Anterior">
            <i class="fas fa-arrow-alt-circle-left"></i>
          </a>
        </li>

        <li class="page-item active">
          <a class="page-link" href="#Paginar">1</a>
        </li>

        <li class="page-item disabled">
          <a class="page-link" href="#Siguiente">
            <i class="fas fa-arrow-alt-circle-right"></i>
          </a>
        </li>
      </ul>';
  /*-----------------------------------------------------------------------------------------------------------------*/  

  /*-----Consultamos la base de datos completa para mostrar los registros------------------------------------------*/
  $consulta="SELECT expediente as id, nombres, primerApellido, segundoApellido, domicilio_idDomicilio FROM empleados WHERE expediente='$expediente' AND estatus='1' LIMIT 1";
  $registro=mysqli_query($conexion_database, $consulta);
  $filas_venta = mysqli_num_rows($registro);
/*--------------------------------------------------------------------------------------------------------------*/
  
$tabla = $tabla.'<div class="table-responsive">
                  <table class="table table-striped table-bordered table-list table-hover">
                    <thead>
                      <tr>
                        <th><i class="fa-solid fa-gear"></i></th>
                        <th>Expediente</th>
                        <th>Nombre Completo</th>
                        <th>Domicilio</th> 
                      </tr>
                    </thead>
                    <tbody>';

while($row = mysqli_fetch_array($registro)) { 
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
                    </tbody>
                  </table>
                </div>';

$array = array(
  0 => $tabla,
  1 => $lista_info,
  2 => $lista,
  3 => $comprobacion
);

echo json_encode($array);

mysqli_free_result($registro);
mysqli_close($conexion_database);
?>