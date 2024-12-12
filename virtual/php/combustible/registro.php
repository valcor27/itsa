<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");
    $proceso = $_POST["proceso_combustible"];
    $id = $_POST["id_combustible"];
    $nombre = $_POST["nombre_combustible"];
    $precio = $_POST["precio_combustible"];
    
    $nombre = sanear_string($nombre);
    $estatus = 1;
    $comprobacion = '0';
    date_default_timezone_set('America/Mexico_City');
    $fecha = date('Y-m-d');
    $usuario = $id_software_sesion;
    /**--Comenzamos el registro y/o edicion segun sea el caso--- */
    switch($proceso){
        case 'Registro':
            /**Corroboramos que no se duplique el nombre-- */
            $consulta_comparar = "SELECT id_combustible FROM combustible WHERE nombre = '$nombre' AND estatus = '1' LIMIT 1";
            $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
            $filas_comparar = mysqli_num_rows($resultado_comparar);
            mysqli_free_result($resultado_comparar);
            /**------------------------------------------------------------------ */
            if($filas_comparar == 0){
                /**Insertamos si no se duplican */
                $inserta = "INSERT INTO combustible(nombre, precio, estatus, fecha_movimiento, 
                ultimo_movimiento, usuario_movimiento)VALUES('$nombre',
                '$precio', '$estatus', '$fecha', '$proceso', '$usuario')";
                $respuesta = mysqli_query($conexion_database, $inserta);
                /**---------------------------- */
            }else{
                $comprobacion = "1";
            }
        break;
        case 'Edicion':
            /***Corroboramos que no se duplique el nombre  */
            $consulta_comparar = "SELECT id_combustible FROM combustible WHERE id_combustible <> '$id' AND nombre = '$nombre' AND estatus = '1' LIMIT 1";
            $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
            $filas_comparar = mysqli_num_rows($resultado_comparar);
            /**-------------------------------------------------------------------------------------- */
            if($filas_comparar == 0){
                $actualiza = "UPDATE combustible SET nombre = '$nombre', precio = '$precio', 
                fecha_movimiento = '$fecha', ultimo_movimiento = '$proceso', usuario_movimiento = '$usuario' 
                WHERE id_combustible = '$id' LIMIT 1";
                $respuesta = mysqli_query($conexion_database, $actualiza);
            }else{
                $comprobacion = "1";
            }    
        break;
    }
    /**--------------------------------------------------------- */
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
    $consulta = "SELECT id_combustible AS id, nombre, precio FROM combustible WHERE nombre = '$nombre' AND estatus = '1' LIMIT 1";
    $registro = mysqli_query($conexion_database, $consulta);
    $filas_venta = mysqli_num_rows($registro);
    /**-------------------------------------------------------------------- */
    $tabla = $tabla.'
      <div class="table-responsive">
        <table class="table table-striped table-bordered table-list table-hover">
          <thead>
              <tr>
                <th><i class="fa-solid fa-gear"></i></th>
                <th>Combustible</th>
                <th>Precio</th>
              </tr>
          </thead>
          <tbody>
      ';
      while($row = mysqli_fetch_array($registro)){
        $id = $row["id"];
        $nombre = $row["nombre"];
        $precio = $row["precio"];
        $tabla = $tabla.'
                        <tr>
                            <td align="center">
                                <button type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Actualizar Vehiculo" onclick="Actualizar_combustible('.$id.');">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Eliminar Vehiculo" onclick="Eliminar_combustible('.$id.');">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </td>
                            <td>'.$nombre.'</td>
                            <td> $'.$precio.'</td>
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