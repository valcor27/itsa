<?php 
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");
    
    $id = $_POST["id"];
    /*------------Consultamos la base de datos-----------*/
    $consulta = "SELECT expediente, primerApellido, segundoApellido, 
    nombres, sexo, fNaci, rfc, curp, celular, mailP, 
    mailI, fAlta, plaza_codigoPlaza, plaza_nombrePlaza, 
    reportada_nombreUnidad, real_nombreUnidad FROM empleados     		 	 	 	 	
    WHERE expediente = '$id' LIMIT 1";
    $resultado = mysqli_query($conexion_database, $consulta);
    $datos = array();
    while($row = mysqli_fetch_array($resultado)){
        $expediente = $row['expediente'];
        $primerApellido = sanear_string($row['primerApellido']);
        $segundoApellido = sanear_string($row['segundoApellido']);
        $nombres = sanear_string($row['nombres']);
        $nombre_completo = $nombres.' '.$primerApellido.' '.$segundoApellido;
        if($row['sexo'] == 1){
            $sexo = "Masculino";
        }else if($row['sexo'] == 2){
            $sexo = "Femenino";
        }
        $fNaci = date("d-m-Y", strtotime($row['fNaci']));
        $rfc = $row['rfc'];
        $curp = $row['curp'];
        $celular = $row['celular'];
        $mailP = $row['mailP'];
        $mailI = $row['mailI'];
        $fAlta = date("d-m-Y", strtotime($row['fAlta']));
        $plaza_codigoPlaza = $row['plaza_codigoPlaza'];
        $nombre_plaza = $row['plaza_nombrePlaza'];
        $nombre_reportada = $row['reportada_nombreUnidad'];
        $nombre_real = $row['real_nombreUnidad'];
    }
    $datos = array(
        0 => $expediente,
        1 => $nombre_completo,
        2 => $sexo,
        3 => $fNaci,
        4 => $rfc,
        5 => $curp,
        6 => $celular,
        7 => $mailP,
        8 => $mailI,
        9 => $fAlta,
        10 => $plaza_codigoPlaza,
        11 => $nombre_plaza,
        12 => $nombre_reportada,
        13 => $nombre_real
    );
    /**------------------------------------------------- */
    echo json_encode($datos);

    mysqli_free_result($resultado);
    mysqli_close($conexion_database);
?>