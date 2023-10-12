<?php 
  require("../conexion/conexion_bd.php");
  require("../sesion/logueo.php");
  require("../clases/limpiar.php");  
  $proceso = $_POST["proceso_grupo"];
  $id = $_POST["id_grupo"];
  $nombre = $_POST["nombre"];
  $division = $_POST["division"];
  $estatus = 1;
  $comprobacion = "0";
  date_default_timezone_set('America/Mexico_City');
  $fecha = date('Y-m-d');
  $usuario = $id_software_sesion;
  $nombre = strtoupper($nombre);
  /****-------------Buscamos el nombre de la division------------------------------------------------------- */
  if($division >= 1){
    $consulta_division = "SELECT nombre_division FROM division WHERE id_division = '$division' LIMIT 1";
    $resultado_division = mysqli_query($conexion_database, $consulta_division);
    while($reg_division = mysqli_fetch_array($resultado_division)){
      $nombre_division = $reg_division["nombre_division"];        
    }
    mysqli_free_result($resultado_division);
  }
  /**-------------------------------------------------------------------------------------------------------- */
  switch($proceso){
      case 'Registro':
        /***------Corroboramos que no se duplique el nombre del edificio -----*/
        $consulta_comparar = "SELECT id_grupo FROM grupo WHERE nombre_grupo = '$nombre' AND estatus = '1' LIMIT 1";
        $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
        $filas_comparar = mysqli_num_rows($resultado_comparar);

        mysqli_free_result($resultado_comparar);
        /**------------------------------------------------------------------ */
        if($filas_comparar == 0){
            /**-------Insertamos si no se duplican ----------------------------- */
            $inserta = "INSERT INTO  grupo(nombre_grupo, division_id_division, nombre_division, estatus,
            fecha_movimiento, ultimo_movimiento, usuario_movimiento) 
            VALUES('$nombre', '$division', '$nombre_division', '$estatus', '$fecha', '$proceso', '$usuario')";
            $respuesta = mysqli_query($conexion_database, $inserta);
            /**----------------------------------------------------------------- */
        }else{
            $comprobacion = "1";
        }
    break;
    case 'Edicion':
        /***-------Corroboramos que no se duplique el nombre del salon----- */
        $consulta_comparar = "SELECT id_grupo FROM grupo WHERE id_grupo <> '$id' AND nombre_grupo = '$nombre' AND estatus = '1' LIMIT 1";
        $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
        $filas_comparar = mysqli_num_rows($resultado_comparar);

        mysqli_free_result($resultado_comparar);
        /**------------------------------------------------------------------- */
        if($filas_comparar == 0){
            $actualiza = "UPDATE grupo SET nombre_grupo = '$nombre', division_id_division = '$division', nombre_division = '$nombre_division',
            fecha_movimiento = '$fecha', ultimo_movimiento = '$proceso', 
            usuario_movimiento = '$usuario' WHERE id_grupo = '$id' LIMIT 1";
            $resultado_actualiza = mysqli_query($conexion_database, $actualiza);
        }else{
            $comprobacion = "1";
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
  $consulta = "SELECT id_grupo AS id, nombre_grupo, nombre_division FROM grupo WHERE nombre_grupo = '$nombre' AND estatus = '1' LIMIT 1";
  $registro = mysqli_query($conexion_database, $consulta);
  $filas_venta = mysqli_num_rows($registro);
  /**-------------------------------------------------------------------- */
  $tabla = $tabla.'
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-list table-hover">
        <thead>
          <tr>
            <th><i class="fa-solid fa-gear"></i></th>
            <th>División</th>
            <th>Nombre</th>
          </tr>
        </thead>
        <tbody>
  ';
  while($row = mysqli_fetch_array($registro)){
    $id = $row["id"];
    $n_division = $row["nombre_division"];
    $n_grupo = $row["nombre_grupo"];
    $tabla = $tabla.'
          <tr>
            <td align = "center">
              <button type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Actualizar Grupo" onclick="Actualizar_grupo('.$id.');">
                <i class="fas fa-edit"></i>
              </button>
              <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Eliminar Grupo" onclick="Eliminar_grupo('.$id.');">
                <i class="far fa-trash-alt"></i>
              </button>
            </td>
            <td>'.$n_division.'</td>
            <td>'.$n_grupo.'</td>
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