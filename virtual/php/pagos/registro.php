<?php
    require("../../vendor/autoload.php");
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");

    use PhpOffice\PhpSpreadsheet\IOFactory;
    
    $proceso = $_POST["proceso_pagos"];
    $id = $_POST["id_pagos"];
    $archivo = $_FILES["archivo_pagos"];
    $comprobacion = "0";
    $usuario = $id_software_sesion;
    date_default_timezone_set('America/Mexico_City');
    $fecha_movimiento = date('Y-m-d');
    $estatus = 1;

    //comenzamos con las validaciones para que no haya ningun inconveniente
    if($archivo['error'] !== UPLOAD_ERR_OK){
        $comprobacion = "2";
    }else{
        if ($archivo['type'] == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet") {
            // El archivo es un .xlsx válido
            // Procesar el archivo Excel
            $spreadsheet = IOFactory::load($archivo['tmp_name']);
            //obtenemos solo la primer hoja
            $sheet = $spreadsheet->getSheet(0); //0 para la primera hoja

            //obtenemos el número de la última fila con datos
            $highestRow = $sheet->getHighestRow();

            //Recorrer las filas de la hoja
            for($rowIndex = 2; $rowIndex <= $highestRow; $rowIndex++){//comenzamos a recorrer desde la fila 2
                $rowData = $sheet->getRowIterator($rowIndex)->current();
                $cells = $rowData->getCellIterator();
                $cells->setIterateOnlyExistingCells(false);//para iterar incluso celdas vacias

                $data = [];
                $hasData = false; //variable para verificar si hay datos en la fila
                foreach($cells as $cell){
                    $value = $cell->getValue();
                    $data[] = $value;//Obtiene el valor de cada celda
                    if(!empty($value)){
                        $hasData = true; //Hay al menos una celda con datos
                    }
                }
                //Solo procesar si hay datos en la fila
                if($hasData){
                    //Asignar valores a variables
                    $poliza = $data[0];//Columna A
                    $partida = $data[1]; //Columna B
                    $fecha_excel = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($data[2])->format('Y-m-d');//Columna B
                    $folio_fiscal = $data[3];//Columna C
                    $concepto = $data[4]; //Columna D
                    $monto_total = $data[5];//Columna E
                    /**Obtenemos el primer digito de la partida para obtener el capitulo */
                    $capitulo = substr($partida, 0, 1).'000';
                    $check = "0";
                    //Insertamos en la base de datos
                    $inserta = "INSERT INTO pagos(poliza, partida, capitulo, fecha_pago, folio_fiscal, concepto, monto_total, estatus, fecha_movimiento, ultimo_movimiento, usuario_movimiento, estado_checkbox)VALUES('$poliza', '$partida', '$capitulo', '$fecha_excel', '$folio_fiscal', '$concepto', '$monto_total', '$estatus', '$fecha_movimiento', '$proceso', '$usuario', '$check')";
                    $proceso_bd = mysqli_query($conexion_database, $inserta);
                }
            }
            $comprobacion = "0";
        } else {
            // El archivo no es un .xlsx válido
            $comprobacion = "1";
        }
    }
    $array = array(
        0 => $comprobacion
    );
    echo json_encode($array);
    mysqli_close($conexion_database);
?>