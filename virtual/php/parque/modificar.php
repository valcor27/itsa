<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    $id = $_POST["id"];
    /**-----Consultamos la base de datos--------------- */
    $consulta = "SELECT idvehiculo, placas, noserie, kminicial, tipo, cilindro, kmporlitro, modelo, color, marca, submarca FROM vehiculo WHERE idvehiculo = '$id' LIMIT 1";
    $resultado = mysqli_query($conexion_database, $consulta);
    $datos = array();
    while($row = mysqli_fetch_array($resultado)){
        $id = $row['idvehiculo'];
        $placa = $row['placas'];
        $serie = $row['noserie'];
        $kmini = $row['kminicial'];
        $tipo = $row['tipo'];
        $cilindro = $row['cilindro'];
        $kmporlitro = $row['kmporlitro'];
        $modelo = $row['modelo'];
        $color = $row['color'];
        $marca = $row['marca'];
        $submarca = $row['submarca'];
    }
    $datos = array(
        0 => $id,
        1 => $placa,
        2 => $serie,
        3 => $kmini,
        4 => $tipo,
        5 => $cilindro,
        6 => $kmporlitro,
        7 => $modelo,
        8 => $color,
        9 => $marca,
        10 => $submarca

    );
    /**------------------------------------------------ */
    echo json_encode($datos);
    mysqli_free_result($resultado);
    mysqli_close($conexion_database);
?>