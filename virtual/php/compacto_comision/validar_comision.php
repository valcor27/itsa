<?php
require("../conexion/conexion_bd.php");
require("../sesion/logueo.php"); 

$comprobacion = "0"; // Variable para verificar la coincidencia de vehículos
$nombre = null;
$km_inicial = null;
$id_vehiculo = "0";

// Verificar si se recibió algún dato de comisiones desde Ajax
if(isset($_POST['comisiones'])) {
    $comisiones_array = $_POST['comisiones'];

    // Verificar si no se seleccionó ninguna comisión
    if(empty($comisiones_array)) {
        $comprobacion = "0";
    } else {
        // Verificar si solo hay un elemento en el array
        if (count($comisiones_array) == 1) {
            // En este caso, no es necesario convertir a cadena, ya que solo hay un elemento
            $comisiones_str = $comisiones_array[0];
        } else {
            // Si hay más de un elemento, convertir el array en una cadena separada por comas
            $comisiones_str = implode(',', $comisiones_array);
        }

        /**Consulta SQL para obtener la marca y submarca del vehículo asociado a las comisiones seleccionadas**/
        $consulta = "SELECT v.marca, v.submarca, pc.km_inicial, pc.vehiculo_id_vehiculo
            FROM parque_comision pc
            INNER JOIN vehiculo v ON pc.vehiculo_id_vehiculo = v.idvehiculo
            WHERE pc.comision_id_comision IN ($comisiones_str)
            GROUP BY v.marca, v.submarca, pc.km_inicial, pc.vehiculo_id_vehiculo
        ";

        $resultado = mysqli_query($conexion_database, $consulta);

        // Verificar si hay resultados y comprobar la coincidencia de vehículos
        if ($resultado && mysqli_num_rows($resultado) > 1) {
            // Si hay más de un vehículo, establecer $comprobacion en 1
            $comprobacion = "1";
            $nombre = null;
            $km_inicial = null;
            $id_vehiculo = "0";
        } else {
            // Si solo hay un vehículo o ningún vehículo, continuar con el procesamiento normal
            while ($row = mysqli_fetch_assoc($resultado)) {
                $id_vehiculo = $row['vehiculo_id_vehiculo'];
                $marca = $row['marca'];
                $submarca = $row['submarca'];
                $km_inicial = $row["km_inicial"];
                $nombre = $marca.', '.$submarca;
            }
            // Liberar el resultado solo si se obtuvieron resultados
            mysqli_free_result($resultado);
        }
    }
}

$array = array(
    0 => $comprobacion,
    1 => $nombre,
    2 => $km_inicial,
    3 => $id_vehiculo
);

// Convertir $comprobacion a formato JSON y enviarlo de vuelta a Ajax
echo json_encode($array);

mysqli_close($conexion_database);
?>
