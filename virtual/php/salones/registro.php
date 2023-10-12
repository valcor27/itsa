<?php 
  require("../conexion/conexion_bd.php");
  require("../sesion/logueo.php");
  require("../clases/limpiar.php");  
  $proceso = $_POST["proceso_salon"];
  $id = $_POST["id_salon"];
  $nombre = $_POST["nombre"];
  $edificio = $_POST["edificio"];
  $estatus = 1;
  $comprobacion = "0";
  date_default_timezone_set('America/Mexico_City');
  $fecha = date('Y-m-d');
  $usuario = $id_software_sesion;
  $nombre = strtoupper($nombre);
  /****-------------Buscamos el nombre del edificio-------------------------------------------------------- */
  if($edificio >= 1){
    $consulta_edificio = "SELECT nombre_edificio FROM edificio WHERE id_edificio = '$edificio' LIMIT 1";
    $resultado_edificio = mysqli_query($conexion_database, $consulta_edificio);
    while($reg_edificio = mysqli_fetch_array($resultado_edificio)){
      $nombre_edificio = $reg_edificio["nombre_edificio"];        
    }
    mysqli_free_result($resultado_edificio);
  }
  /**-------------------------------------------------------------------------------------------------------- */
  switch($proceso){
      case 'Registro':
        /***------Corroboramos que no se duplique el nombre del edificio -----*/
        $consulta_comparar = "SELECT id_salon FROM salon WHERE nombre_salon = '$nombre' AND estatus = '1' LIMIT 1";
        $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
        $filas_comparar = mysqli_num_rows($resultado_comparar);

        mysqli_free_result($resultado_comparar);
        /**------------------------------------------------------------------ */
        if($filas_comparar == 0){
          /**-------Insertamos si no se duplican ----------------------------- */
          $inserta = "INSERT INTO  salon(nombre_salon, edificio_id_edificio, nombre_edificio, estatus,
          fecha_movimiento, ultimo_movimiento, usuario_movimiento) 
          VALUES('$nombre', '$edificio', '$nombre_edificio', '$estatus', '$fecha', '$proceso', '$usuario')";
          $respuesta = mysqli_query($conexion_database, $inserta);
          /**----------------------------------------------------------------- */
        }else{
          $comprobacion = "1";
        }
      break;
      case 'Edicion':
      /***-------Corroboramos que no se duplique el nombre del salon----- */
      $consulta_comparar = "SELECT id_salon FROM salon WHERE id_salon <> '$id' AND nombre_salon = '$nombre' AND estatus = '1' LIMIT 1";
      $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
      $filas_comparar = mysqli_num_rows($resultado_comparar);

      mysqli_free_result($resultado_comparar);
      /**------------------------------------------------------------------- */
      if($filas_comparar == 0){
        $actualiza = "UPDATE salon SET nombre_salon = '$nombre', edificio_id_edificio = '$edificio', nombre_edificio = '$nombre_edificio',
        fecha_movimiento = '$fecha', ultimo_movimiento = '$proceso', 
        usuario_movimiento = '$usuario' WHERE id_salon = '$id' LIMIT 1";
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
  $consulta = "SELECT id_salon AS id, nombre_salon, nombre_edificio FROM salon WHERE nombre_salon = '$nombre' AND estatus = '1' LIMIT 1";
  $registro = mysqli_query($conexion_database, $consulta);
  $filas_venta = mysqli_num_rows($registro);
  /**-------------------------------------------------------------------- */
  $tabla = $tabla.'
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-list table-hover">
        <thead>
          <tr>
            <th><i class="fa-solid fa-gear"></i></th>
            <th>Edificio</th>
            <th>Nombre</th>
          </tr>
        </thead>
        <tbody>
  ';
  while($row = mysqli_fetch_array($registro)){
    $id = $row["id"];
    $n_edificio = $row["nombre_edificio"];
    $n_salon = $row["nombre_salon"];
    $tabla = $tabla.'
          <tr>
            <td align = "center">
              <button type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Actualizar Salón" onclick="Actualizar_salon('.$id.');">
                <i class="fas fa-edit"></i>
              </button>
              <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Eliminar Salón" onclick="Eliminar_salon('.$id.');">
                <i class="far fa-trash-alt"></i>
              </button>
            </td>
            <td>'.$n_edificio.'</td>
            <td>'.$n_salon.'</td>
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