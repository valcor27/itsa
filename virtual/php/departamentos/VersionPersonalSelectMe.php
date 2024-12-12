<?php
    error_reporting(E_ALL); 
    ini_set('display_errors', 1);
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php"); 

    // Consultamos la base de datos para mostrar los valores de los departamentos
    $consulta = "SELECT claveUnidad, nombreUnidad FROM estructuraorganica WHERE estatus = '1' ORDER BY claveUnidad ASC";
    $resultado = mysqli_query($conexion_database, $consulta);

    // Creamos el formulario y el select
    $tabla = '
        <form id="buscar_detalle_pago" name="buscar_detalle_pago" onsubmit="return Pagination_detalles_pago(1);">
            <div class="input-group mb-3 ps-3">
                <select class="form-select" name="select_busqueda_detalle_pago" id="select_busqueda_detalle_pago" required>
                    <option selected disabled>Selecciona Buscar por Departamento</option>
    ';

    // Variables para manejar la agrupación
    $current_group = ""; // Para identificar el grupo actual

    // Recorremos los resultados
    while($row = mysqli_fetch_array($resultado)) {
        $id = $row["claveUnidad"];
        $nombre = $row["nombreUnidad"];

        // Detectamos si el id del departamento pertenece a un nuevo grupo
        if (substr($id, 0, 3) === '100' && $current_group !== 'Dirección General') {
            // Cerrar el optgroup anterior (si lo hay)
            if ($current_group !== "") {
                $tabla .= '</optgroup>';
            }
            // Iniciar un nuevo optgroup para "Dirección General"
            $tabla .= '
                <optgroup label="Dirección General">
                    <div class="outgroup_divider_me"></div>
                    <div class="outgroup_title_me">Dirección General</div>
            ';
            $current_group = 'Dirección General';
        } elseif (substr($id, 0, 2) === '11' && $current_group !== 'Dirección Académica') {
            if ($current_group !== "") {
                $tabla .= '</optgroup>';
            }
            $tabla .= '
                <optgroup label="Dirección Académica">
                    <div class="outgroup_divider_me"></div>
                    <div class="outgroup_title_me">Dirección Académica</div>
            ';
            $current_group = 'Dirección Académica';
        } elseif (substr($id, 0, 2) === '12' && $current_group !== 'Dirección de Planeación y Vinculación') {
            if ($current_group !== "") {
                $tabla .= '</optgroup>';
            }
            $tabla .= '
                <optgroup label="Dirección de Planeación y Vinculación">
                    <div class="outgroup_divider_me"></div>
                    <div class="outgroup_title_me">Dirección de Planeación y Vinculación</div>
            ';
            $current_group = 'Dirección de Planeación y Vinculación';
        } elseif (substr($id, 0, 3) === '101' && $current_group !== 'Subdirección de Servicios Administrativos') {
            if ($current_group !== "") {
                $tabla .= '</optgroup>';
            }
            $tabla .= '
                <optgroup label="Subdirección de Servicios Administrativos">
                    <div class="outgroup_divider_me"></div>
                    <div class="outgroup_title_me">Subdirección de Servicios Administrativos</div>
            ';
            $current_group = 'Subdirección de Servicios Administrativos';
        }

        // Agregamos la opción del departamento actual
        $tabla .= '<option value="'.$id.'">'.$nombre.'</option>';
    }

    // Cerramos el último optgroup
    if ($current_group !== "") {
        $tabla .= '</optgroup>';
    }

    // Cerramos el select y el formulario
    $tabla .= '
                </select> 
                <button class="btn btn-outline-light" type="submit" id="button-addon2">Buscar</button>
            </div>  
        </form>
    ';


    // Imprimimos la tabla
    echo $tabla;

    // Liberamos resultados y cerramos conexión
    mysqli_free_result($resultado);
    mysqli_close($conexion_database);
?>