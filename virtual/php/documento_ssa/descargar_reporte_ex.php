<?php 
// Incluir los archivos necesarios para la conexión a la base de datos, manejo de sesiones, limpieza de datos y carga automática de clases
require("../conexion/conexion_bd.php");
require("../sesion/logueo.php");
require("../clases/limpiar.php");
require("../../vendor/autoload.php");

// Usar las clases necesarias de PhpSpreadsheet para crear y manejar la hoja de cálculo
use PhpOffice\PhpSpreadsheet\{Spreadsheet, IOFactory};
use PhpOffice\PhpSpreadsheet\Style\{Alignment, Border, Font};

// Consulta SQL para obtener los datos de los documentos y sus movimientos más recientes
$consulta = "SELECT 
        doc.folio,
        doc.asunto,
        doc.estatus,
        doc.partida_cd,
        doc.partida_fed,
        doc.partida_est,
        doc.partida_ip, 
        doc.partida_pa,
        org.nombreUnidad AS departamento_actual,
        hist.fecha, 
        observacion
    FROM 
        documentos AS doc
    INNER JOIN (
        SELECT 
            documento_id_documento,
            MAX(id_historial) AS ultimo_id_movimiento
        FROM 
            historial_movimientos
        GROUP BY 
            documento_id_documento
    ) AS ult_mov ON doc.id_documento = ult_mov.documento_id_documento
    INNER JOIN historial_movimientos AS hist ON ult_mov.documento_id_documento = hist.documento_id_documento AND ult_mov.ultimo_id_movimiento = hist.id_historial
    INNER JOIN estructuraorganica AS org ON hist.departamento_actual = org.claveUnidad
    WHERE 
        doc.estatus = '1'
    ORDER BY 
        doc.id_documento DESC";

// Ejecutar la consulta SQL
$registro = mysqli_query($conexion_database, $consulta);

// Crear un nuevo objeto de hoja de cálculo
$excel = new Spreadsheet();
$hojaActiva = $excel->getActiveSheet();
$hojaActiva->setTitle("Reporte de Documentos");

// Agregar título "Reporte de Documentos" en la celda A1 y fusionar celdas
$hojaActiva->setCellValue('A1', 'Reporte de Documentos');
$hojaActiva->mergeCells('A1:G1');

// Agregar títulos de columnas en la fila 2
$hojaActiva->setCellValue('A2', 'Folio');
$hojaActiva->setCellValue('B2', 'Partida');
$hojaActiva->setCellValue('C2', 'Asunto');
$hojaActiva->setCellValue('D2', 'Estatus');
$hojaActiva->setCellValue('E2', 'Fecha de ingreso al departamento');
$hojaActiva->setCellValue('F2', 'Departamento Actual');
$hojaActiva->setCellValue('G2', 'Comentarios');

// Iniciar el contador de filas para la inserción de datos
$fila = 3;
while($row = mysqli_fetch_array($registro)){
    // Obtener los valores de cada columna del resultado de la consulta
    $folio = $row["folio"];
    $asunto = $row["asunto"];
    $dep_act = $row["departamento_actual"];
    $estatus = $row["estatus"];
    $fecha =  date("d-m-Y", strtotime($row['fecha']));
    $observacion = $row["observacion"];
    $partida_cd = $row["partida_cd"];
    $partida_fed = $row["partida_fed"];
    $partida_est = $row["partida_est"];
    $partida_ip = $row["partida_ip"];
    $partida_pa = $row["partida_pa"];

    // Crear una lista de partidas y unirlas con comas
    $partidas = [];
    if($partida_cd != null) {
        $partidas[] = $partida_cd;
    }
    if($partida_fed != null) {
        $partidas[] = $partida_fed;
    }
    if($partida_est != null) {
        $partidas[] = $partida_est;
    }
    if($partida_ip != null) {
        $partidas[] = $partida_ip;
    }
    if($partida_pa != null) {
        $partidas[] = $partida_pa;
    }

    $valor_partidas = implode(', ', $partidas);

    // Convertir el estatus a una cadena legible
    switch ($estatus) {
        case 0:
            $valor_estatus = 'Cancelado';
            break;
        case 1:
            $valor_estatus = 'En Proceso';
            break;
        case 2:
            $valor_estatus = 'Aceptado';
            break;
        default:
            $valor_estatus = 'Desconocido';
    }

    // Asignar los valores a las celdas correspondientes
    $hojaActiva->setCellValue('A'.$fila, $folio);
    $hojaActiva->setCellValue('B'.$fila, $valor_partidas);
    $hojaActiva->setCellValue('C'.$fila, $asunto);
    $hojaActiva->setCellValue('D'.$fila, $valor_estatus);
    $hojaActiva->setCellValue('E'.$fila, $fecha);
    $hojaActiva->setCellValue('F'.$fila, $dep_act);
    $hojaActiva->setCellValue('G'.$fila, $observacion);
    $fila++;
}

// Aplicar estilos a todas las celdas
$hojaActiva->getStyle('A1:G' . $fila)->applyFromArray([
    'font' => [
        'name' => 'Arial',
        'size' => 12,
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
        ],
    ],
]);

// Aplicar estilos a los títulos
$hojaActiva->getStyle('A1:G2')->applyFromArray([
    'font' => [
        'bold' => true,
        'size' => 14,
    ],
]);

// Ajustar ancho de las columnas automáticamente
foreach(range('A','G') as $columnID) {
    $hojaActiva->getColumnDimension($columnID)->setAutoSize(true);
}

// Activar ajuste de texto
$hojaActiva->getStyle('A1:G' . $fila)->getAlignment()->setWrapText(true);

// Redireccionar la salida al navegador del cliente para descargar el archivo
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Reporte de Documentos.xlsx"');
header('Cache-Control: max-age=0');

// Crear el escritor y guardar la hoja de cálculo en la salida del navegador
$writer = IOFactory::createWriter($excel, 'Xlsx');
$writer->save('php://output');
exit();
?>
