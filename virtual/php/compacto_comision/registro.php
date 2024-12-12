<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");
    $proceso = $_POST["proceso"];
    $id = $_POST["id"];
    $vehiculo = $_POST["id_vehiculo"];
    $id_comisiones = $_POST["id_comisiones"];
    sort($id_comisiones);
    $comisiones = implode(',', $id_comisiones); 
    //$nombre_vehiculo = $_POST["nombre_vehiculo"];
    $km_i = $_POST["km_inicial"];
    $km_f = $_POST["km_final"];
    $km_r = $_POST["km_recorridos"];
    $casetas = $_POST["casetas"];
    $viaticos_combustible = $_POST["combustible"];
    $id_gasolina = $_POST["tipo_gasolina"];
    $departamentos = implode(',', $_POST["id_departamentos"]);
    date_default_timezone_set('America/Mexico_City');
    $fecha_movimiento = date('Y-m-d');
    $usuario = $id_software_sesion;
    $estatus = 1;
    $comprobacion = "0";

    /**Buscamos el precio del combustible en ese momento------ */
    if($id_gasolina >= 1){
        $consulta_gasolina = "SELECT nombre, precio FROM combustible WHERE id_combustible = '$id_gasolina' LIMIT 1";
        $resultado_gasolina = mysqli_query($conexion_database, $consulta_gasolina);
        while($reg_gas = mysqli_fetch_array($resultado_gasolina)){
            $nombre_gasolina = $reg_gas["nombre"];
            $precio_gasolina = $reg_gas["precio"];
        }
        mysqli_free_result($resultado_gasolina);
    }
    /**------------------------------------------------------- */

    switch($proceso){
        case 'Registro':
            /***Corroboramos que no se duplique los id de las comisiones---------------------- */
            /*$consulta_comparar = "SELECT id_historial_parque_comision 
            FROM historial_parque_comision 
            WHERE comisiones_id_comisiones = '$comisiones'      
            AND estatus = '1' 
            LIMIT 1";*/
           /* $consulta_comparar = "SELECT id_historial_parque_comision 
            FROM historial_parque_comision 
            WHERE ";
        if (count($id_comisiones) > 1) {
            $consulta_comparar .= "FIND_IN_SET(comisiones_id_comisiones, '$comisiones') ";
        } else {
            $consulta_comparar .= "(comisiones_id_comisiones = '$comisiones' OR FIND_IN_SET('$comisiones', comisiones_id_comisiones)) ";
        }
        $consulta_comparar .= "AND estatus = '1' 
            LIMIT 1";*/
            $consulta_comparar = "SELECT id_historial_parque_comision 
                FROM historial_parque_comision 
                WHERE ";

            if (count($id_comisiones) > 1) {
                // Si hay más de un ID, verifica cada ID individualmente
                $consulta_comparar .= "(";
                foreach ($id_comisiones as $id_comision) {
                    $consulta_comparar .= "FIND_IN_SET('$id_comision', comisiones_id_comisiones) OR ";
                }
                // Quita el último 'OR'
                $consulta_comparar = rtrim($consulta_comparar, " OR ");
                $consulta_comparar .= ") ";
            } else {
                // Si es solo un ID, verifica directamente ese ID
                $consulta_comparar .= "(comisiones_id_comisiones = '$comisiones' OR FIND_IN_SET('$comisiones', comisiones_id_comisiones)) ";
            }

            $consulta_comparar .= "AND estatus = '1' LIMIT 1";
            $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar); 
            $filas_comparar = mysqli_num_rows($resultado_comparar);

            
            mysqli_free_result($resultado_comparar);
            /**------------------------------------------------------------------------------- */
            if($filas_comparar == 0){
                /**Insertamos los datos si no existe duplicidad */
                $inserta = "INSERT INTO historial_parque_comision(comisiones_id_comisiones, vehiculo_id_vehiculo, km_inicial, km_final, 
                km_recorridos, viatico_casetas, viatico_combustible, id_combustible, nombre_combustible, precio_combustible, 
                departamento_id_departamento, estatus, fecha_movimiento, ultimo_movimiento, usuario_movimiento)VALUES('$comisiones','$vehiculo',
                '$km_i','$km_f','$km_r','$casetas','$viaticos_combustible','$id_gasolina','$nombre_gasolina','$precio_gasolina','$departamentos',
                '$estatus','$fecha_movimiento','$proceso','$usuario')";
                $query = mysqli_query($conexion_database, $inserta);
                /**-------------------------------------------- */
            }else{
                $comprobacion = "1";
            }
        break;
        case 'Edicion':
            /**-------------Corroboramos que no se duplique los id's de las comisiones seleccionadas- */
            /*$consulta_comparar = "SELECT id_historial_parque_comision 
            FROM historial_parque_comision 
            WHERE id_historial_parque_comision <> '$id' AND comisiones_id_comisiones = '$comisiones'
            AND estatus = '1' 
            LIMIT 1";
            $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar); 
            $filas_comparar = mysqli_num_rows($resultado_comparar);/*/
            /*$consulta_comparar = "SELECT id_historial_parque_comision 
            FROM historial_parque_comision 
            WHERE id_historial_parque_comision <> '$id'";
        if (count($id_comisiones) > 1) {
            $consulta_comparar .= "FIND_IN_SET(comisiones_id_comisiones, '$comisiones') ";
        } else {
            $consulta_comparar .= "(comisiones_id_comisiones = '$comisiones' OR FIND_IN_SET('$comisiones', comisiones_id_comisiones)) ";
        }
        $consulta_comparar .= "AND estatus = '1' 
            LIMIT 1";*/
            $consulta_comparar = "SELECT id_historial_parque_comision 
                FROM historial_parque_comision 
                WHERE id_historial_parque_comision <> '$id' AND ";

            if (count($id_comisiones) > 1) {
                // Si hay más de un ID, verifica cada ID individualmente
                $consulta_comparar .= "(";
                foreach ($id_comisiones as $id_comision) {
                    $consulta_comparar .= "FIND_IN_SET('$id_comision', comisiones_id_comisiones) OR ";
                }
                // Quita el último 'OR'
                $consulta_comparar = rtrim($consulta_comparar, " OR ");
                $consulta_comparar .= ") ";
            } else {
                // Si es solo un ID, verifica directamente ese ID
                $consulta_comparar .= "(comisiones_id_comisiones = '$comisiones' OR FIND_IN_SET('$comisiones', comisiones_id_comisiones)) ";
            }

            $consulta_comparar .= "AND estatus = '1' LIMIT 1";

            $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar); 
            $filas_comparar = mysqli_num_rows($resultado_comparar);
            mysqli_free_result($resultado_comparar);
            /**-------------------------------------------------------------------------------------- */
            if($filas_comparar == 0){
                $actualiza = "UPDATE historial_parque_comision SET comisiones_id_comisiones = '$comisiones', vehiculo_id_vehiculo = '$vehiculo', 
                km_inicial = '$km_i', km_final = '$km_f', km_recorridos = '$km_r', viatico_casetas = '$casetas', viatico_combustible = '$viaticos_combustible', 
                id_combustible = '$id_gasolina', nombre_combustible = '$nombre_gasolina', precio_combustible = '$precio_gasolina', 
                departamento_id_departamento = '$departamentos', fecha_movimiento = '$fecha_movimiento', ultimo_movimiento = '$proceso', usuario_movimiento = '$usuario'
                WHERE id_historial_parque_comision = '$id' LIMIT 1";
                $query = mysqli_query($conexion_database, $actualiza);
            }else{
                $comprobacion = "1";
            }
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
        WHERE hp.comisiones_id_comisiones = '$comisiones' AND hp.estatus = '1'
        GROUP BY hp.id_historial_parque_comision
        ORDER BY hp.id_historial_parque_comision LIMIT 1  
    ";
    $registro = mysqli_query($conexion_database, $consulta_2);
    $filas_venta = mysqli_num_rows($registro);
    /**-------------------------------------------------------------------------------------------------------------- */
    $tabla = $tabla.='
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
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
    while($row = mysqli_fetch_array($registro)){
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