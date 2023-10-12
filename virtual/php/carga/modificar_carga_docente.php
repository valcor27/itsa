<?php 
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");

    $id = $_POST["id"];

    /*-----Consultamos la base de datos completa--------------------------------------------------------------------*/
        $consulta="SELECT iddetalle_carga, carga_idcarga, salon_idsalon, grupo_idgrupo, materia_idmateria, clave_docente, hora_entrada, hora_salida, punto FROM detalle_carga WHERE iddetalle_carga='$id' LIMIT 1";
        $resultado=mysqli_query($conexion_database, $consulta);

        $datos = array();

        while($row = mysqli_fetch_array($resultado)) {

            $iddetalle_carga = $row['iddetalle_carga'];
            $carga_idcarga = $row['carga_idcarga'];
            $salon_idsalon = $row['salon_idsalon'];
            $grupo_idgrupo = $row['grupo_idgrupo'];
            $materia_idmateria = $row['materia_idmateria'];
            $clave_docente = $row['clave_docente'];
            $hora_entrada = $row['hora_entrada'];
            $hora_salida = $row['hora_salida'];
            $punto = $row['punto'];
            $hora = $hora_entrada.'-'.$hora_salida;
        }

        $datos = array(
            0 => $iddetalle_carga,
            1 => $carga_idcarga,
            2 => $materia_idmateria,
            3 => $salon_idsalon,
            4 => $grupo_idgrupo,
            5 => $clave_docente,
            6 => $hora,
            7 => $punto
        );
    /*---------------------------------------------------------------------------------------------------------*/
         
    echo json_encode($datos);

    mysqli_free_result($resultado);
    mysqli_close($conexion_database);
?>