<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");
    $datos = array();
    $partida = $_POST["partida"];
    date_default_timezone_set('America/Mexico_City');
    $fecha = date('d-m-Y');
    $anio = date('Y');
    /**Conultamos la BD para obtener el ultimo numero de folio */
        $consulta = "SELECT MAX(folio_comision) AS ultimo_folio FROM comision";
        $resultado = mysqli_query($conexion_database, $consulta);
        while($row = mysqli_fetch_array($resultado)){
            $folio_mas_alto = $row["ultimo_folio"];
        }

        if($folio_mas_alto !== null){
            $anio_folio = substr($folio_mas_alto, 0, 4);//sacamos el año del folio de comision
            if($anio != $anio_folio){
                $folio = $anio . "0001";//comienza un año nuevo
            }else{
                $numero_folio = (int)substr($folio_mas_alto, 4);//extrae el numero de folio y lo convierte en entero
                $numero_folio++;//incrementa el numero de folio

                $folio = $anio_folio . sprintf("%04d", $numero_folio);//formatea el numero de folio con ceros a la izquierda
            }
        }else{
            //si $folio_mas_alto es nulo, se le asigna un valor prodeterminado
            $folio = $anio . "0001";
        }
    /**------------------------------------------------------- */
    $datos = array(
        0 => $fecha,
        1 => $folio
    );
    echo json_encode($datos);
    mysqli_free_result($resultado);
    mysqli_close($conexion_database);
?>