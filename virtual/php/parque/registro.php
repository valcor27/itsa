<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");
    $proceso = $_POST["proceso_vehiculo"];
    $id = $_POST["id_vehiculo"];
    $placa = strtoupper($_POST["placa"]);
    $serie = strtoupper($_POST["noserie"]);
    $kmini = $_POST["kminicial"];
    $tipo = $_POST["tipo"];
    $cilindro = $_POST["cilindro"];
    $kmporlitro = $_POST["kmporlitro"];
    $modelo = $_POST["modelo"];
    $color = $_POST["color"];
    $marca = strtolower($_POST["marca"]);
    $submarca = strtolower($_POST["submarca"]);
    $marca = sanear_string($marca);
    $submarca = sanear_string($submarca);
    $estatus = 1;
    $comprobacion = '0';
    date_default_timezone_set('America/Mexico_City');
    $fecha = date('Y-m-d');
    $usuario = $id_software_sesion;
    /**--Comenzamos el registro y/o edicion segun sea el caso--- */
    switch($proceso){
        case 'Registro':
            /**Corroboramos que no se dupliquen las placas o el numero de serie-- */
            $consulta_comparar = "SELECT idvehiculo FROM vehiculo WHERE (placas = '$placa' OR noserie = '$serie') AND estatus = '1' LIMIT 1";
            $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
            $filas_comparar = mysqli_num_rows($resultado_comparar);
            mysqli_free_result($resultado_comparar);
            /**------------------------------------------------------------------ */
            if($filas_comparar == 0){
                /**Insertamos si no se duplican */
                $inserta = "INSERT INTO vehiculo(placas, noserie, 
                kminicial, tipo, cilindro, kmporlitro, modelo, 
                color, marca, submarca, estatus, fecha_movimiento, 
                ultimo_movimiento, usuario_movimiento)VALUES('$placa',
                '$serie', '$kmini', '$tipo', '$cilindro', '$kmporlitro',
                '$modelo', '$color', '$marca', '$submarca', '$estatus',
                '$fecha', '$proceso', '$usuario')";
                $respuesta = mysqli_query($conexion_database, $inserta);
                /**---------------------------- */
            }else{
                $comprobacion = "1";
            }
        break;
        case 'Edicion':
            /***Corroboramos que no se dupliquen las fechas para el empleado en diferente incidencia  */
            $consulta_comparar = "SELECT idvehiculo FROM vehiculo WHERE idvehiculo <> '$id' AND (placas = '$placa' OR noserie = '$serie') AND estatus = '1' LIMIT 1";
            $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
            $filas_comparar = mysqli_num_rows($resultado_comparar);
            /**-------------------------------------------------------------------------------------- */
            if($filas_comparar == 0){
                $actualiza = "UPDATE vehiculo SET placas = '$placa', noserie = '$serie', kminicial  = '$kmini',
                tipo = '$tipo', cilindro = '$cilindro', kmporlitro = '$kmporlitro', modelo = '$modelo', 
                color = '$color', marca = '$marca', submarca = '$submarca', 
                fecha_movimiento = '$fecha', ultimo_movimiento = '$proceso', usuario_movimiento = '$usuario' 
                WHERE idvehiculo = '$id' LIMIT 1";
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
    $consulta = "SELECT idvehiculo AS id, marca, submarca, modelo, placas FROM vehiculo WHERE placas = '$placa' AND estatus = '1' LIMIT 1";
    $registro = mysqli_query($conexion_database, $consulta);
    $filas_venta = mysqli_num_rows($registro);
    /**-------------------------------------------------------------------- */
    $tabla = $tabla.'
      <div class="table-responsive">
        <table class="table table-striped table-bordered table-list table-hover">
          <thead>
              <tr>
                    <th><i class="fa-solid fa-gear"></i></th>
                    <th>Vehiculo</th>
                    <th>Modelo</th>
                    <th>Placas</th>
              </tr>
          </thead>
          <tbody>
      ';
      while($row = mysqli_fetch_array($registro)){
        $id = $row["id"];
        $marca = $row["marca"];
        $submarca = $row["submarca"];
        $modelo = $row["modelo"];
        $placas = $row["placas"];
        $n_carro = $marca.', '.$submarca; 
        $tabla = $tabla.'
                        <tr>
                            <td align="center">
                                <button type="button" class="btn btn-warning" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Actualizar Vehiculo" onclick="Actualizar_vehiculo('.$id.');">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Eliminar Vehiculo" onclick="Eliminar_vehiculo('.$id.');">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </td>
                            <td>'.$n_carro.'</td>
                            <td>'.$modelo.'</td>
                            <td>'.$placas.'</td>
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