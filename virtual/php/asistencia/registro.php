<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");
    $proceso = $_POST["proceso_asistencia"];
    $id = $_POST["id_asistencia"];
    $f_inicio = date("Y-m-d", strtotime($_POST["fecha_inicio"]));
    $f_fin = date("Y-m-d", strtotime($_POST["fecha_fin"]));
    $f_nombre_inicio = $_POST["fecha_inicio"];
    $f_nombre_fin = $_POST["fecha_fin"];
    $archivo = $_FILES["archivo_asistencia"];
    $estatus = 1;
    $comprobacion = "0";
    date_default_timezone_set('America/Mexico_City');
    $fecha_movimiento = date('Y-m-d');
    $usuario = $id_software_sesion;
    $archivo_nuevo_nombre = "quincena_del_" . $f_nombre_inicio . "_al_" . $f_nombre_fin .".txt";
    $ruta_carpteta = "../../documentos_asistencia/";
    $ruta_guardar_archivo = $ruta_carpteta . $archivo_nuevo_nombre;
    switch($proceso){
        case 'Registro':
            if ($archivo["type"] == "text/plain") {
                /**Que no se duplique las fechas que utilizan para insertar */
                $consulta_comparar = "SELECT id_asistencia FROM asistencia WHERE nombre_txt = '$archivo_nuevo_nombre' AND estatus = '1' LIMIT 1";
                $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
                $filas_comparar = mysqli_num_rows($resultado_comparar);
                mysqli_free_result($resultado_comparar);
                /**-------------------------------------------------------- */
                if($filas_comparar == 0){
                    /**Insertamos los datos si no se duplican */
                    $inserta = "INSERT INTO asistencia(nombre_txt, fecha_inicio, fecha_fin, 	
                    ultimo_movimiento, fecha_movimiento, usuario_movimiento, estatus)VALUES(
                    '$archivo_nuevo_nombre','$f_inicio','$f_fin','$proceso','$fecha_movimiento',
                    '$usuario','$estatus')";
                    $respuesta_inserta = mysqli_query($conexion_database, $inserta);
                    /**-------------------------------------- */
                    /**Movemos el archivo a la carpeta de documentos  */
                    move_uploaded_file($archivo["tmp_name"], $ruta_guardar_archivo);
                    /**---------------------------------------------- */
                }else{
                    $comprobacion = "1";
                }
            } else {
               $comprobacion = "2";
            }
        break;
        case 'Edicion':
            if ($archivo["type"] == "text/plain") {
                /**Que no se duplique las fechas que utilizan para insertar */
                $consulta_comparar = "SELECT id_asistencia FROM asistencia WHERE id_asistencia <> '$id' AND nombre_txt = '$archivo_nuevo_nombre' AND estatus = '1' LIMIT 1";
                $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
                $filas_comparar = mysqli_num_rows($resultado_comparar);
                mysqli_free_result($resultado_comparar);
                /**-------------------------------------------------------- */
                if($filas_comparar == 0){
                    $actualiza = "UPDATE asistencia SET nombre_txt = '$archivo_nuevo_nombre',
                    fecha_inicio = '$f_inicio', fecha_fin = '$f_fin', ultimo_movimiento = '$proceso', 
                    fecha_movimiento = '$fecha_movimiento', usuario_movimiento = '$usuario'
                    WHERE id_asistencia = '$id' LIMIT 1";
                    $resultado_actualiza = mysqli_query($conexion_database, $actualiza);
                    if(file_exists($ruta_guardar_archivo)){
                        unlink($ruta_guardar_archivo);
                    }
                    move_uploaded_file($archivo["tmp_name"], $ruta_guardar_archivo);
                }else{
                    $comprobacion = "1";
                }
            } else {
               $comprobacion = "2";
            }
        break;
    }
    
    $lista_info = '';
  $lista = '';
  $tabla = '';
  /*--Lista de informacion de paginas---------------------- */
  $lista_info = $lista_info.'Pag. 1/1';
  /**------------------------------------------------------ */
  /**Realizamos la paginacion para tabletas y pc----------- */
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
    </ul>
  ';
  /**------------------------------------------------------ */
  /**Consultamos la base de datos completa para mostrar el registro------ */
  $consulta = "SELECT id_asistencia AS id, nombre_txt, fecha_inicio, fecha_fin FROM asistencia WHERE nombre_txt = '$archivo_nuevo_nombre' AND estatus = '1' LIMIT 1";
  $registro = mysqli_query($conexion_database, $consulta);
  $filas_venta = mysqli_num_rows($registro);
  /**-------------------------------------------------------------------- */
  $tabla = $tabla.'
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-list table-hover">
        <thead>
            <tr>
                <th><i class="fa-solid fa-gear"></i></th>
                <th>Nombre Archivo</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Detalle Asistencia</th>
            </tr>
        </thead>
        <tbody>
    ';
    while($row = mysqli_fetch_array($registro)){
        $id = $row["id"];
        $nombre_archivo = $row["nombre_txt"];
        $fecha_inicio = date("d-m-Y", strtotime($row["fecha_inicio"]));
        $fecha_fin = date("d-m-Y", strtotime($row["fecha_fin"]));
        $tabla = $tabla.'
                            <tr>
                                <td align="center">
                                    <button type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Actualizar Asistencia" onclick="Actualizar_asistencia('.$id.');">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Eliminar Asistencia" onclick="Eliminar_asistencia('.$id.');">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </td>
                                <td>'.$nombre_archivo.'</td>
                                <td>'.$fecha_inicio.'</td>
                                <td>'.$fecha_fin.'</td>
                                <td align="center"> 
                                    <button type="button" class="btn btn-primary" onclick="Examina_asistencia_quincenal('.$id.');">
                                        <i class="fa-solid fa-clipboard-user"></i>
                                    </button>
                                </td>
                            </tr>
        ';
    }
    $tabla = $tabla.'
        </tbody>
      </table>
    </div>
    ';
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

