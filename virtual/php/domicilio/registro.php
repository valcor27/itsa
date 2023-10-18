<?php 
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");
    $proceso = $_POST["proceso_domicilio"];
    $id = $_POST["id_domicilio"];
    $expediente = $_POST["id_domicilio_usuario"];
    $calle = $_POST["calle"];
    $exterior = $_POST["next"];
    $interior = $_POST["nint"];
    $colonia = $_POST["col"];
    $cp = $_POST["cpostal"];
    $localidad = $_POST["local"];
    $estado = $_POST["estado"];
    $municipio = $_POST["municipio"];
    $estatus = 1;
    $comprobacion = "0";
    $id_domicilio = '';
    date_default_timezone_set('America/Mexico_City');
    $fecha = date('Y-m-d');
    $usuario = $id_software_sesion;
    $calle = sanear_string($calle);
    $colonia = sanear_string($colonia);
    $localidad = sanear_string($localidad);
    /***----------------Buscamos el nombre del estado---------- */
    if($estado >= 1){
        $consulta_estado = "SELECT nombreEstado FROM estado WHERE idEstado = '$estado' AND estatus = '1' LIMIT 1";
        $resultado_estado = mysqli_query($conexion_database, $consulta_estado);
        while($reg_estado = mysqli_fetch_array($resultado_estado)){
            $nombre_estado = $reg_estado["nombreEstado"];
        }
        mysqli_free_result($resultado_estado);
    }
    /**-------------------------------------------------------- */
    /***----------------Buscamos el nombre del municipio---------- */
    if($municipio >= 1){
        $consulta_municipio = "SELECT nombreMunicipio FROM municipio WHERE idMunicipio = '$municipio' LIMIT 1";
        $resultado_municipio = mysqli_query($conexion_database, $consulta_municipio);
        while($reg_municipio = mysqli_fetch_array($resultado_municipio)){
            $nombre_municipio = $reg_municipio["nombreMunicipio"];
        }
        mysqli_free_result($resultado_municipio);
    }
    /**-------------------------------------------------------- */

    switch($proceso){
        case 'Registro':
            /**Corroboramos que no se duplieque el empleado en el domicilio */
            $consulta_comparar = "SELECT idDomicilio FROM domicilio WHERE empleado_expediente = '$expediente' AND estatus = '1' LIMIT 1";
            $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
            $filas_comparar = mysqli_num_rows($resultado_comparar);
            mysqli_free_result($resultado_comparar);
            /**------------------------------------------------------------------- */

            if($filas_comparar == 0){
                /***------------Insertamos los datos si no se duplican------------- */
                $inserta = "INSERT INTO domicilio(calle, n_Ext, nInt,
                colonia, cp, localidad, municipio_idMunicipio, municipio_nombreMunicipio,
                estado_idEstado, estado_nombreEstado, empleado_expediente, estatus, fecha_movimiento,
                ultimo_movimiento, usuario_movimiento)values('$calle', 
                '$exterior', '$interior', '$colonia', '$cp', '$localidad',
                '$municipio', '$nombre_municipio', '$estado', '$nombre_estado', 
                '$expediente', '$estatus', '$fecha', '$proceso', '$usuario')";
                $proceso = mysqli_query($conexion_database, $inserta);
                /**----------------------------------------------------------------- */
                /**-----------Obtener id de domicilio------------------------------- */
                $consulta_id_domicilio = "SELECT idDomicilio FROM domicilio WHERE empleado_expediente = '$expediente' AND estatus = '1' LIMIT 1";
                $resultado_id_domicilio = mysqli_query($conexion_database, $consulta_id_domicilio);
                while($reg_id_domicilio = mysqli_fetch_array($resultado_id_domicilio)){
                    $id_domicilio = $reg_id_domicilio["idDomicilio"];
                }
                mysqli_free_result($resultado_id_domicilio);
                /**------------------------------------------------------------------ */
                /**------------------se actualiza el id de domicilio en empleados------------------------------------- */
                $actualiza_id_domicilio = "UPDATE empleados SET domicilio_idDomicilio = '$id_domicilio' WHERE expediente = '$expediente' LIMIT 1";
                $resultado_actualiza_id_domicilio = mysqli_query($conexion_database, $actualiza_id_domicilio);
                /**------------------------------------------------------------------ */
            }else{
                $comprobacion = "1";
            }
        break;
        case 'Edicion':
            /**Corroboramos que no se duplique la actualizacion en otro registro */
            $consulta_comparar ="SELECT idDomicilio FROM domicilio WHERE idDomicilio <> '$id' AND empleado_expediente = '$expediente' LIMIT 1";
            $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
            $filas_comparar = mysqli_num_rows($resultado_comparar);
            mysqli_free_result($resultado_comparar);
            /**--------------------------------------------------------------------- */
            /**------------------Actualizamos el registro si no hay datos duplicados*----- */
            if($filas_comparar == 0){
                $actualiza = "UPDATE domicilio SET calle = '$calle', n_Ext = '$exterior', 
                nInt = '$interior', colonia = '$colonia',cp = '$cp', localidad = '$localidad', 
                municipio_idMunicipio = '$municipio', municipio_nombreMunicipio = '$nombre_municipio', 
                estado_idEstado = '$estado', estado_nombreEstado = '$nombre_estado', fecha_movimiento = '$fecha', 
                ultimo_movimiento = '$proceso', usuario_movimiento = '$usuario' WHERE idDomicilio = '$id' AND empleado_expediente = '$expediente' LIMIT 1";
                $resultado_actualiza = mysqli_query($conexion_database, $actualiza);
            }else{
                $comprobacion = "1";
            }
            /***----------------------------------------------------------------------------- */    
        break;
    }
    $array = array(
        0 =>  $comprobacion
    );
    echo json_encode($array);
    mysqli_close($conexion_database);
?>