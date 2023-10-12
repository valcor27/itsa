<?php 
session_start(); 

$id=$_POST["id"];

 if ($_SESSION['id_software_sesion'] == $id){

	session_destroy();
    $parametros_cookies = session_get_cookie_params(); 
    setcookie(session_name(),0,1,$parametros_cookies["path"]);
 }
?>