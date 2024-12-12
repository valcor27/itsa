<?php 
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    
    $id = $_POST["id"];
    /*------------Consultamos la base de datos-----------*/
    $consulta = "SELECT expediente, primerApellido, segundoApellido, 
    nombres, sexo, fNaci, rfc, curp, contrasena, celular, mailP, 
    mailI, fAlta, nivel_idNivelUsuario, plaza_codigoPlaza, 
    estructuraReportada, estructuraReal, hora_entrada, hora_salida FROM empleados 
    WHERE expediente = '$id' LIMIT 1";
    $resultado = mysqli_query($conexion_database, $consulta);
    $datos = array();
    while($row = mysqli_fetch_array($resultado)){
        $expediente = $row['expediente'];
        $primerApellido = $row['primerApellido'];
        $segundoApellido = $row['segundoApellido'];
        $nombres = $row['nombres'];
        $sexo = $row['sexo'];
        $fNaci = date("d-m-Y", strtotime($row['fNaci']));
        $rfc = $row['rfc'];
        $curp = $row['curp'];
        $contrasena = $row['contrasena'];
        $celular = $row['celular'];
        $mailP = $row['mailP'];
        $mailI = $row['mailI'];
        $fAlta = date("d-m-Y", strtotime($row['fAlta']));
        $nivel_idNivelUsuario = $row['nivel_idNivelUsuario'];
        $plaza_codigoPlaza = $row['plaza_codigoPlaza'];
        $estructuraReportada = $row['estructuraReportada'];
        $estructuraReal = $row['estructuraReal'];
        $hora_entrada = date("H:i", strtotime($row['hora_entrada']));
        $hora_salida = date("H:i", strtotime($row['hora_salida']));
    }
    $datos = array(
        0 => $expediente,
        1 => $primerApellido,
        2 => $segundoApellido,
        3 => $nombres,
        4 => $sexo,
        5 => $fNaci,
        6 => $rfc,
        7 => $curp,
        8 => $contrasena,
        9 => $celular,
        10 => $mailP,
        11 => $mailI,
        12 => $fAlta,
        13 => $nivel_idNivelUsuario,
        14 => $plaza_codigoPlaza,
        15 => $estructuraReportada,
        16 => $estructuraReal,
        17 => $hora_entrada,
        18 => $hora_salida
    );
    /**------------------------------------------------- */
    echo json_encode($datos);

    mysqli_free_result($resultado);
    mysqli_close($conexion_database);
?>