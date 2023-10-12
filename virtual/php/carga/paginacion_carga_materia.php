<?php
    require("../conexion/conexion_bd.php");
    require("../sesion/logueo.php");

    $idgrupo = $_POST["idgrupo"];
    $idmateria = $_POST["idmateria"];
    $tabla = '';

    /***--Consultamos BD para mostrar los registros encontradoe dn grupo-- */
      $consulta_grupo = "SELECT division_id_division FROM grupo WHERE id_grupo = '$idgrupo' LIMIT 1";
      $resultado_grupo = mysqli_query($conexion_database, $consulta_grupo);
      while($reg_grupo = mysqli_fetch_array($resultado_grupo)){
        $division = $reg_grupo["division_id_division"];
      }
    /**------------------------------------------------------------------- */
    /**Consultamo BS para mostrar los registros encontrados -------------- */
    $consulta_1 = "SELECT id_materia, nombre_materia FROM materia WHERE division_id_division = '$division' AND estatus = '1' ORDER BY nombre_materia";
    $registro_1 = mysqli_query($conexion_database, $consulta_1);
    /**------------------------------------------------------------------- */
    
    $tabla = $tabla.'
      <option value="">Selecciona</option>
    ';
    if($idmateria > 0){ 
      $consulta_2 = "SELECT id_materia, nombre_materia FROM materia WHERE id_materia = '$idmateria' AND division_id_division = '$division' AND estatus = '1'";
      $registro_2 = mysqli_query($conexion_database, $consulta_2);

      while($row_2 = mysqli_fetch_array($registro_2)){
        $tabla = $tabla.'
          <option value="'.$row_2["id_materia"].'" selected>'.$row_2["nombre_materia"].'</option>
        ';
      }
    }
    while($row = mysqli_fetch_array($registro_1)){
      $tabla = $tabla.'
        <option value="'.$row["id_materia"].'">'.$row["nombre_materia"].'</option>
      ';
    }

    $array = array(0 => $tabla);

    echo json_encode($array);

    mysqli_free_result($resultado_grupo);
    mysqli_close($conexion_database);

?>