<?php
require("../conexion/conexion_bd.php");
require("../sesion/logueo.php");

// Obtener el ID del documento desde la solicitud POST
$id = $_POST['id'];
$anio = $_POST['anio'];

// Buscar el archivo en la base de datos
$sql = "SELECT nombre_documento FROM historico_documentos WHERE id_documento = '$id'  AND anio_historico = '$anio'";
$resultado = mysqli_query($conexion_database, $sql);

if (mysqli_num_rows($resultado) == 1) {
   $fila = mysqli_fetch_assoc($resultado);
   $archivo = $fila['nombre_documento'];
   $ruta_archivo = "../../documentos/" . $archivo;
   // Verificar que el archivo exista en el servidor
   if (file_exists($ruta_archivo)) {
      echo $archivo; // Devolver el nombre del archivo
   } else {
      echo "El archivo no existe en el servidor.";
      
   }
} else {
   echo "El archivo no se encontró en la base de datos.";
}

mysqli_free_result($resultado);
mysqli_close($conexion_database);
