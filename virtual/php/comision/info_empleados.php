<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("../conexion/conexion_bd.php");
require("../sesion/logueo.php");
require("../clases/limpiar.php");

$datos = array();
$empleados = $_POST["empleado"];
date_default_timezone_set('America/Mexico_City');
$lugar = "Atlixco, Puebla";

// Ajustar $n_comi para que sea igual al número de empleados seleccionados
$n_comi = count($empleados);

// Añadir el primer elemento con $lugar y $n_comi
$datos[] = array(
    'lugar' => $lugar,
    'n_comi' => $n_comi
);

if (is_array($empleados)) {
    // Iterar sobre cada empleado seleccionado
    foreach ($empleados as $empleado) {
        $consulta_plaza = "SELECT plaza_codigoPlaza, plaza_nombrePlaza FROM empleados WHERE expediente = '$empleado' LIMIT 1";
        $resultado_plaza = mysqli_query($conexion_database, $consulta_plaza);

        if ($resultado_plaza) {
            while ($row = mysqli_fetch_array($resultado_plaza)) {
                $id_cargo = $row['plaza_codigoPlaza'];
                $cargo = $row['plaza_nombrePlaza'];
            }

            // Agregar los datos específicos del empleado
            $datos[] = array(
                'cargo' => $cargo,
                'id_cargo' => $id_cargo
            );

            mysqli_free_result($resultado_plaza);
        } else {
            // Si hay un error en la consulta, agrega un mensaje de error
            $datos[] = array('error' => 'Error en la consulta: ' . mysqli_error($conexion_database));
        }
    }
} else {
    $datos[] = array('error' => 'No se recibió un array de empleados.');
}

echo json_encode($datos);
mysqli_close($conexion_database);
?>
