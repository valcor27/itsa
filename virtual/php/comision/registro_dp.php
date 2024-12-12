<?php
require("../conexion/conexion_bd.php");
require("../sesion/logueo.php");
require("../clases/limpiar.php");

$proceso = $_POST["proceso_comision_dp"];
$id = $_POST["id_comision_dp"];
$id_plaza = is_array($_POST["id_plaza"]) ? implode(',', $_POST["id_plaza"]) : $_POST["id_plaza"];
//$exp_emp_comision = is_array($_POST["exp_emp_comision"]) ? implode(',', $_POST["exp_emp_comision"]) : $_POST["exp_emp_comision"];
//$expedientes = isset($_POST["exp_emp_comision"]) ? implode(',', $_POST["exp_emp_comision"]) : $_POST["exp_emp_comision"];
$id_expedientes = $_POST["exp_emp_comision"];
sort($id_expedientes);
$expedientes = implode($id_expedientes);
$lugar = $_POST["lugar"];
$fecha = !empty($_POST["fecha_comision"]) ? date("Y-m-d", strtotime($_POST["fecha_comision"])) : null;
$n_comi = $_POST["n_comi"];
$folio = $_POST["folio_comision"];
$fecha_inicio = !empty($_POST["fInicio"]) ? date("Y-m-d", strtotime($_POST["fInicio"])) : null;
$fecha_fin = !empty($_POST["fFin"]) ? date("Y-m-d", strtotime($_POST["fFin"])) : null;
$hora_inicio = !empty($_POST["hora_incio"]) ? date("H:i:s", strtotime($_POST["hora_incio"])) : null;
$hora_fin = !empty($_POST["hora_fin"]) ? date("H:i:s", strtotime($_POST["hora_fin"])) : null;
$finalidad = $_POST["finalidad"];
$duracion = $_POST["duracion"];
$pais = $_POST["pais"];
$estado = $_POST["estado"];
$municipio = $_POST["municipio"];
$lugar_comision = $_POST["lugar_comision"];
$usuario = $id_software_sesion;
$estatus = 1;
$comprobacion = "0"; // Inicialmente asumimos éxito

date_default_timezone_set('America/Mexico_City');
$fecha_movimiento = date('Y-m-d');
/*
echo $proceso.' ,'.$id.' ,'.$id_plaza.' ,'.$expedientes.' ,'.$lugar.' ,'.$fecha.' ,'.$n_comi.' ,'.$folio.' ,'.$fecha_inicio.' ,'.$fecha_fin.' ,'.$hora_inicio.' ,'.$hora_fin.' ,'.$finalidad.' ,'.$duracion.' ,'.$pais.' ,'.$estado.' ,'.$municipio.' ,'.$lugar_comision.' ,'.$usuario.' ,'.$estatus.' ,'.$comprobacion.' ,'.$fecha_movimiento;*/

switch($proceso){
    case 'Registro':
        //Consulta para verificar si un empleado tiene incidencias o licencias
        $consulta_comparar_incidencia = "SELECT id_incidencia
            FROM incidencia
            WHERE ";
        if(count($id_expedientes) > 1){
            
        }else{
            //Si es solo un ID, verifica directamente ese ID
            $consulta_comparar_incidencia .= "()";
        }
    break;
}


mysqli_close($conexion_database);
?>
