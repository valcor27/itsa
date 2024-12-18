<?php
require("../conexion/conexion_bd.php");
require("../sesion/logueo.php");
require("../clases/limpiar.php");
$id_doc = $_POST["id"];
$anio_doc = $_POST["anio"];
$datos_hisotorial_doc = '';
function traducirValores($ff){
      // Definir el mapeo de números a palabras
      $mapa = [
         "151" => "Federal",
         "161" => "Estatal",
         "141" => "Captación de Derechos",
         "145" => "Ingresos Propios",
         "07"  => "Por Asignar"
      ];
      // Separar los valores por coma
      $valoresArray = explode(",", $ff);

      // Traducir cada valor
      $resultados_ff = array_map(function ($valor) use ($mapa) {
         return $mapa[$valor] ?? $valor; // Si no existe en el mapa, devolver el valor original
      }, $valoresArray);

      // Unir los valores traducidos en una cadena
      return implode(", ", $resultados_ff);
   }
/**Consultamos la BD del pago para mostrar la info----------- */
$consulta_d = "SELECT folio, tipo_doc, ff, partida_cd, partida_fed, partida_est, partida_ip, partida_pa, asunto FROM historico_documentos WHERE id_documento = '$id_doc' AND anio_historico = '$anio_doc' LIMIT 1";
$resultado_d = mysqli_query($conexion_database, $consulta_d);

while ($row = mysqli_fetch_array($resultado_d)) {
   $folio = $row["folio"];
   $tipo = $row["tipo_doc"];
   $ff = $row["ff"];
   $partida_cd = $row["partida_cd"];
   $partida_fed = $row["partida_fed"];
   $partida_est = $row["partida_est"];
   $partida_ip = $row["partida_ip"];
   $partida_pa = $row["partida_pa"];
   $asunto = $row["asunto"];
   $valor_ff = traducirValores($ff);
   $partidas = [$partida_cd, $partida_fed, $partida_est, $partida_ip, $partida_pa];
   // Filtrar las variables que no están vacías
   $partidas_filtradas = array_filter($partidas, function($valor) {
        return !empty($valor); // Eliminar valores vacíos o nulos
   });

    // Concatenar las variables con coma
   $partidas_final = implode(", ", $partidas_filtradas);
   if ($tipo == 1) {
      $tipo_documento = "Oficio Circular";
   } else if ($tipo == 2) {
      $tipo_documento = "Oficio";
   } else if ($tipo == 3) {
      $tipo_documento = "Memorándum";
   }
}
mysqli_free_result($resultado_d);
/**Mostrar datos del pago en pantalla------------------------ */
$datos_hisotorial_doc = $datos_hisotorial_doc . '
   <div class="col d-flex align-items-center">
      <p class="datos_historial_doc">Folio: <span id=""> ' . $folio . ' </span></p>
   </div>
   <div class="col d-flex align-items-center">
      <p class="datos_historial_doc">Tipo de Documento: <span id=""> ' . $tipo_documento . ' </span></p>
   </div>
   <div class="col d-flex align-items-center">
      <p class="datos_historial_doc">Fuente de Financiamiento: <span id="">' . $valor_ff . ' </span></p>
   </div>
   <div class="col d-flex align-items-center">
      <p class="datos_historial_doc">Partida(s): <span id="">' . $partidas_final . ' </span></p>
   </div>
   <div class="col d-flex align-items-center">
      <p class="datos_historial_doc">Asunto: <span id="">' . $asunto . ' </span></p>
   </div>
';
/**---------------------------------------------------------- */
$array = array(
   0 => $datos_hisotorial_doc,
   1 => $id_doc,
   2 => $anio_doc
);
echo json_encode($array);
mysqli_close($conexion_database);
