<?php
    //ruta del archivo en el servidor
    $archivo = '../../archivos_plantilla/plantilla_pagos.xlsx';

    //verifica si el archivo existe
    if (file_exists($archivo)){
        //Establecemos las cabeceras para la descarga
        header('Content-Description: File Transfer');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. basename($archivo). '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: '. filesize($archivo));

        //limpia el bufer de salida
        ob_clean();
        flush();

        //lee el archivo y envíalo al navegador
        readfile($archivo);
        exit;
    }else{
        echo json_encode(["error" => "Archivo no encontrado."]);
    }
?>