<?php
  require("../conexion/conexion_bd.php");
  require("../sesion/logueo.php");
  require("../clases/limpiar.php");
  $proceso = $_POST["pro"];
  $id = $_POST["id"];
  $hora = $_POST["hora"];
  $punto = $_POST["punto"];
  $clave = $_POST["clave"];
  $carga_idcarga = $_POST["carga_idcarga"];
  $salon_idsalon = $_POST["salon_idsalon"];
  $grupo_idgrupo = $_POST["grupo_idgrupo"];
  $materia_idmateria = $_POST["materia_idmateria"];
  $estatus = 1;
  $comprobacion = "0";
  date_default_timezone_set('America/Mexico_City');
  $fecha = date('Y-m-d');
  $usuario = $id_software_sesion;
  /**--Seleccionamos el nombre del salon----------------------------------------------- */
    $consulta_salon = "SELECT id_salon, nombre_salon FROM salon WHERE id_salon = '$salon_idsalon' AND estatus = '1' LIMIT 1";
    $resultado_salon = mysqli_query($conexion_database, $consulta_salon);

    while($reg_salon = mysqli_fetch_array($resultado_salon)){
      $nombre_salon = $reg_salon["nombre_salon"];
      $nombre_salon = sanear_string($nombre_salon);
      $nombre_salon = strtoupper($nombre_salon);
      if (strlen($nombre_salon) > 4) {
        //Lista de palabras conectivas comunes
        $palabras_conectivas = ["de", "y", "la", "en", "para", "con", "lo", "los", "las"];
        //dividimos el nombre de la materia en palabras usando espacio como delimitador
        $palabras = explode(" ", $nombre_salon);
        //inicializamos una variable para las siglas 
        $etiqueta_salon = "";
        //Recorremos cada palabra
        foreach($palabras as $palabra){
          //verificamos si la palabra esta en la lista de las palabras conectivas
          if(!in_array(strtolower($palabra), $palabras_conectivas)){
            //tomamos la primera letra de la pablara y la convertimos en mayuscula
            $etiqueta_salon .= strtoupper(substr($palabra, 0, 1));
          }
        }
      }else{
        $etiqueta_salon = $nombre_salon;
      }
    }
    mysqli_free_result($resultado_salon);
  /**---------------------------------------------------------------------------------- */
  /**--Seleccionamos el nombre del grupo----------------------------------------------- */
    $consulta_grupo = "SELECT id_grupo, nombre_grupo FROM grupo WHERE id_grupo = '$grupo_idgrupo' AND estatus = '1' LIMIT 1";
    $resultado_grupo = mysqli_query($conexion_database, $consulta_grupo);

    while($reg_grupo = mysqli_fetch_array($resultado_grupo)){
      $nombre_grupo = $reg_grupo["nombre_grupo"];
    }
    mysqli_free_result($resultado_grupo);
  /**---------------------------------------------------------------------------------- */
  /**--Seleccionamos el nombre de la materia------------------------------------------- */
    $consulta_materia = "SELECT id_materia, nombre_materia FROM materia WHERE id_materia = '$materia_idmateria' AND estatus = '1' LIMIT 1";
    $resultado_materia = mysqli_query($conexion_database, $consulta_materia);

    while($reg_materia = mysqli_fetch_array($resultado_materia)){
      $nombre_materia = $reg_materia["nombre_materia"];
      //Lista de palabras conectivas comunes
      $palabras_conectivas = ["de", "y", "la", "en", "para", "con", "lo", "los", "las"];
      //dividimos el nombre de la materia en palabras usando espacio como delimitador
      $palabras = explode(" ", $nombre_materia);
      //inicializamos una variable para las siglas 
      $siglas = "";
      //Recorremos cada palabra
      foreach($palabras as $palabra){
        //verificamos si la palabra esta en la lista de las palabras conectivas
        if(!in_array(strtolower($palabra), $palabras_conectivas)){
          //tomamos la primera letra de la pablara y la convertimos en mayuscula
          $siglas .= strtoupper(substr($palabra, 0, 1));
        }
      }
    }
    mysqli_free_result($resultado_materia);
  /**---------------------------------------------------------------------------------- */
  /**-----------Seleccionamos el expediente del docente-------------------------------- */
  $consulta_docente_expediente = "SELECT empleados_expediente FROM docentes WHERE clave = '$clave' AND estatus = '1' LIMIT 1";
  $resultado_docente_expediente = mysqli_query($conexion_database, $consulta_docente_expediente);
  while($reg_docente_expediente = mysqli_fetch_array($resultado_docente_expediente)){
    $expediente = $reg_docente_expediente["empleados_expediente"];
  }
  mysqli_free_result($resultado_docente_expediente);
  /**---------------------------------------------------------------------------------- */
  $separa = explode("_",$punto); $dia_real= $separa[0]; $fila_real = $separa[1]; $columna_real = $separa[2];
  $separa_2 = explode("-",$hora); $hora_entrada = date("H:i:s", strtotime($separa_2[0])); $hora_salida = date("H:i:s", strtotime($separa_2[1]));

  if($dia_real=="lu"){$dia="LUNES";}
  if($dia_real=="ma"){$dia="MARTES";}
  if($dia_real=="mi"){$dia="MIERCOLES";}
  if($dia_real=="ju"){$dia="JUEVES";}
  if($dia_real=="vi"){$dia="VIERNES";}
  if($dia_real=="sa"){$dia="SABADO";}
  
  //Obtenemos el numero de la columna que pertenece al dia
  $columna=substr($columna_real, -1, 1);

  //Renombramos la etiqueta del grupo compacto para mostrar

  $etiqueta = $etiqueta_salon.'-'.$siglas;
  

  switch ($proceso){
    case 'Registro':
      /**---Corroboramos que no se duplique el registro----------------------------------------- */
        $consulta_comparar="SELECT iddetalle_carga FROM detalle_carga WHERE carga_idcarga='$carga_idcarga' AND clave_docente='$clave' AND punto='$punto' AND estatus='1' LIMIT 1";
        $resultado_comparar=mysqli_query($conexion_database, $consulta_comparar);
        $filas_comparar = mysqli_num_rows($resultado_comparar);

        mysqli_free_result($resultado_comparar);
      /**--------------------------------------------------------------------------------------- */

      /**--Insertamos registros si no hay datos duplicados-------------------------------------- */
        if($filas_comparar == 0){
          $inserta = "INSERT INTO detalle_carga(carga_idcarga, salon_idsalon, grupo_idgrupo, materia_idmateria, 
          clave_docente, expediente_docente, nombre_salon, nombre_grupo, nombre_materia, dia, hora_entrada, hora_salida,
          etiqueta, columna, punto, estatus, fecha_movimiento, ultimo_movimiento, usuario_movimiento)VALUES('$carga_idcarga',
          '$salon_idsalon','$grupo_idgrupo','$materia_idmateria','$clave', '$expediente','$nombre_salon','$nombre_grupo','$nombre_materia',
          '$dia','$hora_entrada','$hora_salida','$etiqueta','$columna','$punto','$estatus','$fecha','$proceso','$usuario')";
          $proceso_insert = mysqli_query($conexion_database, $inserta);
        }else{
          $comprobacion = "1";
        }
      /**--------------------------------------------------------------------------------------- */
    break;

    case 'Edicion':
      /**corroboramos que nose duplique el registro--------------------------------------------- */
        $consulta_comparar = "SELECT iddetalle_carga FROM detalle_carga WHERE iddetalle_carga <> '$id' AND clave_docente='$clave' AND punto = '$punto' AND estatus = '1' LIMIT 1";
        $resultado_comparar = mysqli_query($conexion_database, $consulta_comparar);
        $filas_comparar = mysqli_num_rows($resultado_comparar);

        mysqli_free_result($resultado_comparar);
      /**--------------------------------------------------------------------------------------- */

      /**Actualizamos registro si no hay datos duplicados--------------------------------------- */
        if($filas_comparar == 0){
          $actualiza="UPDATE detalle_carga SET carga_idcarga = '$carga_idcarga', salon_idsalon = '$salon_idsalon', grupo_idgrupo = '$grupo_idgrupo', materia_idmateria = '$materia_idmateria', clave_docente = '$clave', expediente_docente = '$expediente', nombre_salon = '$nombre_salon', nombre_grupo = '$nombre_grupo', nombre_materia = '$nombre_materia', dia = '$dia', hora_entrada = '$hora_entrada', hora_salida = '$hora_salida', etiqueta = '$etiqueta', columna = '$columna', punto = '$punto', estatus = '$estatus', fecha_movimiento = '$fecha', ultimo_movimiento = '$proceso', usuario_movimiento = '$usuario' WHERE iddetalle_carga = '$id' AND carga_idcarga='$carga_idcarga' LIMIT 1";
          $resultado_actualiza=mysqli_query($conexion_database, $actualiza);
        }else{
          $comprobacion = "1";
        }
      /**--------------------------------------------------------------------------------------- */
    break;
  }
  /**Seleccionamos los nuevos registros almacenados--------------------------------------------- */
  $consulta_1 = "SELECT iddetalle_carga FROM detalle_carga WHERE carga_idcarga='$carga_idcarga' AND clave_docente = '$clave' AND punto = '$punto' AND estatus ='1' LIMIT 1";
  $resultado_1=mysqli_query($conexion_database, $consulta_1);
  $filas_1 = mysqli_num_rows($resultado_1);

  while($reg_1=mysqli_fetch_array($resultado_1)){
    $id_1=$reg_1["iddetalle_carga"];
  }
  mysqli_free_result($resultado_1);
  /**------------------------------------------------------------------------------------------- */

  $lista_info = '';

  /**Lista de información de páginas------------------------------------------------------------ */
    $lista_info = $lista_info.='
      <td align="center" id="'.$punto.'" onclick="Modificar_carga_materia('.$id_1.');">
        <i class="fa-regular fa-file-lines ic_materia"></i>
        <div class="l_materia">
          '.$etiqueta.'
        </div>
      </td>
    ';
  /**------------------------------------------------------------------------------------------- */

  $array = array(
    0 => $punto,
    1 => $lista_info,
    2 => $comprobacion
  );

  echo json_encode($array);
  mysqli_close($conexion_database);
?>