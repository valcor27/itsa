<?php 
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");
    require("../clases/limpiar.php");

    $idcarga = $_POST["idcarga"];
    $tabla='';
    $iddetalle_carga = $_POST["iddetalle"];
    
    /*Eliminamos el registro de la base de datos----------------------------------------------------------------*/
        $consulta="DELETE FROM detalle_carga WHERE iddetalle_carga='$iddetalle_carga'";
        $resultado=mysqli_query($conexion_database, $consulta);
    /*----------------------------------------------------------------------------------------------------------*/
    /**Buscamos el id del docente------------------------------------------------------------------------------ */
    $consulta_docente = "SELECT docente_iddocente FROM carga WHERE idcarga = '$idcarga' AND estatus = '1'";
    $resultado_docente = mysqli_query($conexion_database, $consulta_docente);
    while($row_docente = mysqli_fetch_array($resultado_docente)){
        $iddocente = $row_docente["docente_iddocente"];
    }
    mysqli_free_result($resultado_docente);
    /**-------------------------------------------------------------------------------------------------------- */
    $array = array(0 => $iddocente);
    echo json_encode($array);
    mysqli_close($conexion_database);
?>