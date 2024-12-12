<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");
    date_default_timezone_set('America/Mexico_City');
    $anio = date('Y');
    $fecha = date('d-m-Y');
    //$anio = date('2024');
    $hora = date('H:i:s');
    $folio = '';
    /**Consultamos la BD para obtener el ultimo ID */
    $consulta = "SELECT MAX(folio_incidencia) AS ultimo_folio FROM incidencia";
    $registro = mysqli_query($conexion_database, $consulta);
    while($row = mysqli_fetch_array($registro)){
        $folio_mas_alto = $row["ultimo_folio"];
    }
    
    if ($folio_mas_alto !== null) {
        $anio_folio = substr($folio_mas_alto, 0, 4);//sacamos el año del folio de incidencia
        if($anio != $anio_folio){
            $folio = $anio . "0001"; //comienza un nuevo año
        }else{
            $numero_folio = (int)substr($folio_mas_alto, 4);//extrae el numero de folio y lo convierte en entero
            $numero_folio++;//incrementa el numero de folio
            
            $folio = $anio_folio . sprintf("%04d", $numero_folio); //formatea el numero de folio con ceros a la izquierda
        }
    } else {
        // Si $folio_mas_alto es nulo, asigna un valor predeterminado
        $folio = $anio . "0001";
    }
    

    /**------------------------------------------- */
    //$folio = $anio . sprintf("%04d", $folio_mas_alto);

    $array = array(
        0 => $hora,
        1 => $folio,
        2 => $fecha
    );
    //echo $hora.' '.$folio;
    echo json_encode($array);

    mysqli_free_result($registro);
    mysqli_close($conexion_database);
?>