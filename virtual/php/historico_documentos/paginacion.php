<?php
   require("../conexion/conexion_bd.php");
   require("../sesion/logueo.php");
   require("../clases/limpiar.php");

   $paginaActual = $_POST['partida'];
   $anio = isset($_POST['anio']) ? $_POST['anio'] : null;
   
   $consulta_1 = "SELECT id_historico FROM historico_documentos WHERE anio_historico = '$anio'";
   $resultado_1 = mysqli_query($conexion_database, $consulta_1);
   $nrpProductos = mysqli_num_rows($resultado_1);
   mysqli_free_result($resultado_1);
   $tabla = '';
   $lista_info = '';
   $lista = '';
   $nroLotes = 10;
   $nroPaginas = ceil($nrpProductos/$nroLotes);
   $min = $paginaActual - ($paginaActual % 5) + 1;
   if($min > $paginaActual){$min=$min-5;}
   $max = $min + 4 > $nroPaginas ? $nroPaginas : $min + 4;
   /*-----Lista de información de paginas--------------------------------------------------------------------------*/
   $lista_info = $lista_info . ' Pag. ' . $paginaActual . ' / ' . $nroPaginas . ' ';
   /*--------------------------------------------------------------------------------------------------------------*/

   /*-----Paginación para tabletas y pc---------------------------------------------------------------------------*/
   $lista = $lista . '<ul class="pagination">';

   if ($paginaActual > 1) {
      $lista = $lista . '
      <li class="page-item">
         <a class="page-link" href="#Anterior" aria-label="Previous" onclick="Pagination_historico_documentos(' . ($paginaActual - 1) . ');">
            <i class="fas fa-arrow-alt-circle-left"></i>
         </a>
      </li>';
   } else {
      $lista = $lista . '
      <li class="page-item disabled">
         <a class="page-link" href="#Anterior">
            <i class="fas fa-arrow-alt-circle-left"></i>
         </a>
      </li>';
   }

   for ($i = $min; $i <= $max; $i++) {
      if ($i == $paginaActual) {
         $lista = $lista . '
         <li class="page-item active">
            <a class="page-link" href="#Paginar" onclick="Pagination_historico_documentos(' . $i . ');">' . $i . '</a>
         </li>';
      } else {
         $lista = $lista . '
         <li class="page-item">
            <a class="page-link" href="#Paginar" onclick="Pagination_historico_documentos(' . $i . ');">' . $i . '</a>
         </li>';
      }
   }

   if ($paginaActual < $nroPaginas) {
      $lista = $lista . '
      <li class="page-item">
         <a class="page-link" href="#Siguiente" aria-label="Next" onclick="Pagination_historico_documentos(' . ($paginaActual + 1) . ');">
            <i class="fas fa-arrow-alt-circle-right"></i>
         </a>
      </li>';
   } else {
      $lista = $lista . '
      <li class="page-item disabled">
         <a class="page-link" href="#Siguiente">
            <i class="fas fa-arrow-alt-circle-right"></i>
         </a>
      </li>';
   }

   $lista = $lista . '</ul>';
   /*--------------------------------------------------------------------------------------------------------------*/


   /*-----Obtencción limite de datos BD----------------------------------------------------------------------------*/
   if ($paginaActual <= 1) {
      $limit = 0;
   } else {
      $limit = $nroLotes * ($paginaActual - 1);
   }
   /*--------------------------------------------------------------------------------------------------------------*/
   /**------------Función para obtener el nombre de las fuentes de financiamiento mediante los registros de la BD- */
   function traducirValores($ff)
   {
      // Definir el mapeo de números a palabras y estilos de Bootstrap
      $mapa = [
         "151" => ["texto" => "Federal (151)", "clase" => "badge text-bg-success"],
         "161" => ["texto" => "Estatal (161)", "clase" => "badge text-bg-success"],
         "141" => ["texto" => "Captación de Derechos (141)", "clase" => "badge text-bg-success"],
         "145" => ["texto" => "Ingresos Propios (145)", "clase" => "badge text-bg-success"],
         "07"  => ["texto" => "Por Asignar", "clase" => "badge text-bg-warning"]
      ];

      // Separar los valores por coma
      $valoresArray = explode(",", $ff);

      // Traducir cada valor y convertirlo en un badge
      $resultados_ff = array_map(function ($valor) use ($mapa) {
         if (isset($mapa[$valor])) {
            $texto = $mapa[$valor]["texto"];
            $clase = $mapa[$valor]["clase"];
            return "<span class='". $clase."'>".$texto."</span>";
         } else {
            // Si no existe en el mapa, devolver el valor original como badge default
            return "<span class='badge text-bg-secondary'>$valor</span>";
         }
      }, $valoresArray);

      // Unir los valores traducidos con un espacio para el HTML
      return implode(" ", $resultados_ff);
   }

   /**------------------------------------------------------------------------------------------------------------ */
   $consulta_2 = "SELECT id_documento, anio_historico, folio, tipo_doc, ff, asunto, nombre_documento FROM historico_documentos WHERE anio_historico = '$anio'";
   $registro_2 = mysqli_query($conexion_database, $consulta_2);
   $no_filas = mysqli_num_rows($registro_2);
   $tabla = '<div class="table-responsive">
            <table class="table table-hover table-bordered">';
   $tipo_documento="";
   if($no_filas > 0){
      $tabla .= '<thead>
                  <tr> 
                        <th><i class="fa-solid fa-gear"></i></th>
                        <th>Ejercicio Fiscal</th>
                        <th>Folio</th>
                        <th>Asunto</th>
                        <th>Tipo de Doc.</th>
                        <th>Fuente Fin.</th>
                  </tr>
               </thead>
               <tbody>
      ';
      while($row = mysqli_fetch_array($registro_2)){
         $id = $row["id_documento"];
         $e_fiscal = $row["anio_historico"];
         $folio = $row["folio"];
         $tipo = $row["tipo_doc"];
         $ff = $row["ff"];
         $asunto = $row["asunto"];
         $nombre_doc = $row["nombre_documento"];
         if($tipo == 1){
            $tipo_documento = "Oficio Circular"; 
         }else if($tipo == 2){
            $tipo_documento = "Oficio"; 
         }else if($tipo == 3){
            $tipo_documento = "Memorándum"; 
         }
         //151 federal, 161 estatal, 141 captacion de derechos , 145 ingresos propios y 07 es por asignar
         $valor_ff = $ff ? traducirValores($ff) : '<span class="badge text-bg-danger">No tiene Fuentes de Financiamiento Asignadas!</span>';
         
         if($nombre_doc == ""){
            $valor_archivo = '
               <button type="button" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Descargar Documento" disabled>
                  <i class="fa-solid fa-file-arrow-down"></i>
               </button>
            ';
         }else{
            $valor_archivo = '
                  <button type="button" class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Descargar Documento" onclick="return Descargar_documento_h(' . $id . ', ' . $e_fiscal .');">
                     <i class="fa-solid fa-file-arrow-down"></i>
                  </button>
            ';
         }
         $button_historial = '
            <button type="button" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Ver Historial del Documento" onclick="return Historial_documento_h(' . $id . ', ' . $e_fiscal . ');">
               <i class="fa-solid fa-box-archive"></i>
            </button>
         ';
         $button_timeline = '
            <button type="button" class="btn btn-success" onclick="return Historial_documento_timeline('.$id.', '.$anio.');">
               <i class="fa-solid fa-box-archive"></i>
            </button>
         ';

         $tabla .= '
            <tr>
               <td align="center">'.$button_historial.' '.$valor_archivo.'</td>
               <td>' . $e_fiscal . '</td>
               <td>' . $folio . '</td>
               <td>' . $asunto . '</td>
               <td>' . $tipo_documento . '</td>
               <td>' . $valor_ff . '</td>
            </tr>
         ';
      }
   }else{
      $tabla .= '
         <div class="alert alert-info">
            <strong>Mensaje!</strong> No se encontró ningún registro.
         </div>
      ';
   }
   $tabla .= '</table>
      </div>
   ';
   
   $array = array(
      0 => $tabla,
      1 => $lista_info,
      2 => $lista
   );

   echo json_encode($array);

   mysqli_free_result($registro_2);
   mysqli_close($conexion_database);  
?>
