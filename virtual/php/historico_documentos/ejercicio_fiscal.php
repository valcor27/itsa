<?php
require("../conexion/conexion_bd.php");
require("../sesion/logueo.php");
/**Consultamos la BD para obtener los registros pero solo los años sin repetirse--- */
$consulta = "SELECT anio_historico AS anio FROM historico_documentos GROUP BY anio ORDER BY anio DESC";
$resultado = mysqli_query($conexion_database, $consulta);
/**-------------------------------------------------------------------------------- */
$tabla = '';
while ($row = mysqli_fetch_array($resultado)) {
   $anio = $row["anio"];
   $tabla = $tabla . '
         <option value="' . $anio . '">' . $anio . '</option>
      ';
}
echo $tabla;
mysqli_free_result($resultado);
mysqli_close($conexion_database);
