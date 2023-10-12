
<?php
require("../conexion/conexion_bd.php");
require("../sesion/logueo.php");
require("../clases/limpiar.php");
$id = $_POST["id"];
$tabla = '';

$consulta = "SELECT id_horario AS id, docentes_id_docentes, punto_matriz FROM horario WHERE docentes_id_docentes = '$id' AND estatus = '1'";
$registro = mysqli_query($conexion_database, $consulta);

$tabla = '
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>Horas\Días</th>
                    <th>Lunes</th>
                    <th>Martes</th>
                    <th>Miércoles</th>
                    <th>Jueves</th>
                    <th>Viernes</th>
                    <th>Sábado</th>
                </tr>
            </thead>
            <tbody>
';

$horas = array("7:00-8:00", "8:00-9:00", "9:00-10:00", "10:00-11:00", "11:00-12:00", "12:00-13:00", "13:00-14:00", "14:00-15:00", "15:00-16:00", "16:00-17:00", "17:00-18:00", "18:00-19:00", "19:00-20:00", "20:00-21:00");

foreach ($horas as $hora) {
    $tabla .= '<tr>';
    $tabla .= '<td>' . $hora . '</td>';
    for ($i = 1; $i <= 6; $i++) {
        $valor = 'f' . $i . 'c' . $i;
        $existe_registro = false;
        
        // Verificar si existe un registro en la base de datos con el valor actual
        while ($fila = mysqli_fetch_assoc($registro)) {
            if ($fila['punto_matriz'] == $valor) {
                $existe_registro = true;
                // Definir la clase del botón y el valor a enviar por Ajax
                $clase_botones = 'btn-success';
                $valor_ajax = json_encode(['id_horario' => $fila['id'], 'docentes_id_docentes' => $fila['docentes_id_docentes'], 'matriz' => $valor]);
                break; // Si se encuentra un registro, sal del bucle
            }
        }
        mysqli_data_seek($registro, 0); // Reiniciar el puntero del resultado de la consulta
        
        if (!$existe_registro) {
            // Si no existe un registro, define la clase y valor por defecto
            $clase_botones = 'btn-outline-success';
            $valor_ajax = json_encode(['matriz' => $valor]);
        }
        
        // Agregar botón con la clase correspondiente y función Ajax
        $tabla .= '
            <td align="center">
                <button type="button" class="btn ' . $clase_botones . '" onclick="Modal_carga_materia(' . $valor_ajax . ');">
                    <i class="fa-regular fa-file-lines"></i>
                </button>
            </td>
        ';
    }
    $tabla .= '</tr>';
}

$tabla .= '
            </tbody>
        </table>
    </div>
';

$array = array(
    0 => $tabla
);
echo json_encode($array);




/*
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");
    $id = $_POST["id"];
    $tabla = '';
    /**-Consulta la BD para mostrar los registros  */
   /* $consulta = "SELECT id_horario AS id, docentes_id_docentes, punto_matriz FROM horario WHERE docentes_id_docentes = '$id' AND estatus = '1'";
    $registro = mysqli_query($conexion_database, $consulta);

    /**------------------------------------------- */
   /* $tabla = '
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Horas\Días</th>
                        <th>Lunes</th>
                        <th>Martes</th>
                        <th>Miércoles</th>
                        <th>Jueves</th>
                        <th>Viernes</th>
                        <th>Sábado</th>
                    </tr>
                </thead>
                <tbody>
    ';

    $horas = array("7:00-8:00", "8:00-9:00", "9:00-10:00", "10:00-11:00", "11:00-12:00", "12:00-13:00", "13:00-14:00", "14:00-15:00", "15:00-16:00", "16:00-17:00", "17:00-18:00", "18:00-19:00", "19:00-20:00", "20:00-21:00");

    foreach ($horas as $hora) {
        $tabla .= '<tr>';
        $tabla .= '<td>' . $hora . '</td>';
        for ($i = 1; $i <= 6; $i++) {
            $valor = 'f' . $i . 'c' . $i;
            $tabla .= '
                <td align="center">
                    <button type="button" class="btn btn-outline-success" onclick="Modal_carga_materia(\'' . $valor . '\');">
                        <i class="fa-regular fa-file-lines"></i>
                    </button>
                </td>
            ';
        }
        $tabla .= '</tr>';
    }

    $tabla .= '
                </tbody>
            </table>
        </div>
    ';

    $array = array(
        0 => $tabla
    );
    echo json_encode($array);*/
?>
