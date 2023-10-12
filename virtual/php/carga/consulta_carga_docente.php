<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");
    date_default_timezone_set('America/Mexico_City');
    $fecha = date('Y-m-d');
    $usuario = $id_software_sesion;
    $proceso = "Registro";

    $docente_iddocente = $_POST["iddocente"];
    $estatus = 1;
    
    $detalle_docente='';
    $tabla='';

    /**consultamos la base de datos completa-------------------------------------------------------------------- */
    $consulta_u = "SELECT empleados_expediente, clave, nombre_docente FROM docentes WHERE id_docentes = '$docente_iddocente' LIMIT 1";
    $resultado_u = mysqli_query($conexion_database, $consulta_u);

    while($row = mysqli_fetch_array($resultado_u)){
        $expediente = $row["empleados_expediente"];
        $clave = $row["clave"];
        $nombre_docente = $row["nombre_docente"];

        $nombre_docente = sanear_string($nombre_docente);
    }
    mysqli_free_result($resultado_u);
    /**--------------------------------------------------------------------------------------------------------- */

    /**-----------Corroboramos que no exista la carga----------------------------------------------------------- */
    $consulta_comparar = "SELECT idcarga FROM carga WHERE docente_iddocente = '$docente_iddocente' AND estatus = '1' LIMIT 1";
    $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
    $filas_comparar = mysqli_num_rows($resultado_comparar);

    mysqli_free_result($resultado_comparar);
    /**--------------------------------------------------------------------------------------------------------- */

    /**----------Insertamos registros si no hay datos duplicados------------------------------------------------ */
    if($filas_comparar == 0){
        $inserta = "INSERT INTO carga(docente_iddocente, fecha_movimiento, ultimo_movimiento, usuario_movimiento, nombre_docente, estatus)VALUES('$docente_iddocente', '$fecha', '$proceso', '$usuario', '$nombre_docente', '$estatus')";
        $proceso_carga=mysqli_query($conexion_database, $inserta);
    }
    /**--------------------------------------------------------------------------------------------------------- */

    /**-------Mostrar datos del docente en pantalla------------------------------------------------------------- */
    $detalle_docente = $detalle_docente.'
        <div class="col-auto">
            <p class="datos_docente">Nombre: <span id="nombre_docente"> '.$nombre_docente.' </span></p>
        </div>
        <div class="col-auto">
            <p class="datos_docente">Expediente: <span id="expediente_doc"> '.$expediente.' </span></p>
        </div>
        <div class="col-auto">
            <p class="datos_docente">Clave: <span id="clave_doc"> '.$clave.' </span></p>
        </div>
    ';
    /**--------------------------------------------------------------------------------------------------------- */
    /**Consultamos la base de datos para obtener id de carga de docente----------------------------------------- */
        $consulta_c = "SELECT idcarga FROM carga WHERE docente_iddocente = '$docente_iddocente' AND estatus = '1' LIMIT 1";
        $resultado_c = mysqli_query($conexion_database, $consulta_c);

        while($row_c = mysqli_fetch_array($resultado_c)){
            $idcarga=$row_c["idcarga"];
        }

        mysqli_free_result($resultado_c);
        /**Consultamos la base de datos para obtener la fila 1-------------------------------------------------- */
            $consulta_1="
                SELECT 
                    'Diferencias_new',
                    t1.idaux,
                    t1.dia_aux,
                    t1.punto_aux, 
                    t1.etiqueta_aux,
                    t1.columna_aux,
                    t1.estatus_aux
                FROM aux t1
                WHERE 
                    t1.hora_entrada_aux='07:00' AND
                    t1.punto_aux NOT IN (SELECT t2.punto FROM detalle_carga t2 WHERE t1.punto_aux=t2.punto AND t2.carga_idcarga='$idcarga')
                UNION ALL
                SELECT 'Coincidencias', t1.iddetalle_carga, t1.dia, t1.punto, t1.etiqueta as x, t1.columna, t1.estatus
                FROM detalle_carga t1
                WHERE t1.hora_entrada='07:00' AND t1.carga_idcarga='$idcarga' AND t1.punto NOT IN (SELECT t2.punto_aux FROM aux t2 WHERE t1.punto<>t2.punto_aux AND t1.carga_idcarga = '$idcarga')
                ORDER BY columna_aux ASC
            ";
            $resultado_1=mysqli_query($conexion_database, $consulta_1);
            if (!$resultado_1) {
                die("Error en la consulta: " . mysqli_error($conexion_database));
            }
            $no_filas_1 = mysqli_num_rows($resultado_1);
        /*-------------------------------------------------------------------------------------------------------*/
        /**Consultamos la base de datos para obtener la fila 2-------------------------------------------------- */
            $consulta_2="
                SELECT 
                    'Diferencias_new',
                    t1.idaux,
                    t1.dia_aux,
                    t1.punto_aux, 
                    t1.etiqueta_aux,
                    t1.columna_aux,
                    t1.estatus_aux
                FROM aux t1
                WHERE 
                    t1.hora_entrada_aux='08:00' AND
                    t1.punto_aux NOT IN (SELECT t2.punto FROM detalle_carga t2 WHERE t1.punto_aux=t2.punto AND t2.carga_idcarga='$idcarga')
                UNION ALL
                SELECT 'Coincidencias', t1.iddetalle_carga, t1.dia, t1.punto, t1.etiqueta as x, t1.columna, t1.estatus
                FROM detalle_carga t1
                WHERE t1.hora_entrada='08:00' AND t1.carga_idcarga='$idcarga' AND t1.punto NOT IN (SELECT t2.punto_aux FROM aux t2 WHERE t1.punto<>t2.punto_aux AND t1.carga_idcarga = '$idcarga')
                ORDER BY columna_aux ASC
            ";
            $resultado_2=mysqli_query($conexion_database, $consulta_2);
            $no_filas_2 = mysqli_num_rows($resultado_2);
        /*-------------------------------------------------------------------------------------------------------*/
        /**Consultamos la base de datos para obtener la fila 3-------------------------------------------------- */
            $consulta_3="
                SELECT 
                    'Diferencias_new',
                    t1.idaux,
                    t1.dia_aux,
                    t1.punto_aux, 
                    t1.etiqueta_aux,
                    t1.columna_aux,
                    t1.estatus_aux
                FROM aux t1
                WHERE 
                    t1.hora_entrada_aux='09:00' AND
                    t1.punto_aux NOT IN (SELECT t2.punto FROM detalle_carga t2 WHERE t1.punto_aux=t2.punto AND t2.carga_idcarga='$idcarga')
                UNION ALL
                SELECT 'Coincidencias', t1.iddetalle_carga, t1.dia, t1.punto, t1.etiqueta as x, t1.columna, t1.estatus
                FROM detalle_carga t1
                WHERE t1.hora_entrada='09:00' AND t1.carga_idcarga='$idcarga' AND t1.punto NOT IN (SELECT t2.punto_aux FROM aux t2 WHERE t1.punto<>t2.punto_aux AND t1.carga_idcarga = '$idcarga')
                ORDER BY columna_aux ASC
            ";
            $resultado_3=mysqli_query($conexion_database, $consulta_3);
            $no_filas_3 = mysqli_num_rows($resultado_3);
        /*-------------------------------------------------------------------------------------------------------*/
        /**Consultamos la base de datos para obtener la fila 4-------------------------------------------------- */
            $consulta_4="
                SELECT 
                    'Diferencias_new',
                    t1.idaux,
                    t1.dia_aux,
                    t1.punto_aux, 
                    t1.etiqueta_aux,
                    t1.columna_aux,
                    t1.estatus_aux
                FROM aux t1
                WHERE 
                    t1.hora_entrada_aux='10:00' AND
                    t1.punto_aux NOT IN (SELECT t2.punto FROM detalle_carga t2 WHERE t1.punto_aux=t2.punto AND t2.carga_idcarga='$idcarga')
                UNION ALL
                SELECT 'Coincidencias', t1.iddetalle_carga, t1.dia, t1.punto, t1.etiqueta as x, t1.columna, t1.estatus
                FROM detalle_carga t1
                WHERE t1.hora_entrada='10:00' AND t1.carga_idcarga='$idcarga' AND t1.punto NOT IN (SELECT t2.punto_aux FROM aux t2 WHERE t1.punto<>t2.punto_aux AND t1.carga_idcarga = '$idcarga')
                ORDER BY columna_aux ASC
            ";
            $resultado_4=mysqli_query($conexion_database, $consulta_4);
            $no_filas_4 = mysqli_num_rows($resultado_4);
        /*-------------------------------------------------------------------------------------------------------*/
        /**Consultamos la base de datos para obtener la fila 5-------------------------------------------------- */
            $consulta_5="
                SELECT 
                    'Diferencias_new',
                    t1.idaux,
                    t1.dia_aux,
                    t1.punto_aux, 
                    t1.etiqueta_aux,
                    t1.columna_aux,
                    t1.estatus_aux
                FROM aux t1
                WHERE 
                    t1.hora_entrada_aux='11:00' AND
                    t1.punto_aux NOT IN (SELECT t2.punto FROM detalle_carga t2 WHERE t1.punto_aux=t2.punto AND t2.carga_idcarga='$idcarga')
                UNION ALL
                SELECT 'Coincidencias', t1.iddetalle_carga, t1.dia, t1.punto, t1.etiqueta as x, t1.columna, t1.estatus
                FROM detalle_carga t1
                WHERE t1.hora_entrada='11:00' AND t1.carga_idcarga='$idcarga' AND t1.punto NOT IN (SELECT t2.punto_aux FROM aux t2 WHERE t1.punto<>t2.punto_aux AND t1.carga_idcarga = '$idcarga')
                ORDER BY columna_aux ASC
            ";
            $resultado_5=mysqli_query($conexion_database, $consulta_5);
            $no_filas_5 = mysqli_num_rows($resultado_5);
        /*-------------------------------------------------------------------------------------------------------*/
        /**Consultamos la base de datos para obtener la fila 6-------------------------------------------------- */
            $consulta_6="
                SELECT 
                    'Diferencias_new',
                    t1.idaux,
                    t1.dia_aux,
                    t1.punto_aux, 
                    t1.etiqueta_aux,
                    t1.columna_aux,
                    t1.estatus_aux
                FROM aux t1
                WHERE 
                    t1.hora_entrada_aux='12:00' AND
                    t1.punto_aux NOT IN (SELECT t2.punto FROM detalle_carga t2 WHERE t1.punto_aux=t2.punto AND t2.carga_idcarga='$idcarga')
                UNION ALL
                SELECT 'Coincidencias', t1.iddetalle_carga, t1.dia, t1.punto, t1.etiqueta as x, t1.columna, t1.estatus
                FROM detalle_carga t1
                WHERE t1.hora_entrada='12:00' AND t1.carga_idcarga='$idcarga' AND t1.punto NOT IN (SELECT t2.punto_aux FROM aux t2 WHERE t1.punto<>t2.punto_aux AND t1.carga_idcarga = '$idcarga')
                ORDER BY columna_aux ASC
            ";
            $resultado_6=mysqli_query($conexion_database, $consulta_6);
            $no_filas_6 = mysqli_num_rows($resultado_6);
        /*-------------------------------------------------------------------------------------------------------*/
        /**Consultamos la base de datos para obtener la fila 7-------------------------------------------------- */
            $consulta_7="
                SELECT 
                    'Diferencias_new',
                    t1.idaux,
                    t1.dia_aux,
                    t1.punto_aux, 
                    t1.etiqueta_aux,
                    t1.columna_aux,
                    t1.estatus_aux
                FROM aux t1
                WHERE 
                    t1.hora_entrada_aux='13:00' AND
                    t1.punto_aux NOT IN (SELECT t2.punto FROM detalle_carga t2 WHERE t1.punto_aux=t2.punto AND t2.carga_idcarga='$idcarga')
                UNION ALL
                SELECT 'Coincidencias', t1.iddetalle_carga, t1.dia, t1.punto, t1.etiqueta as x, t1.columna, t1.estatus
                FROM detalle_carga t1
                WHERE t1.hora_entrada='13:00' AND t1.carga_idcarga='$idcarga' AND t1.punto NOT IN (SELECT t2.punto_aux FROM aux t2 WHERE t1.punto<>t2.punto_aux AND t1.carga_idcarga = '$idcarga')
                ORDER BY columna_aux ASC
            ";
            $resultado_7=mysqli_query($conexion_database, $consulta_7);
            $no_filas_7 = mysqli_num_rows($resultado_7);
        /*-------------------------------------------------------------------------------------------------------*/
        /**Consultamos la base de datos para obtener la fila 8-------------------------------------------------- */
            $consulta_8="
                SELECT 
                    'Diferencias_new',
                    t1.idaux,
                    t1.dia_aux,
                    t1.punto_aux, 
                    t1.etiqueta_aux,
                    t1.columna_aux,
                    t1.estatus_aux
                FROM aux t1
                WHERE 
                    t1.hora_entrada_aux='14:00' AND
                    t1.punto_aux NOT IN (SELECT t2.punto FROM detalle_carga t2 WHERE t1.punto_aux=t2.punto AND t2.carga_idcarga='$idcarga')
                UNION ALL
                SELECT 'Coincidencias', t1.iddetalle_carga, t1.dia, t1.punto, t1.etiqueta as x, t1.columna, t1.estatus
                FROM detalle_carga t1
                WHERE t1.hora_entrada='14:00' AND t1.carga_idcarga='$idcarga' AND t1.punto NOT IN (SELECT t2.punto_aux FROM aux t2 WHERE t1.punto<>t2.punto_aux AND t1.carga_idcarga = '$idcarga')
                ORDER BY columna_aux ASC
            ";
            $resultado_8=mysqli_query($conexion_database, $consulta_8);
            $no_filas_8 = mysqli_num_rows($resultado_8);
        /*-------------------------------------------------------------------------------------------------------*/
        /**Consultamos la base de datos para obtener la fila 9-------------------------------------------------- */
            $consulta_9="
                SELECT 
                    'Diferencias_new',
                    t1.idaux,
                    t1.dia_aux,
                    t1.punto_aux, 
                    t1.etiqueta_aux,
                    t1.columna_aux,
                    t1.estatus_aux
                FROM aux t1
                WHERE 
                    t1.hora_entrada_aux='15:00' AND
                    t1.punto_aux NOT IN (SELECT t2.punto FROM detalle_carga t2 WHERE t1.punto_aux=t2.punto AND t2.carga_idcarga='$idcarga')
                UNION ALL
                SELECT 'Coincidencias', t1.iddetalle_carga, t1.dia, t1.punto, t1.etiqueta as x, t1.columna, t1.estatus
                FROM detalle_carga t1
                WHERE t1.hora_entrada='15:00' AND t1.carga_idcarga='$idcarga' AND t1.punto NOT IN (SELECT t2.punto_aux FROM aux t2 WHERE t1.punto<>t2.punto_aux AND t1.carga_idcarga = '$idcarga')
                ORDER BY columna_aux ASC
            ";
            $resultado_9=mysqli_query($conexion_database, $consulta_9);
            $no_filas_9 = mysqli_num_rows($resultado_9);
        /*-------------------------------------------------------------------------------------------------------*/
        /**Consultamos la base de datos para obtener la fila 10------------------------------------------------- */
            $consulta_10="
                SELECT 
                    'Diferencias_new',
                    t1.idaux,
                    t1.dia_aux,
                    t1.punto_aux, 
                    t1.etiqueta_aux,
                    t1.columna_aux,
                    t1.estatus_aux
                FROM aux t1
                WHERE 
                    t1.hora_entrada_aux='16:00' AND
                    t1.punto_aux NOT IN (SELECT t2.punto FROM detalle_carga t2 WHERE t1.punto_aux=t2.punto AND t2.carga_idcarga='$idcarga')
                UNION ALL
                SELECT 'Coincidencias', t1.iddetalle_carga, t1.dia, t1.punto, t1.etiqueta as x, t1.columna, t1.estatus
                FROM detalle_carga t1
                WHERE t1.hora_entrada='16:00' AND t1.carga_idcarga='$idcarga' AND t1.punto NOT IN (SELECT t2.punto_aux FROM aux t2 WHERE t1.punto<>t2.punto_aux AND t1.carga_idcarga = '$idcarga')
                ORDER BY columna_aux ASC
            ";
            $resultado_10=mysqli_query($conexion_database, $consulta_10);
            $no_filas_10 = mysqli_num_rows($resultado_10);
        /*-------------------------------------------------------------------------------------------------------*/
        /**Consultamos la base de datos para obtener la fila 11------------------------------------------------- */
            $consulta_11="
                SELECT 
                    'Diferencias_new',
                    t1.idaux,
                    t1.dia_aux,
                    t1.punto_aux, 
                    t1.etiqueta_aux,
                    t1.columna_aux,
                    t1.estatus_aux
                FROM aux t1
                WHERE 
                    t1.hora_entrada_aux='17:00' AND
                    t1.punto_aux NOT IN (SELECT t2.punto FROM detalle_carga t2 WHERE t1.punto_aux=t2.punto AND t2.carga_idcarga='$idcarga')
                UNION ALL
                SELECT 'Coincidencias', t1.iddetalle_carga, t1.dia, t1.punto, t1.etiqueta as x, t1.columna, t1.estatus
                FROM detalle_carga t1
                WHERE t1.hora_entrada='17:00' AND t1.carga_idcarga='$idcarga' AND t1.punto NOT IN (SELECT t2.punto_aux FROM aux t2 WHERE t1.punto<>t2.punto_aux AND t1.carga_idcarga = '$idcarga')
                ORDER BY columna_aux ASC
            ";
            $resultado_11=mysqli_query($conexion_database, $consulta_11);
            $no_filas_11 = mysqli_num_rows($resultado_11);
        /*-------------------------------------------------------------------------------------------------------*/
        /**Consultamos la base de datos para obtener la fila 12------------------------------------------------- */
            $consulta_12="
                SELECT 
                    'Diferencias_new',
                    t1.idaux,
                    t1.dia_aux,
                    t1.punto_aux, 
                    t1.etiqueta_aux,
                    t1.columna_aux,
                    t1.estatus_aux
                FROM aux t1
                WHERE 
                    t1.hora_entrada_aux='18:00' AND
                    t1.punto_aux NOT IN (SELECT t2.punto FROM detalle_carga t2 WHERE t1.punto_aux=t2.punto AND t2.carga_idcarga='$idcarga')
                UNION ALL
                SELECT 'Coincidencias', t1.iddetalle_carga, t1.dia, t1.punto, t1.etiqueta as x, t1.columna, t1.estatus
                FROM detalle_carga t1
                WHERE t1.hora_entrada='18:00' AND t1.carga_idcarga='$idcarga' AND t1.punto NOT IN (SELECT t2.punto_aux FROM aux t2 WHERE t1.punto<>t2.punto_aux AND t1.carga_idcarga = '$idcarga')
                ORDER BY columna_aux ASC
            ";
            $resultado_12=mysqli_query($conexion_database, $consulta_12);
            $no_filas_12 = mysqli_num_rows($resultado_12);
        /*-------------------------------------------------------------------------------------------------------*/
        /**Consultamos la base de datos para obtener la fila 13------------------------------------------------- */
            $consulta_13="
                SELECT 
                    'Diferencias_new',
                    t1.idaux,
                    t1.dia_aux,
                    t1.punto_aux, 
                    t1.etiqueta_aux,
                    t1.columna_aux,
                    t1.estatus_aux
                FROM aux t1
                WHERE 
                    t1.hora_entrada_aux='19:00' AND
                    t1.punto_aux NOT IN (SELECT t2.punto FROM detalle_carga t2 WHERE t1.punto_aux=t2.punto AND t2.carga_idcarga='$idcarga')
                UNION ALL
                SELECT 'Coincidencias', t1.iddetalle_carga, t1.dia, t1.punto, t1.etiqueta as x, t1.columna, t1.estatus
                FROM detalle_carga t1
                WHERE t1.hora_entrada='19:00' AND t1.carga_idcarga='$idcarga' AND t1.punto NOT IN (SELECT t2.punto_aux FROM aux t2 WHERE t1.punto<>t2.punto_aux AND t1.carga_idcarga = '$idcarga')
                ORDER BY columna_aux ASC
            ";
            $resultado_13=mysqli_query($conexion_database, $consulta_13);
            $no_filas_13 = mysqli_num_rows($resultado_13);
        /*-------------------------------------------------------------------------------------------------------*/
        /**Consultamos la base de datos para obtener la fila 14-------------------------------------------------- */
            $consulta_14="
                SELECT 
                    'Diferencias_new',
                    t1.idaux,
                    t1.dia_aux,
                    t1.punto_aux, 
                    t1.etiqueta_aux,
                    t1.columna_aux,
                    t1.estatus_aux
                FROM aux t1
                WHERE 
                    t1.hora_entrada_aux='20:00' AND
                    t1.punto_aux NOT IN (SELECT t2.punto FROM detalle_carga t2 WHERE t1.punto_aux=t2.punto AND t2.carga_idcarga='$idcarga')
                UNION ALL
                SELECT 'Coincidencias', t1.iddetalle_carga, t1.dia, t1.punto, t1.etiqueta as x, t1.columna, t1.estatus
                FROM detalle_carga t1
                WHERE t1.hora_entrada='20:00' AND t1.carga_idcarga='$idcarga' AND t1.punto NOT IN (SELECT t2.punto_aux FROM aux t2 WHERE t1.punto<>t2.punto_aux AND t1.carga_idcarga = '$idcarga')
                ORDER BY columna_aux ASC
            ";
            $resultado_14=mysqli_query($conexion_database, $consulta_14);
            $no_filas_14 = mysqli_num_rows($resultado_14);
        /*-------------------------------------------------------------------------------------------------------*/

        /*Programamos la matriz que se va a mostrar en la pantalla ----------------------------------------------*/
            $tabla = $tabla.'
                <div class="table-responsive">
                    <table id="mi-tabla" class="table table-bordered table-list table-hover table_modulos">
                        <thead>
                            <th></th>
                            <th>LUNES</th>
                            <th>MARTES</th>
                            <th>MIERCOLES</th>
                            <th>JUEVES</th>
                            <th>VIERNES</th>
                            <th>SABADO</th>
                        </thead>
                        <tbody>
                            <tr id="07:00-08:00">
                                <th id="fila_1">07:00-08:00</th>
            ';
            while($row_1 = mysqli_fetch_array($resultado_1)){
                $id_1=$row_1["idaux"];
                $punto_1=$row_1["punto_aux"];
                $etiqueta_1=$row_1["etiqueta_aux"];
                $estatus_1=$row_1["estatus_aux"];

                if($estatus_1=="0"){
                    $proceso_1='
                        <td align="center" id="'.$punto_1.'" onclick="Modal_carga_materia(this);">
                            <i class="fa-regular fa-file-lines ic_materia"></i>
                            <div class="l_materia_vacio">
                                '.$etiqueta_1.'
                            </div>
                        </td>
                    ';
                }else{
                    $proceso_1='
                        <td align="center" id="'.$punto_1.'" onclick="Modificar_carga_materia('.$id_1.');">
                            <i class="fa-regular fa-file-lines ic_materia"></i>
                            <div class="l_materia">
                                '.$etiqueta_1.'
                            </div>
                        </td>
                    ';
                }

                $tabla = $tabla.'
                    '.$proceso_1.'
                ';
            }
            $tabla = $tabla.'
                            </tr>
                            <tr id="08:00-09:00">
                                <th>08:00-09:00</th>
            '; 
            while($row_2 = mysqli_fetch_array($resultado_2)){
                $id_2=$row_2["idaux"];
                $punto_2=$row_2["punto_aux"];
                $etiqueta_2=$row_2["etiqueta_aux"];
                $estatus_2=$row_2["estatus_aux"];

                if($estatus_2=="0"){
                    $proceso_2='
                        <td align="center" id="'.$punto_2.'" onclick="Modal_carga_materia(this);">
                        <i class="fa-regular fa-file-lines ic_materia"></i>
                            <div class="l_materia_vacio">
                                '.$etiqueta_2.'
                            </div>
                        </td>
                    ';
                }else{
                    $proceso_2='
                        <td align="center" id="'.$punto_2.'" onclick="Modificar_carga_materia('.$id_2.');">
                            <i class="fa-regular fa-file-lines ic_materia"></i>
                            <div class="l_materia">
                                '.$etiqueta_2.'
                            </div>
                        </td>
                    ';
                }

                $tabla = $tabla.'
                    '.$proceso_2.'
                ';
            }
            $tabla = $tabla.'
                            </tr>
                            <tr id="09:00-10:00">
                                <th>09:00-10:00</th>
            '; 
            while($row_3 = mysqli_fetch_array($resultado_3)){
                $id_3=$row_3["idaux"];
                $punto_3=$row_3["punto_aux"];
                $etiqueta_3=$row_3["etiqueta_aux"];
                $estatus_3=$row_3["estatus_aux"];

                if($estatus_3=="0"){
                    $proceso_3='
                        <td align="center" id="'.$punto_3.'" onclick="Modal_carga_materia(this);">
                            <i class="fa-regular fa-file-lines ic_materia"></i>
                            <div class="l_materia_vacio">
                                '.$etiqueta_3.'
                            </div>
                        </td>
                    ';
                }else{
                    $proceso_3='
                        <td align="center" id="'.$punto_3.'" onclick="Modificar_carga_materia('.$id_3.');">
                            <i class="fa-regular fa-file-lines ic_materia"></i>
                            <div class="l_materia">
                                '.$etiqueta_3.'
                            </div>
                        </td>
                    ';
                }

                $tabla = $tabla.'
                    '.$proceso_3.'
                ';
            }
            $tabla = $tabla.'
                            </tr>
                            <tr id="10:00-11:00">
                                <th>10:00-11:00</th>
            '; 
            while($row_4 = mysqli_fetch_array($resultado_4)){
                $id_4=$row_4["idaux"];
                $punto_4=$row_4["punto_aux"];
                $etiqueta_4=$row_4["etiqueta_aux"];
                $estatus_4=$row_4["estatus_aux"];

                if($estatus_4=="0"){
                    $proceso_4='
                        <td align="center" id="'.$punto_4.'" onclick="Modal_carga_materia(this);">
                            <i class="fa-regular fa-file-lines ic_materia"></i>
                            <div class="l_materia_vacio">
                                '.$etiqueta_4.'
                            </div>
                        </td>
                    ';
                }else{
                    $proceso_4='
                        <td align="center" id="'.$punto_4.'" onclick="Modificar_carga_materia('.$id_4.');">
                            <i class="fa-regular fa-file-lines ic_materia"></i>
                            <div class="l_materia">
                                '.$etiqueta_4.'
                            </div>
                        </td>
                    ';
                }

                $tabla = $tabla.'
                    '.$proceso_4.'
                ';
            }
            $tabla = $tabla.'
                            </tr>
                            <tr id="11:00-12:00">
                                <th>11:00-12:00</th>
            '; 
            while($row_5 = mysqli_fetch_array($resultado_5)){
                $id_5=$row_5["idaux"];
                $punto_5=$row_5["punto_aux"];
                $etiqueta_5=$row_5["etiqueta_aux"];
                $estatus_5=$row_5["estatus_aux"];

                if($estatus_5=="0"){
                    $proceso_5='
                        <td align="center" id="'.$punto_5.'" onclick="Modal_carga_materia(this);">
                            <i class="fa-regular fa-file-lines ic_materia"></i>
                            <div class="l_materia_vacio">
                                '.$etiqueta_5.'
                            </div>
                        </td>
                    ';
                }else{
                    $proceso_5='
                        <td align="center" id="'.$punto_5.'" onclick="Modificar_carga_materia('.$id_5.');">
                            <i class="fa-regular fa-file-lines ic_materia"></i>
                            <div class="l_materia">
                                '.$etiqueta_5.'
                            </div>
                        </td>
                    ';
                }

                $tabla = $tabla.'
                    '.$proceso_5.'
                ';
            }
            $tabla = $tabla.'
                            </tr>
                            <tr id="12:00-13:00">
                                <th>12:00-13:00</th>
            '; 
            while($row_6 = mysqli_fetch_array($resultado_6)){
                $id_6=$row_6["idaux"];
                $punto_6=$row_6["punto_aux"];
                $etiqueta_6=$row_6["etiqueta_aux"];
                $estatus_6=$row_6["estatus_aux"];

                if($estatus_6=="0"){
                    $proceso_6='
                        <td align="center" id="'.$punto_6.'" onclick="Modal_carga_materia(this);">
                            <i class="fa-regular fa-file-lines ic_materia"></i>
                            <div class="l_materia_vacio">
                                '.$etiqueta_6.'
                            </div>
                        </td>
                    ';
                }else{
                    $proceso_6='
                        <td align="center" id="'.$punto_6.'" onclick="Modificar_carga_materia('.$id_6.');">
                            <i class="fa-regular fa-file-lines ic_materia"></i>
                            <div class="l_materia">
                                '.$etiqueta_6.'
                            </div>
                        </td>
                    ';
                }

                $tabla = $tabla.'
                    '.$proceso_6.'
                ';
            }
            $tabla = $tabla.'
                            </tr>
                            <tr id="13:00-14:00">
                                <th>13:00-14:00</th>
            '; 
            while($row_7 = mysqli_fetch_array($resultado_7)){
                $id_7=$row_7["idaux"];
                $punto_7=$row_7["punto_aux"];
                $etiqueta_7=$row_7["etiqueta_aux"];
                $estatus_7=$row_7["estatus_aux"];

                if($estatus_7=="0"){
                    $proceso_7='
                        <td align="center" id="'.$punto_7.'" onclick="Modal_carga_materia(this);">
                            <i class="fa-regular fa-file-lines ic_materia"></i>
                            <div class="l_materia_vacio">
                                '.$etiqueta_7.'
                            </div>
                        </td>
                    ';
                }else{
                    $proceso_7='
                        <td align="center" id="'.$punto_7.'" onclick="Modificar_carga_materia('.$id_7.');">
                            <i class="fa-regular fa-file-lines ic_materia"></i>
                            <div class="l_materia">
                                '.$etiqueta_7.'
                            </div>
                        </td>
                    ';
                }

                $tabla = $tabla.'
                    '.$proceso_7.'
                ';
            }
            $tabla = $tabla.'
                            </tr>
                            <tr id="14:00-15:00">
                                <th>14:00-15:00</th>
            '; 
            while($row_8 = mysqli_fetch_array($resultado_8)){
                $id_8=$row_8["idaux"];
                $punto_8=$row_8["punto_aux"];
                $etiqueta_8=$row_8["etiqueta_aux"];
                $estatus_8=$row_8["estatus_aux"];

                if($estatus_8=="0"){
                    $proceso_8='
                        <td align="center" id="'.$punto_8.'" onclick="Modal_carga_materia(this);">
                            <i class="fa-regular fa-file-lines ic_materia"></i>
                            <div class="l_materia_vacio">
                                '.$etiqueta_8.'
                            </div>
                        </td>
                    ';
                }else{
                    $proceso_8='
                        <td align="center" id="'.$punto_8.'" onclick="Modificar_carga_materia('.$id_8.');">
                            <i class="fa-regular fa-file-lines ic_materia"></i>
                            <div class="l_materia">
                                '.$etiqueta_8.'
                            </div>
                        </td>
                    ';
                }

                $tabla = $tabla.'
                    '.$proceso_8.'
                ';
            }
            $tabla = $tabla.'
                            </tr>
                            <tr id="15:00-16:00">
                                <th>15:00-16:00</th>
            '; 
            while($row_9 = mysqli_fetch_array($resultado_9)){
                $id_9=$row_9["idaux"];
                $punto_9=$row_9["punto_aux"];
                $etiqueta_9=$row_9["etiqueta_aux"];
                $estatus_9=$row_9["estatus_aux"];

                if($estatus_9=="0"){
                    $proceso_9='
                        <td align="center" id="'.$punto_9.'" onclick="Modal_carga_materia(this);">
                            <i class="fa-regular fa-file-lines ic_materia"></i>
                            <div class="l_materia_vacio">
                                '.$etiqueta_9.'
                            </div>
                        </td>
                    ';
                }else{
                    $proceso_9='
                        <td align="center" id="'.$punto_9.'" onclick="Modificar_carga_materia('.$id_9.');">
                            <i class="fa-regular fa-file-lines ic_materia"></i>
                            <div class="l_materia">
                                '.$etiqueta_9.'
                            </div>
                        </td>
                    ';
                }

                $tabla = $tabla.'
                    '.$proceso_9.'
                ';
            }
            $tabla = $tabla.'
                            </tr>
                            <tr id="16:00-17:00">
                                <th>16:00-17:00</th>
            '; 
            while($row_10 = mysqli_fetch_array($resultado_10)){
                $id_10=$row_10["idaux"];
                $punto_10=$row_10["punto_aux"];
                $etiqueta_10=$row_10["etiqueta_aux"];
                $estatus_10=$row_10["estatus_aux"];

                if($estatus_10=="0"){
                    $proceso_10='
                        <td align="center" id="'.$punto_10.'" onclick="Modal_carga_materia(this);">
                            <i class="fa-regular fa-file-lines ic_materia"></i>
                            <div class="l_materia_vacio">
                                '.$etiqueta_10.'
                            </div>
                        </td>
                    ';
                }else{
                    $proceso_10='
                        <td align="center" id="'.$punto_10.'" onclick="Modificar_carga_materia('.$id_10.');">
                            <i class="fa-regular fa-file-lines ic_materia"></i>
                            <div class="l_materia">
                                '.$etiqueta_10.'
                            </div>
                        </td>
                    ';
                }

                $tabla = $tabla.'
                    '.$proceso_10.'
                ';
            }
            $tabla = $tabla.'
                            </tr>
                            <tr id="17:00-18:00">
                                <th>17:00-18:00</th>
            '; 
            while($row_11 = mysqli_fetch_array($resultado_11)){
                $id_11=$row_11["idaux"];
                $punto_11=$row_11["punto_aux"];
                $etiqueta_11=$row_11["etiqueta_aux"];
                $estatus_11=$row_11["estatus_aux"];

                if($estatus_11=="0"){
                    $proceso_11='
                        <td align="center" id="'.$punto_11.'" onclick="Modal_carga_materia(this);">
                            <i class="fa-regular fa-file-lines ic_materia"></i>
                            <div class="l_materia_vacio">
                                '.$etiqueta_11.'
                            </div>
                        </td>
                    ';
                }else{
                    $proceso_11='
                        <td align="center" id="'.$punto_11.'" onclick="Modificar_carga_materia('.$id_11.');">
                            <i class="fa-regular fa-file-lines ic_materia"></i>
                            <div class="l_materia">
                                '.$etiqueta_11.'
                            </div>
                        </td>
                    ';
                }

                $tabla = $tabla.'
                    '.$proceso_11.'
                ';
            }
            $tabla = $tabla.'
                            </tr>
                            <tr id="18:00-19:00">
                                <th>18:00-19:00</th>
            '; 
            while($row_12 = mysqli_fetch_array($resultado_12)){
                $id_12=$row_12["idaux"];
                $punto_12=$row_12["punto_aux"];
                $etiqueta_12=$row_12["etiqueta_aux"];
                $estatus_12=$row_12["estatus_aux"];

                if($estatus_12=="0"){
                    $proceso_12='
                        <td align="center" id="'.$punto_12.'" onclick="Modal_carga_materia(this);">
                            <i class="fa-regular fa-file-lines ic_materia"></i>
                            <div class="l_materia_vacio">
                                '.$etiqueta_12.'
                            </div>
                        </td>
                    ';
                }else{
                    $proceso_12='
                        <td align="center" id="'.$punto_12.'" onclick="Modificar_carga_materia('.$id_12.');">
                            <i class="fa-regular fa-file-lines ic_materia"></i>
                            <div class="l_materia">
                                '.$etiqueta_12.'
                            </div>
                        </td>
                    ';
                }

                $tabla = $tabla.'
                    '.$proceso_12.'
                ';
            }
            $tabla = $tabla.'
                            </tr>
                            <tr id="19:00-20:00">
                                <th>19:00-20:00</th>
            '; 
            while($row_13 = mysqli_fetch_array($resultado_13)){
                $id_13=$row_13["idaux"];
                $punto_13=$row_13["punto_aux"];
                $etiqueta_13=$row_13["etiqueta_aux"];
                $estatus_13=$row_13["estatus_aux"];

                if($estatus_13=="0"){
                    $proceso_13='
                        <td align="center" id="'.$punto_13.'" onclick="Modal_carga_materia(this);">
                            <i class="fa-regular fa-file-lines ic_materia"></i>
                            <div class="l_materia_vacio">
                                '.$etiqueta_13.'
                            </div>
                        </td>
                    ';
                }else{
                    $proceso_13='
                        <td align="center" id="'.$punto_13.'" onclick="Modificar_carga_materia('.$id_13.');">
                            <i class="fa-regular fa-file-lines ic_materia"></i>
                            <div class="l_materia">
                                '.$etiqueta_13.'
                            </div>
                        </td>
                    ';
                }

                $tabla = $tabla.'
                    '.$proceso_13.'
                ';
            }
            $tabla = $tabla.'
                            </tr>
                            <tr id="20:00-21:00">
                                <th>20:00-21:00</th>
            '; 
            while($row_14 = mysqli_fetch_array($resultado_14)){
                $id_14=$row_14["idaux"];
                $punto_14=$row_14["punto_aux"];
                $etiqueta_14=$row_14["etiqueta_aux"];
                $estatus_14=$row_14["estatus_aux"];

                if($estatus_14=="0"){
                    $proceso_14='
                        <td align="center" id="'.$punto_14.'" onclick="Modal_carga_materia(this);">
                            <i class="fa-regular fa-file-lines ic_materia"></i>
                            <div class="l_materia_vacio">
                                '.$etiqueta_14.'
                            </div>
                        </td>
                    ';
                }else{
                    $proceso_14='
                        <td align="center" id="'.$punto_14.'" onclick="Modificar_carga_materia('.$id_14.');">
                            <i class="fa-regular fa-file-lines ic_materia"></i>
                            <div class="l_materia">
                                '.$etiqueta_14.'
                            </div>
                        </td>
                    ';
                }

                $tabla = $tabla.'
                    '.$proceso_14.'
                ';
            }
            $tabla = $tabla.'
                            </tr>
                        </tbody>
                    </table>
                </div>
            '; 
        /**----------------------------------------------------------------------------------------------------- */
    /**--------------------------------------------------------------------------------------------------------- */
    $array = array(
        0 => $detalle_docente,
        1 => $tabla,
        2 => $clave,
        3 => $idcarga
    );

    echo json_encode($array);

    mysqli_free_result($resultado_1);
    mysqli_free_result($resultado_2);
    mysqli_free_result($resultado_3);
    mysqli_free_result($resultado_4);
    mysqli_free_result($resultado_5);
    mysqli_free_result($resultado_6);
    mysqli_free_result($resultado_7);
    mysqli_free_result($resultado_8);
    mysqli_free_result($resultado_9);
    mysqli_free_result($resultado_10);
    mysqli_free_result($resultado_11);
    mysqli_free_result($resultado_12);
    mysqli_free_result($resultado_13);
    mysqli_free_result($resultado_14);

    mysqli_close($conexion_database);
?>