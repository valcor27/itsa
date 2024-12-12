<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");

    // Consultamos la base de datos para mostrar los valores de las comisiones
    $consulta = "SELECT c.id_comision, c.folio_comision
        FROM comision c
        INNER JOIN parque_comision pc ON c.id_comision = pc.comision_id_comision
        WHERE pc.tipo_vehiculo = '2' AND c.estatus = '1' ORDER BY c.id_comision DESC
    ";
    $registro = mysqli_query($conexion_database, $consulta);
    $tabla = '
        <span class="input-group-text"><i class="fa-solid fa-file-invoice"></i></span>
        <select class="selectpicker form-control" data-live-search="true" multiple name="id_comisiones[]" id="id_comisiones" onchange="return Validar_comisiones_vehiculo();" required="">
    ';

    // Verificamos si hay resultados
    if (mysqli_num_rows($registro) > 0) {
        // Si hay resultados, generamos las opciones del <select>
        while($row = mysqli_fetch_array($registro)){
            $id = $row["id_comision"];
            $folio = $row["folio_comision"];
            $tabla .= '
                <option value="'.$id.'">'.$folio.'</option>
            ';
        }
    } else {
        // Si no hay resultados, mostramos una opción deshabilitada
        $tabla .= '
            <option disabled>No hay comisiones disponibles</option>
        ';
    }

    $tabla .= '
        </select>
    ';

    echo $tabla;

    // Liberamos el resultado y cerramos la conexión
    mysqli_free_result($registro);
    mysqli_close($conexion_database);
?>
