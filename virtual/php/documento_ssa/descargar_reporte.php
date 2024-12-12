<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");
    require("../fpdf/fpdf.php");

    class PDF extends FPDF
    {
        private $widths; // Agregar esta línea

        // Cabecera de página
        function Header()
        {
            $this->SetFont('Arial','B',14);
            $this->Cell(60);
            $this->Cell(70,10,'Reporte de Documentos',0,0,'C');
            $this->Ln(20);
        }

        // Pie de página
        function Footer()
        {
            $this->SetY(-15);
            $this->SetFont('Arial','I',8);
            $this->Cell(0,10,iconv('UTF-8', 'windows-1252', 'Página ').$this->PageNo().'/{nb}',0,0,'C');
        }

        // Método para obtener el margen izquierdo
        public function getLeftMargin()
        {
            return $this->lMargin;
        }

        // Método para obtener el margen derecho
        public function getRightMargin()
        {
            return $this->rMargin;
        }

        // Método para configurar los anchos de las columnas de la tabla
        public function SetWidths($widths)
        {
            $this->widths = $widths;
        }

        // Método para generar una fila de la tabla
        public function Row($data)
        {
            $nb = 0;
            for($i=0; $i<count($data); $i++)
                $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));
            $h = 10*$nb;
            $this->CheckPageBreak($h);
            for($i=0; $i<count($data); $i++)
            {
                $w = $this->widths[$i];
                $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
                $x = $this->GetX();
                $y = $this->GetY();
                $this->Rect($x,$y,$w,$h);
                $this->MultiCell($w,10,$data[$i],0,$a);
                $this->SetXY($x+$w,$y);
            }
            $this->Ln($h);
        }

        // Método para calcular el número de líneas ocupadas por un texto
        private function NbLines($w,$txt)
        {
            $cw = &$this->CurrentFont['cw'];
            if($w==0)
                $w = $this->w-$this->rMargin-$this->x;
            $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
            $s = str_replace("\r",'',$txt);
            $nb = strlen($s);
            if($nb>0 && $s[$nb-1]=="\n")
                $nb--;
            $sep = -1;
            $i = 0;
            $j = 0;
            $l = 0;
            $nl = 1;
            while($i<$nb)
            {
                $c = $s[$i];
                if($c=="\n")
                {
                    $i++;
                    $sep = -1;
                    $j = $i;
                    $l = 0;
                    $nl++;
                    continue;
                }
                if($c==' ')
                    $sep = $i;
                $l += $cw[$c];
                if($l>$wmax)
                {
                    if($sep==-1)
                    {
                        if($i==$j)
                            $i++;
                    }
                    else
                        $i = $sep+1;
                    $sep = -1;
                    $j = $i;
                    $l = 0;
                    $nl++;
                }
                else
                    $i++;
            }
            return $nl;
        }

        // Método para verificar si es necesario un salto de página
        private function CheckPageBreak($h)
        {
            if($this->GetY()+$h>$this->PageBreakTrigger)
                $this->AddPage($this->CurOrientation);
        }
    }

    // Creación del objeto de la clase heredada
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','',10);
    $pdf->Image('../../img/logo.png', 10, 10, 30);
    // Consulta SQL
    $consulta="SELECT 
            doc.folio,
            doc.asunto,
            doc.estatus,
            org.nombreUnidad AS departamento_actual,
            hist.fecha
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
            doc.id_documento DESC
    ";


    $registro = mysqli_query($conexion_database, $consulta);

    // Calcular el ancho disponible dentro de los márgenes
    $ancho_disponible = $pdf->GetPageWidth() - ($pdf->getLeftMargin() + $pdf->getRightMargin());

    // Calcular el ancho de cada columna de la tabla
    $column_width = $ancho_disponible / 5; // Suponiendo que hay 5 columnas en la tabla

    // Configurar el ancho de las columnas
    $pdf->SetWidths(array($column_width, $column_width, $column_width, $column_width, $column_width));
    // Encabezado de la tabla
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell($column_width, 10, 'Folio', 1, 0, 'C');
    $pdf->Cell($column_width, 10, 'Asunto', 1, 0, 'C');
    $pdf->Cell($column_width, 10, 'Estatus', 1, 0, 'C');
    $pdf->SetFont('Arial', '', 7); // Cambiar el tamaño de la fuente según sea necesario
    $pdf->Cell($column_width, 10, 'Fecha de ingreso al departamento', 1, 0, 'C');
    $pdf->SetFont('Arial', '', 10); // Restaurar el tamaño de la fuente original
    
    $pdf->Cell($column_width, 10, 'Departamento Actual', 1, 1, 'C');
    while($row = mysqli_fetch_array($registro)){
        $folio = $row["folio"];
        $folio = iconv('UTF-8', 'windows-1252', $folio);
        $asunto = $row["asunto"];
        $asunto = iconv('UTF-8', 'windows-1252', $asunto);
        $dep_act = $row["departamento_actual"];
        $dep_act = iconv('UTF-8', 'windows-1252', $dep_act);
        $estatus = $row["estatus"];
        $fecha =  date("d-m-Y", strtotime($row['fecha']));
        $valor_estatus = '';

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

        // Agregar fila a la tabla
        $pdf->Row(array($folio, $asunto, $valor_estatus, $fecha, $dep_act));
    }

    $pdf->Output();
?>
